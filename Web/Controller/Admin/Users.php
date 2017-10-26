<?php
//自定义Users信息控制类

class Users extends Controller
{
    //浏览信息
    public function indexs()
    {
        //实例化Model类
        $mod = new Model("users");
        //执行查询并将结果放置到对象中
        if(!empty($_GET['username'])){
			$mod->where("username like '%{$_GET['username']}%'");
			}
		
		$page = new Page($mod ->count(),4);
		$this->list = $mod->limit($page->limit())->select();
		$this->p = $page->show();
		
        //加载模板输出
        //var_dump($this->list);
        $this->display("index");
    }
    
	public function edit()
    {
        //实例化Model类
        $mod = new Model("users");
		 $_POST['pass'] =md5($_POST['pass']);
        //执行查询并将结果放置到对象中
        $this->list = $mod->find($_GET['id']);
        //加载模板输出
        //var_dump($this->list);
        $this->display("edit");
		
    }
	
    //加载添加表单
    public function add()
    {
        $this->display("add");
    }
    //执行信息添加
    public function insert()
    {
        //实例化Model类
        $mod = new Model("users");
        //弥补要添加的信息
        $_POST['pass'] =md5($_POST['pass']);
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
        $mod = new Model("users");
        //执行删除操作
        $m = $mod->del($_GET['id']);
        //跳转浏览
        header("Location:".URL."/users/indexs");
    }
	public function update()
	{
		$mod=new Model("users");
		$m=$mod->update();
		//echo $m;
		if($m>0){
			echo "修改成功！";
		}else{
			echo "修改失败！";
		}
	}
    
}
