<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use \think\View;
use think\Input;
use think\Url;
use think\Session;

header("Content-Type:text/html;charset=utf-8");

class Index extends Controller
{
    public function Index()
	{
		if(!Session::has('userinfo'))
		{
            return $this->error('您没有登陆',url('Login/login'));
        }
		$userinfo = Session::get('userinfo');
		//dump(session('user'));
		//dump($userinfo);
		$this -> assign('userinfo',$userinfo);
		//$view = new View();
		$list1 = Db::table('movielibrary')
				   ->field('imgname,movieID,name,tag')
				   ->limit(6)
				   ->select();
		$this->assign('hottoday',$list1);
		
		$list2 = Db::table('movielibrary')
				   ->field('imgname,name,tag,movieID')
				   ->limit(5,18)
				   ->select();
		$this->assign('recommendation',$list2);
		
		return $this->fetch('index');
	} 
	
	public function logout()
	{
		//销毁session
		session("userinfo", NULL);
		//跳转页面
		return $this->success('退出登录成功',url('Login/login'));
	}
}
