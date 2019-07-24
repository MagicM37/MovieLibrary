<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use \think\View;
use think\Input;
use think\Session;

header("Content-Type:text/html;charset=utf-8");
	
class Login extends Controller
{
	public function Login()
	{
		$view = new View();
		return $view->fetch('login');
	}
	public function Logincheck()
	{
		$email = input('request.email');
		$password = input('request.pass');
		//echo $email;
		//echo $password;
		
		$res = Db::table('user')->where('uemail',$email)->find();
		
		//dump($res);
		
		if($res && $res['upassword'] == $password)  
		{  
			Session::set('userinfo',Db::table('user')->where('uemail',$email)->column('uid,uname,uemail'));
			//Session::set('userID',Db::table('user')->where('uemail',$email)->column('uid'));
			Session::set('userID',$res['uid']);
			$this->success('欢迎您，' . $res['uname'], 'index/index');
		}  
		else 
		{  
			//echo "<script>alert('用户名或密码不正确 请重新输入');history.go(-1);</script>";  
			$this->error('用户名或密码不正确 请重新输入');
		}  
	}
	public function register()
	{
		//接值
		$name = input('request.name');
		$email = input('request.email');
		$pass = input('request.pass');
		$confirm = input('request.confirm');
		
		//email空值判断
		if($email == NULL)
		{
			$this->error('请填写邮箱地址');
		}
		
		//pass空值判断
		if($pass == NULL)
		{
			$this->error('请设置登录密码');
		}
		
		//confirm空值判断
		if($confirm == NULL)
		{
			$this->error('请再次填写登录密码');
		}
		
		//注册判断
		if($pass == $confirm)
		{
			$res = Db::table('user')->where('uemail',$email)->find();
			//验证码检验
			if(request()->isPost())
			{
				$data = input('post.');
				if(!captcha_check($data['verifyCode'])) 
				{
					// 校验失败
					$this->error('验证码不正确');
				}
			}
			
			if($res != NULL)
			{
				//echo "<script>alert('邮箱已被注册 请直接登陆');location.href='login.html';</script>";  
				$this->error('邮箱已被注册 请直接登陆');
			}
			else
			{
				$data = ['uid' => '' , 'uname' => $name , 'uemail' => $email , 'upassword' => $pass];
				Db::table('user')->insert($data);
				//echo "<script>alert('注册成功 欢迎登陆');location.href='login.html';</script>";
				$this->success('注册成功 欢迎登陆', 'login/login');
			}
		}
		else
		{
			echo "<script>alert('两次密码不相同 请重新输入');history.go(-1);</script>"; 
		}
	}
}
?>