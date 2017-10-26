<?php


//默认入口控制器Index

class Index extends Controller
{
    //默认加载方法
    public  function indexs()
    {
        //echo "<h1>欢迎访问自定义框架！</h1>";
        
        //获取并输出后台访问入口
        //$url = dirName(URL)."/admin.php";
        //echo "<a href='{$url}'>进入网站后台</a>";
		 $mod=new Model("goods");
		 if(!empty($_GET['tid'])){
			 $mod->where("num in(select * from goods where order by num) limit 8");
		 }
		 $this->goodsrx=$mod->select();
		 
		 if(!empty($_GET['tid'])){
			 $mod->where("typeid in(select * from goods where order by addtime asc) limit 8");
		 }
		 $this->goodsxp=$mod->select();
		 
		 
		 $this->display("index");
	}
    public function list()
	{
		$mod=new Model("goods");
		//判断封装搜索条件
		if(!empty($_GET['tid'])){
			$mod->where("typeid in(select id from type where path like '%,{$_GET['tid']},%')");
		}
		
		
		$this->goodslist=$mod->select();
		$this->display("list");
	}
	public function detail()
	{
		//获取对应商品详情信息
		$mod=new Model("goods");
		$this->goods=$mod->find($_GET['id']+0);
		
		$this->display("detail");
		
	}
	
	
}