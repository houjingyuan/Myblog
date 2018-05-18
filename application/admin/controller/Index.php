<?php
namespace app\admin\controller;
use \think\Db;
use think\Request as Request;
use \think\Session;
use \think\Controller;
use app\admin\model\blogArticle as ArticleModel;
use think\Config as Config;
use think\Cache as Cache;
class Index extends Base
{
    //既是全部文章也是主页
    public function index(Request $re)
    {
        $ArticleModel= new ArticleModel;
        $row = Config::get('paginate');
        $list=$ArticleModel->paginate($row['list_rows']);
        $this->assign('list', $list);
        $page=$re->get('page');
        $page=isset($page)?($page-1)*$row['list_rows']:0;

        $information=$ArticleModel->limit($page,$row['list_rows'])->select();
        $this->assign('article', $information);
        return  $this->fetch();
    }
    //查看文章
    public function read()
    {
        $req=Request::instance();
        $id=$req->get('id');

        $ArticleModel= new ArticleModel;
        $title=$ArticleModel->where('id',$id)->find();
//        var_dump($title);
//        exit();
        $this->assign('title',$title[0]['title']);
        $article=$ArticleModel->where('id',$id)->find();
        $this->assign('article',$article[0]['article']);
        return  $this->fetch();
    }
    //修改分页
    public function paginate()
    {
        $req= Request::instance();
        if($req->has('paginate')){
            $data=$req->post('paginate');
            if($data>0)
            {
                $a=file_get_contents('D:\phpStudy\WWW\houzi\application\config.php');
                $str="/'l.*s'.*=>.[\d]*/";
                preg_match_all($str,$a,$result);
//       var_dump($result);
                if($result){
                    $b=str_replace($result[0],"'list_rows' => $data",$a);
                    file_put_contents('D:\phpStudy\WWW\houzi\application\config.php',$b);
                    echo "<script>alert('设置成功')</script>";
                }
            }else{
                echo "<script>alert('请输入一个大于0的整数')</script>";
            }
        }
        return $this->fetch();
    }
    //上传文件
    public function img()
    {
        $req = Request::instance();
        $file = $req->file('img');
        if($file){
            $info =$file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                $path= '/public' . DS . 'uploads/'.$info->getSaveName();
                $this->assign('path',$path);
                return $this->fetch();
                echo "<script>alert('上传成功')</script>";
            }else{
                echo "<script>alert('上传失败')</script>";
                echo $file->getError();
            }
        }
        return $this->fetch();

    }
    //清除缓存
    public function cache()
    {
        $req = Request::instance();
        if($req->has('cache')){
            $cache=$req->post('cache');
            if($cache){
                Cache::clear();
                echo "<script>alert('已成功清除缓存')</script>";
            }else{
                echo "<script>alert('未成功清除缓存')</script>";
            }
        }

        return $this->fetch();
    }

}
