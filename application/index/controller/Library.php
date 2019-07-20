<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use \think\View;
use think\Input;
use think\Session;

class Library extends Controller
{
	
    public function Library()
	{
		/*
		$list = Db::table('movie')
				   ->field('imgname,name,tag,movieID')
				   ->limit(24)
				   ->select();
		$this->assign('library',$list);
		*/
		
		if(!Session::has('userinfo'))
		{
            return $this->error('您没有登陆',url('Login/login'));
        }
		$userinfo = Session::get('userinfo');
		//dump(session('user'));
		//dump($userinfo);
		$this -> assign('userinfo',$userinfo);
		
		// 查询状态为1的用户数据 并且每页显示10条数据
		$list = Db::name('movielibrary')->paginate(24,22850);
		// 获取分页显示
		$page = $list->render();
		// 模板变量赋值
		$this->assign('library', $list);
		$this->assign('page', $page);
		// 渲染模板输出
		return $this->fetch();
	}
	public function mylove()
	{
		$mid = request()->param("id");
		$uid = Session::get('userID');
		
		$data = ['userid' => $uid , 'mid' => $mid];
		Db::table('relation')->insert($data);
		
		return json(["code" => 200, "msg" => "收藏成功" , "id" => $mid]);
	}
}

?>
