<?php
namespace app\admin\controller;
use \think\Controller;
class Regexp extends \think\Controller{
    public function index(){
        $str = "abcd2[123456789yiue";
        $url = "fjawlfhttp://www.xxx.comamwaefowefo";
        $html = "<div class=\"ajflwfwl\" ><p id='awlflwe'>content</p><p id='feje'>content</p><p id='awlflwe'>content</p><p id='awlflwe'>content</p></div>";
//        $preg_str = "/h.*m/";
//        $preg_str = "/[\w]{4}:\/\/[\w]{3}.[\w]{3}.[\w]{4}/";
//        $preg_str = "/<p[\s][\w]{2}='[\w]*'>([\w]*)<\\/p>/";
        $preg_str = "/<p[\s][\w]{2}='[\w]*'>[\w]*<\\/p>/";
        $result_arr = [];
        //从字符串中取出数字
        preg_match_all($preg_str,$html,$result_arr);
        var_dump($result_arr);
    }
}
?>