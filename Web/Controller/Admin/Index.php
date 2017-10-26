<?php
//默认入口控制器Index

class Index extends Controller
{
    //默认加载方法
    public  function indexs()
    {
        //加载首页模板
        $this->display("index");
    }
    
    //加载页头
    public function top()
    {
        $this->display("top");
    }
    
    //加载导航
    public function menu()
    {
        $this->display("menu");
    }
	//加载swich选择滑块
    public function switch()
    {
        $this->display("switch");
    }
    
    //加载主体内容
    public function main()
    {
        $this->display("main");
    }
    //加载主体内容
    public function bottom()
    {
        $this->display("bottom");
    }
}