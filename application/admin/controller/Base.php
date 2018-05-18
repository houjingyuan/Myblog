<?php
namespace app\admin\controller;

use think\Controller;
use think\auth\Auth;
use think\Request;
use think\Session;

class Base extends Controller{
   public function _initialize()
    {
        $re=Request::instance();
        $module=$re->module();   //模块名
        $controller=$re->controller();    //控制器
        $action=$re->action();    //方法
        $path=$module.'-'.$controller.'-'.$action;

        $id=Session::get('id');      //获取用户id

        $Auth=new Auth();
        $result=$Auth->check($path,$id);
        if($result)
        {

        }
        else
        {
            $this->error('没此权限！');
            exit();
        }
    }
}