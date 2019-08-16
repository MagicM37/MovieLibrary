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
		//判断用户是否登录
		if(!Session::has('userinfo'))
		{
            return $this->error('您没有登陆',url('Login/login'));
        }
		
		$userinfo = Session::get('userinfo');
		$this -> assign('userinfo',$userinfo);
		
		//展示电影的详细信息
		$uid = Session::get('userID');
		$movieid = Request::instance()->param('id');
		$list = Db::table('movielibrary')
				   ->where('movieID','=',$movieid)
				   ->field('movieID,actor,director,name,rate,releasedate,runtime,summary,tag,imgname,location')
				   ->select();
		
		//判断电影是否收藏的图标显示
		foreach($list as $key => $v){
			$res = Db::table('relation')
						->where('userid',$uid)
						->where('mid',$v['movieID'])
						->select(); 
			if($res != NULL)
			{
				$list[$key]['like'] = 'like_full.png';
			}
			else
			{
				$list[$key]['like'] = 'like_empty.png';
			}
		}
		
		$this->assign('moviedetails',$list);
		
		//推荐相似电影
		$data = Db::table('movielibrary')
				  ->where('movieID',$movieid)
			      ->find();
				  
		$tag  = $data['tag'];
		$rate = $data['rate'];
		$location = $data['location'];
	
		
		//根据标签进行相关推荐
		$list1 = Db::table('movielibrary')
				   ->field('imgname,rate,name,tag,movieID')
				   ->where('tag','like','%'.$tag.'%')
				   ->limit(2)
				   ->select();
		
		//判断电影是否收藏的图标显示
		foreach($list1 as $key => $v){
			$res = Db::table('relation')
						->where('userid',$uid)
						->where('mid',$v['movieID'])
						->select(); 
			if($res != NULL)
			{
				$list1[$key]['like'] = 'like_full.png';
			}
			else
			{
				$list1[$key]['like'] = 'like_empty.png';
			}
		}
		
		$this->assign('recommendation1',$list1);
		
		//根据评分进行相关推荐
		$list2 = Db::table('movielibrary')
				   ->field('imgname,rate,name,tag,movieID')
					->where('rate',$rate)
				   ->limit(2)
				   ->select();
				   
		//判断电影是否收藏的图标显示
		foreach($list2 as $key => $v){
			$res = Db::table('relation')
						->where('userid',$uid)
						->where('mid',$v['movieID'])
						->select(); 
			if($res != NULL)
			{
				$list2[$key]['like'] = 'like_full.png';
			}
			else
			{
				$list2[$key]['like'] = 'like_empty.png';
			}
		}
		
		$this->assign('recommendation2',$list2);
		
		//根据地区进行相关推荐
		$list3 = Db::table('movielibrary')
				   ->field('imgname,rate,name,tag,movieID')
					->where('location','like','%'.$location.'%')
				   ->limit(2)
				   ->select();
				   
		//判断电影是否收藏的图标显示
		foreach($list3 as $key => $v){
			$res = Db::table('relation')
						->where('userid',$uid)
						->where('mid',$v['movieID'])
						->select(); 
			if($res != NULL)
			{
				$list3[$key]['like'] = 'like_full.png';
			}
			else
			{
				$list3[$key]['like'] = 'like_empty.png';
			}
		}
		
		$this->assign('recommendation3',$list3);

		return $this->fetch('details');
	}
	
	public function logout()
	{
		//销毁session
		session("userinfo", NULL);
		//跳转页面
		return $this->success('退出登录成功',url('Login/login'));
	}
	
	//判断我的收藏
	public function mylove()
	{
		$mid = request()->param("id");
		$tag = request()->param("tag");
		$rate = request()->param("rate");
		$uid = Session::get('userID');
		
		$res = Db::table('relation')
				    ->where('userid',$uid)
					->where('mid',$mid)
					->select(); 
		if($res != NULL)
		{
			return json(["code" => 300, "msg" => "已经喜欢了哟" , "id" => $mid]);
		}
		else
		{
			$data = ['userid' => $uid , 'mid' => $mid , 'tag' => $tag , 'rate' => $rate];
			Db::table('relation')->insert($data);
          	$mlike = ['mlike' => '1'];
      		Db::table('movielibrary')
          			->where('movieID',$mid)
          			->update($mlike);
			return json(["code" => 200, "msg" => "喜欢Get！" , "id" => $mid]);
		}	
	}
}

?>
