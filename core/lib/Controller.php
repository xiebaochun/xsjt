<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/4
 * Time: 17:01
 *
 * 控制器类
 */

namespace core\lib;

use core\lib\Route;

class Controller
{

    public $assign;
    public function display($view = '')
    {
        /*
         * 显示view模板
         */
        $file = APP.'view/'.$view;
        if(is_file($file)){
            if($this->assign){
                extract($this->assign);
            }
            include $file;
        }
    }

    public function assign($name, $value)
    {
        $this->assign[$name] = $value;
    }

    public function getAction(){
        return Route::getAction();
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        throw  new \Exception(get_class($this).'中找不到此方法:'.$name);
    }
}