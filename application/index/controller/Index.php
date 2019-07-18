<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use \think\View;
use think\Input;
use think\Url;

header("Content-Type:text/html;charset=utf-8");

class Index extends Controller
{
    public function Index()
	{
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
}
