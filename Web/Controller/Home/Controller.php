<?php
//控制器类的基类（父类）
class Controller
{
	
	public function __construct()
	{
		//加载页头信息
		$tpmod=new Model("type");
		$tplist=$tpmod->where("pid=0")->select();
		foreach($tplist as &$v){
			$v['zlist']=$tpmod->where("pid=".$v['id'])->select();
		}
		
		$this->tplist=$tplist;
		//加载页脚信息
		
		//加载其他公共信息。。。
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
        require("./Web/View/Home/{$cname}/".$tpl.".html");
        
    }
}