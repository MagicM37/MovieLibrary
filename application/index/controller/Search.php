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
		$mvname = input('request.mvname');
		
		echo $mvname;
		
		$list = Db::table('movielibrary')
				   ->field('imgname,rate,name,tag,movieID')
				   ->where('name','like','%'.$mvname.'%')
				   ->select();
		$this->assign('search',$list);
		
		return $this->fetch('search');	
	}
}
?>