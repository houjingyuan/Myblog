<?php
namespace app\admin\controller;
use \think\Controller;
use app\admin\model\blogInformation as InformationModel;
use \think\Session;

class personal extends Base {
    public function index()
    {
        $name=Session::get('name');
        $this->assign('name',$name);
        $information = new InformationModel;
        $sex=$information->where('blog_user',$name)->select();
        $this->assign('sex',$sex[0]['sex']);

        echo $this->fetch();
    }

}