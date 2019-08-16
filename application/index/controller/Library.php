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
		//判断用户是否登录
		if(!Session::has('userinfo'))
		{
            return $this->error('您没有登陆',url('Login/login'));
        }
		$userinfo = Session::get('userinfo');
		$this -> assign('userinfo',$userinfo);
		
		//显示电影库
		$uid = Session::get('userID');
		$list = Db::name('movielibrary')->paginate(24,17821);
		
		// 获取分页显示
		$page = $list->render();
		// 模板变量赋值
		$this->assign('library', $list);
		$this->assign('page', $page);
		// 渲染模板输出
		return $this->fetch();
	}
}

?>
