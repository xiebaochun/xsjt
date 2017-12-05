<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/4
 * Time: 16:37
 */

namespace app\controller;

use core\lib\Request;
use core\lib\Controller;
use core\lib\Model;
use core\lib\Cache;
use core\lib\Config;
use core\lib\connection\Redis;
use core\lib\CSRF;
use core\lib\Session;
use core\lib\Debug;
//use \core\lib\Response;

/**
 * Class IndexController
 * @package app\controller  可以不继承父类
 */
class IndexController extends Controller
{

    public function index()
    {
        //Response::send();
        // 获取表单参数
        // $name = Request::get("name");
        // $user = Request::post("user");
        // echo 'get:'.$name . '<br>';
        // echo 'post:'.$user . '<br>';

        // // 缓存
        // Cache::set("cache_name", 1, 60);
        // Cache::inc("cache_name", 2);
        // $var = Cache::get("cache_name");
        // echo 'cache:'.$var . '<br>';

        // // 获取配置
        // // 这里的 p() 函数是打印数组的自定义函数
        // $all_config = Config::get();
        // echo 'all_config:' ;
        // p($all_config);

        // // Redis 连接
        // // db 选择 1
        // $redis = Redis::getInstance(3);
        // $redis->set("test", "redis_test_value", 5);
        // $var = $redis->get("test");
        // echo $var . '<br>';


        // //CSRF token
        // echo 'CSRF-Token : ' . CSRF::getToken() . '<br>';


        // //session
        // $a = array(1 => 2, 3 => 4);
        // Session::set('session_test', $a);
        // p(Session::get('session_test'));

        // p($_SERVER);
        // Debug::remark("b");
        // echo Debug::getRangeTime('a','b');
        $this->display('index.html');
    }

    public function business(){
        $this->assign('index', Request::get("a") ? Request::get("a") : '1');
        $this->display('pages/business.html');
    }

    public function contact(){
        $this->assign('index', Request::get("a") ? Request::get("a") : '1');
        $this->display('pages/contact.html');
    }

    public function news(){
        $index = Request::get("a") ? Request::get("a") : '1';
        $id = Request::get("id") ? Request::get("id") : 'null';
        $this->assign('index', $index);
        if($index == 1){
            $page = Request::get("page") ? Request::get("page") : '1';
            $result = v35_post('ajax-group_article_list&p='.$page);
            // p($result->list);
            $this->assign('page', $page);
            $this->assign('count', $result->count);
            $this->assign('list', $result->list);
        }

        if($id){
            $article = v35_post('ajax-group_article_detail?id='.$id);
            //p($article);
            $this->assign('id', $id);
            $this->assign('_article', $article);
        }

        $this->display('pages/news.html');
    }

    public function partner(){
        $this->display('pages/partner.html');
    }

    public function recruit(){
         $this->assign('index', Request::get("a") ? Request::get("a") : '1');
        $this->display('pages/recruit.html');
    }

    public function tree(){
        // var_dump(Request::get("a"));die;
        $this->assign('index', Request::get("a") ? Request::get("a") : '1');
        $this->display('pages/tree.html');
    }

    public function save_visitor_info(){
        $name = $_REQUEST['name'];
        $phone = $_REQUEST['phone'];
        $email = $_REQUEST['email'];
        $message = $_REQUEST['message'];
        // echo json_encode(array('name'=>$name,'phone'=>$phone,'email'=>$email,'message'=>$message));
        // exit;
        //$result = v35_post('ajax-group_save_visitor_info',array('name'=>$name,'phone'=>$phone,'email'=>$email,'message'=>$message));
        $result = v35_post('ajax-group_save_visitor_info?name='.$name.'&phone='.$phone.'&email='.$email.'&message='.$message);
        //echo json_encode('ajax-group_save_visitor_info?name='.$name.'&phone='.$phone.'&email='.$email.'&message='.$message);
        echo json_encode($result);
    }

}