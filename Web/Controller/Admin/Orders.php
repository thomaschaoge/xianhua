<?php
//自定义Users信息控制类

class Orders extends Controller
{
    //浏览信息
    public function indexs()
    {
        //实例化Model类
        $mod = new Model("orders");
        //执行查询并将结果放置到对象中
        if(!empty($_GET['linkman'])){
			$mod->where("linkman like '%{$_GET['linkman']}%'");
			}
		
		$page = new Page($mod ->count(),8);
		$this->list = $mod->limit($page->limit())->select();
		$this->p = $page->show();
		
        //加载模板输出
        //var_dump($this->list);
        $this->display("index");
    }
    
    //加载添加表单
    public function add()
    {
        $this->display("add");
    }
	
	public function edit()
    {
        //实例化Model类
        $mod = new Model("orders");
        //执行查询并将结果放置到对象中
        $this->list = $mod->find($_GET['id']);
        //加载模板输出
        //var_dump($this->list);
        $this->display("edit");
		
    }
    //执行信息添加
    public function insert()
    {
        //实例化Model类
        $mod = new Model("orders");
        //弥补要添加的信息
		$_POST['pass'] = md5($_POST['pass']);
        $_POST['addtime'] = time();
        //执行添加
        $m = $mod->insert();
        //判断并跳转                      
        if($m>0){
            echo "添加成功！";
        }else{
            echo "添加失败！";
        }
    }
    
    public function del()
    {
        //实例化Model类
        $mod = new Model("orders");
        //执行删除操作
        $m = $mod->del($_GET['id']);
        //跳转浏览
        header("Location:".URL."/orders/indexs");
    }
	public function update()
	{
		$mod=new Model("orders");
		$m=$mod->update();
		//echo $m;
		if($m>0){
			echo "修改成功！";
		}else{
			echo "修改失败！";
		}
	}
	public function detail()
	{
		$mod=new Model("detail");
		$sql="select * from detail where orderid ={$_GET['id']}";
		$this->list = $mod -> query($sql);
		$this->display("detail");
	}
    
}
