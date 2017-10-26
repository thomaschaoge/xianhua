<?php
//网站前台Home主入口文件
session_start(); //开头session

//自动加载函数
function __autoload($cname)
{
   $fname = $cname.".php";
    //判断并加载
   if(file_exists("./Web/Controller/Home/".$fname)){
       require("./Web/Controller/Home/".$fname);
   }elseif(file_exists("./Web/Model/".$fname)){
       require("./Web/Model/".$fname);
   }elseif(file_exists("./Web/Org/".$fname)){
       require("./Web/Org/".$fname);
   }else{
       die("<h2>错误！{$cname}类加载失败！</h2>");
   }
}

//处理请求
//获取请求地址后有/作为分隔符拼成的字串信息，并解析成数组
$pathinfo = explode("/",trim($_SERVER['PATH_INFO'],"/"));
//print_r($pathinfo);
//获取请求类名，若没有则默认为index
$className =ucfirst(!empty($pathinfo[0])?$pathinfo[0]:"index"); 
//获取请求的方法名，若没有则默认为indexs
$method = !empty($pathinfo[1])?$pathinfo[1]:"indexs"; //方法

//定以常量
//定义当前页面的URL地址
define("URL",$_SERVER['SCRIPT_NAME']);
//定义公共资源目录
define("_PUBLIC_",dirname($_SERVER['SCRIPT_NAME'])."/Public/");
//定义当前控制器类名
define("CONTROLLER",$className);
//定义方法名
define("METHOD",$method);

//导入配置文件
require("./Web/Conf/config.php");
//导入公共函数库
require("./Web/Common/functions.php");

//实例化并调用执行
$controller = new $className();
$controller->run($method);