<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use \think\View;
use think\Input;
use think\Session;

header("Content-Type:text/html;charset=utf-8");
	
class Search extends Controller
{	
	public function search()
	{
		if(!Session::has('userinfo'))
		{
            return $this->error('您没有登陆',url('Login/login'));
        }
		
		$userinfo = Session::get('userinfo');
		$this -> assign('userinfo',$userinfo);
		
		$mvname = input('request.mvname');
		if($mvname != NULL)
		{
			$list = Db::table('movielibrary')
				       ->field('imgname,rate,name,tag,movieID,actor')
				       ->where('name','like','%'.$mvname.'%')
				       ->select();
			$this->assign('search',$list);
			return $this->fetch('search');
		}
		else
		{
			$this->error('请输入关键字');
		}
		
		return $this->fetch('search');	
	}
}
?>