<?php
//自定义Goods商品信息控制类

class Goods extends Controller
{
    private $path = "./Public/uploads/"; //上传文件存储目录
    private $types = array("image/jpeg","image/png","image/gif"); //允许上传文件类型
    
    //浏览信息
    public function indexs()
    {
           //实例化Model类
        $mod = new Model("Goods");
		//执行查询并将结果放置到对象中
        if(!empty($_GET['goods'])){
			$mod->where("goods like '%{$_GET['goods']}%'");
			}
		
		$page = new Page($mod ->count(),5);
		$this->list = $mod->limit($page->limit())->select();
		$this->p = $page->show();
		
        //加载模板输出
        //var_dump($this->list);
        $this->display("index");
    }
    
    //加载添加表单
    public function add()
    {
        //获取类别信息
        $mod = new Model("type");
        $sql = "select * from type order by concat(path,id)";
        $this->typeList = $mod->query($sql);
        //var_dump($this->typeList);
        //加载模板
        $this->display("add");
    }
    
    //执行添加
    public function insert()
    {
        //执行图片上传
        $upload = new FileUpload($_FILES['picname']);
        $upload->path = $this->path; //上传文件存储目录
        $upload->typeList = $this->types; //允许上传文件类型
        if(!$upload->upload()){
            die("图片上传失败！原因：".$upload->errinfo);
        }
        //执行缩放
        imageResize($upload->fileName,$this->path,70,70,"s_");
        imageResize($upload->fileName,$this->path,175,175,"m_");
        imageResize($upload->fileName,$this->path,328,328,"");
        //弥补其他添加信息
        $_POST['picname'] = $upload->fileName;
        $_POST['state'] = 1;
        $_POST['num'] = 0;
        $_POST['clicknum'] = 0;
        $_POST['addtime'] = time();
        
        //执行商品信息添加
        $mod = new Model("goods");
        $m = $mod->insert();
        //判断成功与否
        if($m>0){
            //添加成功
            echo "添加成功！";
        }else{
            echo "添加失败！";
            @unlink($this->path."s_".$upload->fileName);
            @unlink($this->path."m_".$upload->fileName);
            @unlink($this->path.$upload->fileName);
        }  
    }
    
    //加载编辑表单
    public function edit()
    {
        //获取要修改的商品信息
        $mod = new Model("goods");
        $this->goods = $mod->find($_GET['id']);
        //获取类别信息
        $sql = "select * from type order by concat(path,id)";
        $this->typeList = $mod->query($sql);
        //var_dump($this->typeList);

        //加载模板
        $this->display("edit");
    }
    
    //执行修改
    public function update()
    {
        //判断是否有图片上传
        if($_FILES['picname'][error]!=4){
            //执行图片上传
            $upload = new FileUpload($_FILES['picname']);
            $upload->path = $this->path; //上传文件存储目录
            $upload->typeList = $this->types; //允许上传文件类型
            if(!$upload->upload()){
                die("图片上传失败！原因：".$upload->errinfo);
            }
            //执行缩放
            imageResize($upload->fileName,$this->path,70,70,"s_");
            imageResize($upload->fileName,$this->path,175,175,"m_");
            imageResize($upload->fileName,$this->path,328,328,"");
            $_POST['picname'] = $upload->fileName; //封装新图片信息
        }
        
        //执行修改
        $mod = new Model("goods");
        
        $m = $mod->update();
        
        //判断是否修改成功！
        if($m>0){
            //判断有新图上传
            if($_FILES['picname'][error]!=4){
                //删除原图片
                @unlink($this->path."s_".$_POST['oldpic']);
                @unlink($this->path."m_".$_POST['oldpic']);
                @unlink($this->path.$_POST['oldpic']);
            }
            echo "修改成功！";
        }else{
            //判断有新图上传
            if($_FILES['picname'][error]!=4){
                //删除新图片
                @unlink($this->path."s_".$upload->fileName);
                @unlink($this->path."m_".$upload->fileName);
                @unlink($this->path.$upload->fileName);
            }
            echo "修改失败！";
        }
    }
	 public function del()
    {
        //实例化Model类
        $mod = new Model("goods");
        //执行删除操作
        $this->list = $mod ->find($_GET['id']);
		@unlink("./Public/uploads/s_".$this->list['picname']);
        @unlink("./Public/uploads/m_".$this->list['picname']);
        @unlink("./Public/uploads/".$this->list['picname']);
		$m = $mod->del($_GET['id']);
        //跳转浏览
        header("Location:".URL."/goods/indexs");
	}
}
