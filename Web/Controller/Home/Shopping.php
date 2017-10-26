<?php 
session_start(); //开启session 
class Shopping extends Controller
{	
	public function shops()
	{
		if(CONTROLLER!== "Login" && empty($_SESSION['homeuser'])){
			$url = URL."/Login/logins";
			header("Location:{$url}");
			exit();
        }else{
			$this->display("shop");
		}
	}
    public function add()
	{
		$mod = new Model("goods");
        $id = $_GET['id'];
        $shop = $mod->find($id);
        $shop['m'] = 1; //初始化购买数量
        //判断购物车session中是否已放入此商品
        if(!empty($_SESSION['shoplist'][$id])){
			$_SESSION['shoplist'][$id]['m']+=1; //购买量加一
        }else{
			$_SESSION["shoplist"][$id] = $shop; //将要购买的商品信息放入session中（购物车中）
        }
		//echo "成功放入购物车！";
		header("LOCATION:".URL."/shopping/shops");
		//$this->display("shop");
	}
	public function del()
	{
		$mod = new Model("goods");
        $id = $_GET['id'];
        $shop = $mod->find($id);
		unset($_SESSION['shoplist'][$_GET['id']]);
        header("LOCATION:".URL."/Shopping/shops");
		//$this->display("shop");
	}
	public function edit()
	{
		$_SESSION['shoplist'][$_GET['id']]['m'] += $_GET['m'];
        //判断购买量是否合法
        if($_SESSION['shoplist'][$_GET['id']]['m']<1){
            $_SESSION['shoplist'][$_GET['id']]['m'] = 1;
        }
        header("LOCATION:".URL."/shopping/shops");
		//$this->display("shop");
	}
	public function clear()
	{
		$mod = new Model("goods");
        $id = $_GET['id'];
        $shop = $mod->find($id);
		unset($_SESSION['shoplist']);
        header("LOCATION:".URL."/Shopping/shops");
		//$this->display("clear");
	}

}

