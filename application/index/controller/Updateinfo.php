<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\View;
use think\Input;
use think\Session;

class Updateinfo extends Controller
{	
	 public function updateinfo()
	{
		
		//判断用户是否登录
		if(!Session::has('userinfo'))
		{
            return $this->error('您没有登陆',url('Login/login'));
        }
		
		$userinfo = Session::get('userinfo');
		$this -> assign('userinfo',$userinfo);
		
		
		$User_id = Session::get('userID');
		
		$uname = input('request.uname');
		$uemail = input('request.uemail');
		$password = input('request.password');
		$newpassword = input('request.newpassword');
		$newconfirm = input('request.newconfirm');
		
		$res = Db::table('user')->where('uid',$User_id)->find();
		
		
		if($res != NULL)  
		{  
			//修改用户昵称
			if($uname != NULL)
			{
				$name = ['uname' => $uname];
				Db::table('user')
					->where('uid',$User_id)
					->update($name);
					
			$this->success('用户昵称已修改，请重新登录！', 'login/login');
			}	
			
			//修改登录密码
			if($password != NULL)
			{
				if($password == $res['upassword'])
				{
					if($newpassword != NULL)
					{
						if($password == $newpassword)
						{
							$this->error('新密码不能和旧密码相同！');
						}
						else
						{
							if($newpassword == $newconfirm)
							{
								$pass = ['upassword' => $newpassword];
								Db::table('user')
									->where('uid',$User_id)
									->update($pass);	
								$this->success('密码修改成功，请重新登录', 'login/login');
							}
							else
							{
								$this->error('两次密码不一致！');
							}
						}
					}
					else
					{
						$this->error('请输入新密码！');
					}
				}
				else
				{
					$this->error('密码输入错误，请重新输入！');
				}
			}
			
			if($password == NULL && ($newpassword != NULL || $newconfirm != NULL))
			{
				$this->error('请输入旧密码！');
			}
			
			//修改注册邮箱
			if($uemail != NULL)
			{
				$email = ['uemail' => $uemail];
				Db::table('user')
					->where('uid',$User_id)
					->update($email);
				
				$this->success('用户邮箱已修改，请重新登录！', 'login/login');
			}	
		}  
		return $this->fetch();
	}
}
?>
