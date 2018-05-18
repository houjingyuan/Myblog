<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;

class loginout extends \think\Controller{
    //登出界面
    public function index()
    {
        Session::delete('name');
        Session::delete('id');
        return $this->success('退出成功','Login/login');
    }

    public function dir(){
        $b=file_get_contents('D:\php\config.php');
        var_dump($b);
        $c=str_replace('  \'default_validate\'       => \'\'','321',$b);
        var_dump($c);
        file_put_contents('D:\php\config.php',$c);
    }
}
?>