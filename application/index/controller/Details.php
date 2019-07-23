<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use \think\View;
use think\Input;
use think\Session;

class Details extends Controller
{
    public function Details()
	{
		if(!Session::has('userinfo'))
		{
            return $this->error('您没有登陆',url('Login/login'));
        }
		
		$userinfo = Session::get('userinfo');
		//dump(session('user'));
		//dump($userinfo);
		$this -> assign('userinfo',$userinfo);
		
		$movieid = Request::instance()->param('id');
		$list = Db::table('movielibrary')
				   ->where('movieID','=',$movieid)
				   ->field('movieID,actor,director,name,rate,releasedate,runtime,summary,tag,imgname,location')
				   ->select();
		$this->assign('moviedetails',$list);

		return $this->fetch('details');
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

?>
