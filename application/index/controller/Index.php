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
		$this -> assign('userinfo',$userinfo);
		$uid = Session::get('userID');
		//今日热门
		$Thisdate = date("Y-m-d");
		$list1 = Db::table('movielibrary')
				   ->field('imgname,movieID,name,rate,tag')
          			->where('mlike',1)
          			->where('likeDate','like',$Thisdate.'%')
				   ->limit(6)
				   ->select();
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

		$this->assign('hottoday',$list1);
		
		
		//个性化推荐
		
		$tag_1 = '喜剧';
		$tag_2 = '剧情';
		$tag_3 = '动画';
		$tag_4 = '音乐';
		$tag_5 = '奇幻';
		$tag_6 = '惊悚';
		$tag_7 = '悬疑';
		$tag_8 = '动作';
		$tag_9 = '犯罪';
		$tag_10 = '家庭';
		$tag_11 = '伦理';
		$tag_12 = '同性';
		$tag_13 = '戏曲';
		
		$location_1 = '中国';
		$location_2 = '欧美';
		$location_3 = '韩国';
		$location_4 = '日本';
		
		$avg_demo = Db::table('relation')
					->where('userid',$uid)
					->avg('rate'); 
		
		$avg = round($avg_demo,1);
		
		//根据标签和评分进行相关推荐
		$list2 = Db::table('movielibrary')
				   ->field('imgname,rate,name,tag,movieID')
				   ->whereOr('rate','=',$avg)
					->where('tag',['like','%'.$tag_2.'%'],['like','%'.$tag_3.'%'],'or')
				   ->limit(12)
				   ->select();
				   
		foreach($list2 as $key => $v2){
			$res2 = Db::table('relation')
						->where('userid',$uid)
						->where('mid',$v2['movieID'])
						->select(); 
			if($res2 != NULL)
			{
				$list2[$key]['like'] = 'like_full.png';
			}
			else
			{
				$list2[$key]['like'] = 'like_empty.png';
			}
		}
		
		$this->assign('recommendation1',$list2);
		
		//根据地区进行相关推荐
		$list3 = Db::table('movielibrary')
				   ->field('imgname,rate,name,tag,movieID')
					->where('location',['like','%'.$location_2.'%'],['like','%'.$location_4.'%'],'or')
				   ->limit(6)
				   ->select();
				   
		foreach($list3 as $key => $v3){
			$res3 = Db::table('relation')
						->where('userid',$uid)
						->where('mid',$v3['movieID'])
						->select(); 
			if($res3 != NULL)
			{
				$list3[$key]['like'] = 'like_full.png';
			}
			else
			{
				$list3[$key]['like'] = 'like_empty.png';
			}
		}
				   
		$this->assign('recommendation2',$list3);
		
		return $this->fetch('index');
	} 
	
	public function logout()
	{
		//销毁session
		session("userinfo", NULL);
		//跳转页面
		return $this->success('您已退出登录',url('Login/login'));
	}
	
	
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
