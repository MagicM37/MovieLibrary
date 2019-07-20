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
				   ->field('imgname,movieID,name,rate,tag')
				   ->limit(6)
				   ->select();
		$this->assign('hottoday',$list1);
		
		$uid = Session::get('userID');
		
		$avg_demo = Db::table('relation')
					->where('userid',$uid)
					->avg('rate'); 
		
		$avg = round($avg_demo,1);
		
		$list2 = Db::table('movielibrary')
				   ->field('imgname,rate,name,tag,movieID')
				   ->whereOr('rate','=',$avg)
				   ->where('tag',['like','%动画%'],['like','%剧情%'],'or')
				   ->limit(18)
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
	
	public function mylove()
	{
		$mid = request()->param("id");
		$tag = request()->param("tag");
		$rate = request()->param("rate");
		$uid = Session::get('userID');

		$data = ['userid' => $uid , 'mid' => $mid , 'tag' => $tag , 'rate' => $rate];
		Db::table('relation')->insert($data);
		
		return json(["code" => 200, "msg" => "已收藏" , "id" => $mid]);
	}
}
