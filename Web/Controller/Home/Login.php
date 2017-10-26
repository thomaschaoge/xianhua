<?php
//自定义Login信息控制类

class Login extends Controller
{
    //浏览信息
    public function logins()
    {
        $this->display("login");
    }
	//执行登陆
	public function doLogin()
	{
		//验证验证码信息
		if($_POST['mycode'] !== $_SESSION['code']){
			$this->errinfo="验证码错误！";
			$this->display("login");
			return;
		}
		//验证账号和密码
		$mod=new Model("users");
		$pass=md5($_POST['pass']);
		$sql="select * from users where username='{$_POST['username']}' and pass='{$pass}'";
		$list=$mod->query($sql);
		if(count($list)>0){
			//获取登陆者信息并放入到session中
			$_SESSION['homeuser']=$list[0];
			
			//跳转到前台首页
			$url=URL."/Index/indexs";
			header("Location:{$url}");
			
		}else{
			$this->errinfo="登陆账号或密码错误！";
			$this->display("login");
			
		}
	}
    //执行退出
	public function logout()
	{
		unset($_SESSION['homeuser']);
		
		$this->display("login");
	}
	//加载验证码
	public function verify()
	{
		$verify=new Verify();
		$verify->ttf='./public/msyh.ttf'; //验证码输出时的字体文件
		$verify->length=4;//验证码位数
		$verify->type=1;//验证码类型：1纯数字 2数字加小写字母 3其他
		$verify->entry();
	}
	
    
}
