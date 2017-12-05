<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/4
 * Time: 3:25
 *
 * 框架函数库
 */

/**
 * 打印一个变量
 * @param mixed $var 打印变量
 */
function p($var)
{
    if (is_bool($var) || is_null($var)) {
        var_dump($var);
    } else {
        echo '<pre>' . print_r($var, true) . '</pre>';
    }
}

define('API_HOST', 'xietest.money.xiaoshushidai.com');
//调用api
function v35_post($action, $data = array(), $return_array = false)
{
    $host = 'http://' . API_HOST;

    $url = $host . '/' . $action;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'X-Forwarded-For:' . get_client_ip()));
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
    if (!empty($data) && count($data) > 0) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    }

    $http_response = curl_exec($curl);

    //var_dump($http_response);exit;
    $info = curl_getinfo($curl);

    curl_close($curl);
    $data = json_decode($http_response, $return_array);
    if ($data)
        return $data;
    else
        return $http_response;
}

//获取客户端IP
function get_client_ip()
{
    //使用wap时，是通过中转方式，所以要在wap/index.php获取客户ip,转入到:sjmapi上 chenfq by add 2014-12-17
    if (isset($GLOBALS['request']['client_ip']) && !empty($GLOBALS['request']['client_ip']))
        $ip = $GLOBALS['request']['client_ip'];
    else if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
        $ip = getenv("REMOTE_ADDR");
    else if (isset ($_SERVER ['REMOTE_ADDR']) && $_SERVER ['REMOTE_ADDR'] && strcasecmp($_SERVER ['REMOTE_ADDR'], "unknown"))
        $ip = $_SERVER ['REMOTE_ADDR'];
    else
        $ip = "unknown";
    return strim($ip);
}

function strim($str)
{
    return quotes(htmlspecialchars(trim($str)));
}

function quotes($content)
{
    //if $content is an array
    if (is_array($content)) {
        foreach ($content as $key => $value) {
            //$content[$key] = mysql_real_escape_string($value);
            $content[$key] = addslashes($value);
        }
    } else {
        //if $content is not an array
        $content = addslashes($content);
        //mysql_real_escape_string($content);
    }
    return $content;
}

function to_date($utc_time, $format = 'Y-m-d H:i:s')
{
    if (empty ($utc_time)) {
        return '';
    }
    $timezone = 8;//intval(app_conf('TIME_ZONE'));
    $time = $utc_time + $timezone * 3600;
    return date($format, $time);
}

//返回零时区时间（GMT）
function to_timespan($str, $format = 'Y-m-d H:i:s')
{
    $timezone = intval(app_conf('TIME_ZONE'));
    //$timezone = 8;
    $time = intval(strtotime($str));
    if ($time != 0)
        $time = $time - $timezone * 3600;
    return $time;
}

define("CHARSET", "utf-8");
/**
 * 字符串切割函数，一个字母算一个位置,一个字算2个位置
 *
 * @param string $string 待切割的字符串
 * @param int $length 切割长度
 * @param string $dot 尾缀
 */
function strCut($string, $length, $dot = '') {
	$string = str_replace(array('&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;', '&emsp;'), array(' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…', ' '), $string);
	$strlen = strlen($string);
	if ($strlen <= $length)
		return $string;
	$maxi = $length - strlen($dot);
	$strcut = '';
	if (strtolower(CHARSET) == 'utf-8') {
		$n = $tn = $noc = 0;
		while ($n < $strlen) {
			$t = ord($string[$n]);
			if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1;
				$n++;
				$noc++;
			} elseif (194 <= $t && $t <= 223) {
				$tn = 2;
				$n += 2;
				$noc += 2;
			} elseif (224 <= $t && $t < 239) {
				$tn = 3;
				$n += 3;
				$noc += 2;
			} elseif (240 <= $t && $t <= 247) {
				$tn = 4;
				$n += 4;
				$noc += 2;
			} elseif (248 <= $t && $t <= 251) {
				$tn = 5;
				$n += 5;
				$noc += 2;
			} elseif ($t == 252 || $t == 253) {
				$tn = 6;
				$n += 6;
				$noc += 2;
			} else {
				$n++;
			}
			if ($noc >= $maxi)
				break;
		}
		if ($noc > $maxi)
			$n -= $tn;
		$strcut = substr($string, 0, $n);
	} else {
		$dotlen = strlen($dot);
		$maxi = $length - $dotlen;
		for ($i = 0; $i < $maxi; $i++) {
			$strcut .= ord($string[$i]) > 127 ? $string[$i] . $string[++$i] : $string[$i];
		}
	}
	$strcut = str_replace(array('&', '"', "'", '<', '>'), array('&amp;', '&quot;', '&#039;', '&lt;', '&gt;'), $strcut);
	return $strcut . $dot;
}

function xsSubstr($str, $length, $start = 0, $charset = "utf-8", $suffix = true) {
	return strCut(strip_tags($str), $length, '...');
}