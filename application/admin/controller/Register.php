<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;
use think\Db;
use \think\Request as Request;
use \app\admin\model\blogInformation as InformationModel;
class register extends \think\Controller
{
    //注册的模板界面
    public function register()
    {
        echo $this->fetch();
    }
    //注册的检查模板界面
    public function registercheck()
    {
        $req = Request::instance();
        if ($req->has('sub','post')) {
            if ($_POST['user'] != "" && $_POST['password'] != "" && $_POST['captcha'] != '' && $_POST['captcha'] == $_POST['password'])
            {
                $name = $req->post('user');
               $information = new InformationModel();
               $is_name = $information->where('blog_user',$name)->find();
                if( $is_name == false ){
                    $pw = $req->post('password');
                    $data = ['blog_user'=> $name, 'blog_password'=> $pw];
                    $result = $information->save($data);
                    if($result){
//                        $this->success('注册成功','Login/login');
//                        echo "<script>alert('注册成功')</script>";
                        return $this->success('注册成功','Login/login');
                    }
                }else{
                        echo "<script>alert('用户已被注册')</script>";
                        return $this->fetch('register');
                }
                }else
            {
                echo "<script>alert('内容不能为空或者两次密码不一致')</script>";
                return $this->fetch('register');
            }
            }


        }
}
