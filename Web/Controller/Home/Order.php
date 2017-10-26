<?php
session_start(); //开启session 
class Order extends Controller
{

	public function orders()
	{
		$this->display("order");
	}
	public function check()
	{
		$this->display("checkorder");
	}
	public function add()
	{
		
		$this->display("addorder");
	}
	public function detail()
	{
		
		$mod=new Model("detail");
		$mod2 = new Model("orders");
		$this->list =  $mod2->select();
		//echo "<pre>";
		
	 	foreach($this->list as &$v){
			//echo "aaaaa";
			//echo $v['id'];
			$v['detail'] = $mod->query(" select * from detail where orderid = ".$v['id']);
		} 
		//var_dump($this->list);
		//$this->list = array();
		$this->display("detail");
	}
	
	public function edit()
	{
		$mod = new Model('orders');
		
		$a = array('id'=>$_GET['id']);
		
		if($_GET['a'] = 'd'){
			$a['status'] = 2;
		}elseif($_GET['a'] = 'c'){
			$a['status'] =3;
		}
		
		
		$m = $mod->update($a);
		
		
		
	}
	
	
	
}			
