<?php
namespace app\admin\controller;
use lizi\example1;
use \think\Db;
use \think\Controller;
use \think\Session;
use \think\captcha\Captcha as Captcha;
use \app\admin\model\blogInformation as InformationModel;
class Login extends \think\Controller
{
    //登录的主界面
    public function login()
    {
      return  $this->fetch();
    }
    //对比数据库进行查询登录
    public function logincheck()
    {
        $user_name=input('user');
        $user_psd=input('password');
        $captcha = input('captcha');
        $cat = new Captcha();
        $bool = $cat->check($captcha);
        if($bool){
            $data= new informationModel;
            $row=$data->where(['blog_user'=>$user_name,'blog_password'=>$user_psd])->select();
//            $row=Db::query("select * from tb_blog_information where blog_user='$user_name' and blog_password='$user_psd'");
            if(!empty($row)){
                Session::set('id',$row[0]['id']);
                Session::set('name',$row[0]['blog_user']);
                $this->success('登录成功','Index/index');

            }else{
                echo $this ->error('请重新登录','Login');
            }
        }else{
            return $this->error('请检查您的用户名或者密码','Login');
        }

    }
    public function captcha(){
        $cap = new Captcha();
        return $cap->entry();
    }

}
?>