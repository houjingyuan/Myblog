<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Db;
use \think\Session;
use think\Request as Request;
use app\admin\model\blogArticle as ArticleModel;
use \app\admin\model\blogInformation as InformationModel;
class Table extends \think\Controller
{
    //搜索文章界面
    public function index()
    {
//        $search=$_POST['search'];
//        var_dump($search);
        $sql="select * from tb_blog_article where concat(title,admin) like '%null%'";
        $article=Db::query($sql);
        $Request=Request::instance();

//        $model->where(" concat(title,article,admin) like \'%null%\' ")->select();
//        if($Request->has('sub')){
//            $search=$Request->post('search');
//            $sql="select * from tb_blog_article where concat(title,article,admin) like '%$search%'";
//            $article=Db::query($sql);
//
//        }
        if(isset($_POST['sub']))
        {
            if(!empty($_POST['search']))
            {
                $search=$Request->post('search');
                $sql="select * from tb_blog_article where concat(title,admin) like '%$search%'";
                $article=Db::query($sql);
            }  else {
                echo "<script> alert('输入项不能为空');</script>";
            }
        }
        $this->assign([
            'article'=>$article,
        ]);
        return  $this->fetch('index');
    }
    //阅读全文
    public function read()
    {
        $req=Request::instance();
        $id=$req->get('id');
        $ArticleModel= new ArticleModel;
        $title=$ArticleModel->where('id',$id)->select();
//        $title=Db::query('select title from tb_blog_article where id='.$id);
//        var_dump($title);
//        exit();
        $this->assign('title',$title[0]['title']);
//        $article=Db::query('select article from tb_blog_article where id='.$id);
        $article=$ArticleModel->where('id',$id)->select();
        $this->assign('article',$article[0]['article']);
        return  $this->fetch();
    }

    public function arr()
    {
        $beginning = 'foo';
        $end = array(1 => 'bar');
        $result = array_merge((array)$beginning, (array)$end);
        print_r($result);
    }
}
?>