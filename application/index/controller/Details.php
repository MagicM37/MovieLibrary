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
		$userinfo = Session::get('userinfo');
		//dump(session('user'));
		//dump($userinfo);
		$this -> assign('userinfo',$userinfo);
		
		$movieid = Request::instance()->param('id');
		echo $movieid;
		$list = Db::table('movielibrary')
				   ->where('movieID','=',$movieid)
				   ->field('movieID,actor,director,name,rate,releasedate,runtime,summary,tag,imgname,location')
				   ->select();
		$this->assign('moviedetails',$list);

		return $this->fetch('details');
	}
}

?>
