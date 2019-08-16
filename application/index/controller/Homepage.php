<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\View;
use think\Input;
use think\Session;

class Homepage extends Controller
{	
	 public function Homepage()
	{
		
		//判断用户是否登录
		if(!Session::has('userinfo'))
		{
            return $this->error('您没有登陆',url('Login/login'));
        }
		
		$userinfo = Session::get('userinfo');
		//dump(session('user'));
		//dump($userinfo);
		$this -> assign('userinfo',$userinfo);
		
		//显示用户信息
		$User_id = Session::get('userID');
		
		
		$list1 = Db::table('user')
				   ->where('uid','=',$User_id)
				   ->field('uname,uemail')
				   ->select();
			
		$this->assign('personalinfo',$list1);
	
	
		//判断用户的我的收藏，为空则不显示
		
		$data = Db::name('relation')
				   ->alias('a')
				   ->join('movielibrary b','a.mid = b.movieID')
				   ->field('b.imgname,b.movieID,b.name,b.tag')
				   ->where('a.userid',$User_id)
				   ->select();
		
		$this->assign('myfavor',$data);
			
		return $this->fetch();
	}
}
?>
