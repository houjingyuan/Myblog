<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;
use think\Db;
use think\Request as Request;
use app\admin\model\blogArticle as ArticleModel;
use app\admin\model\category as CategoryModel;
date_default_timezone_set('PRC');
setlocale(LC_ALL,'c');
class Administration extends \think\Controller
{
    //发布文章
    public function index()
    {
        if (isset($_POST['sub'])) {
            if ($_POST['title'] != "" && $_POST['sketchy'] != "" && $_POST['article'] != "") {
                $title = $_POST['title'];
                $sketchy = $_POST['sketchy'];
                $article = $_POST['article'];
                $time = date('Y-m-d H:i:s');
                $admin = Session::get('name');
                $model=new ArticleModel;
                $data=['title'=>$title,
                       'article'=>$article,
                       'sketchy'=>$sketchy,
                        'time'=>$time,
                        'admin'=>$admin,
                    ];
               $result= $model->save($data);
               if($result>0)
               {
                   echo "<script> alert('添加完成');</script>";
               }else{
                   echo "<script>alert('添加失败')</script>";
               }

            } else {
                echo "<script> alert('输入内容不能为空');</script>";
            }
        }
        return $this->fetch();
    }
    //我的文章
    public function release(Request $re)
    {
        $name=Session::get('name');
        $ArticleModel= new ArticleModel;
        $list=$ArticleModel->where('admin',$name)->paginate(8);
        $this->assign('list',$list);
        $page=$re->get('page');
        $page=isset($page)?($page-1)*8:0;

        $information=$ArticleModel->where('admin',$name)->limit($page,8)->select();
//        $sql="select * from tb_blog_article where admin='$name'";
//        $information = Db::query($sql);
        $this->assign('article', $information);
        return  $this->fetch();
    }
    public function delete()
    {
        $req=Request::instance();
        $id=$req->get('id');
        ArticleModel::destroy(['id'=>$id]);
        return $this->success('删除成功','release');
    }
    //修改文章
    public function update()
    {
        $Request = Request::instance();
        if($Request->has('id')){
            $id=$Request->get('id');
            $ArticleModel = new ArticleModel();
            $Date=$ArticleModel->where(['id'=>$id])->select();
//            dump($Date);
            $this->assign([
                'id'=>$Date[0]['id'], // or  $id  ps:文章id
                'title'=>$Date[0]['title'], //文章标题
                'article'=>$Date[0]['article'], //内容
                'sketchy'=>$Date[0]['sketchy'], //文章简介

            ]);
        }
        return $this->fetch();
    }
    //修改文章
    public function ArUpdate(){
        $Request = Request::instance();
        if($Request->has('title') &&   $Request->has('sketchy') &&   $Request->has('article')) {
            $id=$Request->post('article_id'); //id
            $title=$Request->post('title'); //标题
            $sketchy=$Request->post('sketchy'); //简介
            $article=$Request->post('article'); //内容
            $time = date('Y-M-D H:I:S');  //当前时间
            $data = array([
                'title' => $title,
                'sketchy' => $sketchy,
                'article' => $article,
                'time' => $time,
            ]);
//           dump($data);
//           exit();
            $ArticleModel = new ArticleModel();
            $retuen = $ArticleModel->query("UPDATE  tb_blog_article SET title = '$title', sketchy = '$sketchy', article = '$article',time='$time' WHERE id = '$id'");
            if($retuen>-1){
                  return $this->success('更新成功','release');
            }else
            {
                return $this->success('更新失败','release');
            }
        }
        echo  $Request->post('article_id');
    }
    //文章类型
    public function category()
    {
        $cateModel=new  CategoryModel;
        $cateData=$cateModel->where('f_id',0)->field(['id','name'])->select();
        $this->assign('cateData',$cateData);
        return $this->fetch();
    }

    public function firstSelect(Request $re){
        $cate_id=$re->post('value');

        $cateModel=new  CategoryModel;
        $cateData=$cateModel->where('f_id',$cate_id)->field(['id','name'])->select();

        $str_select='';
        foreach ($cateData as $k=>$v)
        {
            $str_select.='<option value='.$v['id'].'>'.$v['name'].'</option>';
        }

        echo $str_select;
    }
}
?>