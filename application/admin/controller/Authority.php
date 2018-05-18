<?php
namespace app\admin\controller;
use app\blog\model\blog_information;
use think\Controller;
use think\Session;
use think\Request as Request;
use app\admin\model\authGroupAccess as AccessModel;
use app\admin\model\blogInformation as InformationModel;
use app\admin\model\authRule as RuleModel;
use app\admin\model\authGroup as GroupModel;
use think\Db;
class authority extends Base{
    public function index(){
        $id=Session::get('id');
        $req=Request::instance();
//        $Access = new AccessModel;
//        $list=$Access->paginate(8);
//        $this->assign('list',$list);
        $model=new AccessModel;
        $list=$model->paginate(5);
        $this->assign('list',$list);

        $page=$req->get('page');
        $page=isset($page)?($page-1)*5:0;
        $data=[
            ['tb_auth_group_access c','a.id=c.uid'],
            ['tb_auth_group b','c.group_id=b.id']
        ];
        $data=Db::table('tb_blog_information')->alias('a')->join($data)->field(['blog_user','title','a.id'])->limit($page,5)->select();
        $this->assign('data',$data);
        return $this->fetch();
    }

    public function power()
    {
        $req=Request::instance();
        $id=$req->get('id');
        Session::set('u_id',$id);
        $req=Request::instance();
        $model=new RuleModel;
        $data=$model->select();
        $this->assign('rule',$data);
        return $this->fetch();

    }
    public function updatarule()
    {
        $id = Session::get('u_id');
        $model = new GroupModel;
        $checked_value = input('post.checkbox/a');
        $checked_value = implode(',', $checked_value);
//        $data=$model->where('id',$id)->select();
        $result =$model->where('id',$id)->update(['rules'=>$checked_value]);
        if ($result)
        {
            return $this->success('修改成功','index');
        }else
        {
            return $this->error('修改失败','index');
        }

    }
}