<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use \think\View;
use think\Input;

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
}

?>
