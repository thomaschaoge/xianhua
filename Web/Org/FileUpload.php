<?php
//文件上传类

class FileUpload
{
	private $upfile;
	private $path ; //上传文件存储目录;
	private $typeList = array();
	private $maxSize = 0;
	private $fileName;
	private $errinfo;
	
	public function __construct($upfile)
	{
		$this->upfile = $upfile;
	}
	
	public function __set($param,$value)
	{
		$this->$param = $value;
	}
	
	public function __get($param)
	{
		return $this->$param;
		
	}
	
	//执行文件上传
	public function upload()
	{
		//处理路径
		$this->path = rtrim($this->path,"/")."/";
		return $this->checkError() && $this->checkTypeList() && $this->checkMaxSize() && $this->makeFileName() && $this->moveUpfile();
		
	}
	
	//上传错误信息判断
	private function checkError()
	{
		if($this->upfile['error']){
			switch($this->upfile['error']){
			case 1: $err = "上传文件大小超出php.ini配置文件限制";break;
			case 2: $err = "上传文件大小超出表单隐藏限制";break;
			case 3: $err = "文件只有部分被上传 ";break;
			case 4: $err = "没有文件被上传!";break;
			case 6: $err = "找不到临时文件夹";break;
			case 7: $err = "文件写入失败";break;
			default: $err = "未知错误!";break;	
		}
		$this->errinfo = $err;
		return false;
		}
		return true;
	}
	
	//判断文件上传类型
	private function checkTypeList()
	{
		if(count($this->typeList)>0){
			if(!in_array($this->upfile['type'],$this->typeList)){
				$this->errinfo = "文件类型上传错误！";
				return false;
			}
		}
		return true;
	}
	
	//4.上传文件大小判断
	private function checkMaxSize()
	{
		if($this->maxSize>0){
			if($this->upfile["size"]>$this->maxSize){
				$this->errinfo = "文件上传大小超出当前限制!";
				return false;
			}
		}
		return true;
	}
	
	//随机上传文件名
	private function makeFileName()
	{
		$ext = pathinfo($this->upfile['name'],PATHINFO_EXTENSION);
		do{
			$this->fileName = time().rand(1000,9999).".".$ext;
		}while(file_exists($this->path.$this->fileName));
		return true;
	}
	
	//执行移动上传文件
	private function moveUpfile()
	{		
			if(is_uploaded_file($this->upfile['tmp_name'])){
			if(move_uploaded_file($this->upfile['tmp_name'],$this->path.$this->fileName)){
				return true;
			}else{
				$this->errinfo = "文件上传移动失败！";
			}
		}else{
			$this->errinfo = "不是一个有效上传文件";
		}
		return false;
	}
}