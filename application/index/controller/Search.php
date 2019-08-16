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
		//判断用户是否登录
		if(!Session::has('userinfo'))
		{
            return $this->error('您没有登陆',url('Login/login'));
        }
		
		$userinfo = Session::get('userinfo');
		$this -> assign('userinfo',$userinfo);
		
		//实现模糊搜索，支持标签，电影名，地区，演员。
		$mvname = input('request.mvname');
		if($mvname != NULL)
		{
			$list = Db::table('movielibrary')
				       ->field('imgname,rate,name,tag,movieID,actor')
				       ->whereOr('name','like','%'.$mvname.'%')
					   ->whereOr('tag','like','%'.$mvname.'%')
					   ->whereOr('location','like','%'.$mvname.'%')
					   ->whereOr('actor','like','%'.$mvname.'%')
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