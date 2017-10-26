<?php
//控制器类的基类（父类）
class Controller
{
    //定义构造方法
    public function __construct()
    {
        //echo "controller";
        //echo _PUBLIC_;
        //判断当前不是执行登录操作，并且没有登录，就跳转到登录页
        if(CONTROLLER!== "Login" && empty($_SESSION['adminuser'])){
            //跳转到登录页
            $url = URL."/Login/logins";
            header("Location:{$url}");
            exit();
        }
    }
    
    
    
    //负责执行子类中的方法
    public function run($method){
        //判断方法是否存在
        if(method_exists($this,$method)){
            $this->$method();//调用此方法 
        }else{
            die("<h2>你调用的方法{$method}不存在！</h2>");
        }
    }
    
    //加载模板方法
    public function display($tpl)
    {
        //获取当前控制器类名，作为模板加载路径的一部分
        $cname = CONTROLLER; //get_class($this);
        require("./Web/View/Admin/{$cname}/".$tpl.".html");
        
    }
}