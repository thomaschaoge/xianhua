<?php
//自定义Type信息控制类

class Type extends Controller
{
    //浏览信息
    public function indexs()
    {
        //实例化Model类
        $mod = new Model("type");
        //执行查询并将结果放置到对象中
        $sql="select * from type order by concat(path,id)";
		$this->list = $mod->query($sql);
        //加载模板输出
        //var_dump($this->list);
        $this->display("index");
    }
	    public function edit()
    {
        //实例化Model类
        $mod = new Model("type");
        //执行查询并将结果放置到对象中
        $this->list = $mod->find($_GET['id']);
        //加载模板输出
        //var_dump($this->list);
        $this->display("edit");
		
    }
    
    //加载添加表单
    public function add()
    {
        //获取父类别信息
		$type=['id'=>0,'name'=>'根类别','pid'=>0,'path'=>''];//默认根类别信息
		if(!empty($_GET['id'])){
			$mod=new Model("type");
			$type=$mod->find($_GET['id']);
		}
		$this->vo=$type;//将当前获取的类别信息放置的对象中作为vo属性的值
		$this->display("add");
    }
    //执行信息添加
    public function insert()
    {
        //实例化Model类
        $mod = new Model("type");
        //弥补要添加的信息
      
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
        $mod = new Model("type");
        
		//判断当前类别下是否有子类，若有则不允许删除
		$sql="select * from type where pid ={$_GET['id']}";
		if(count($mod->query($sql))>0){
			die("删除失败！禁止删除存在子类的类别！");
		}
		//执行删除操作
        $m = $mod->del($_GET['id']);
        //跳转浏览
        header("Location:".URL."/type/indexs");
    }
	public function update()
	{
		$mod=new Model("type");
		$m=$mod->update();
		if($m>0){
			echo "修改成功！";
		}else{
			echo "修改失败！";
		}
	}
    
}
