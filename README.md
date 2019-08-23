# 青海大学2019年双轨制工程训战

## 大数据过滤推荐系统 小组

1. 项目介绍
	> 我们希望能够快速解决用户的片荒问题。  
	> 我们将网站定位于豆瓣与IMDB之间，用户在能够看到海量的电影，也能够快速的选择自己喜欢的电影，并能根据喜欢电影得到相应的个性化推荐。  
	> 网站只有我的喜欢选项，减少影评与打分选项，这样能让用户快速拿到想要的电影而避免浪费时间在影评、水军冲突之间。
2. 环境
    * 框架：ThinkPHP 5.0
	* 数据库：MySQL8.0
3. 数据表
	* movielibrary表（电影库）  
		  
		|   名称     |  数据类型  |  
		|   :---     |  :-------  |  
		| movieID    | INT        |  
		| actor      | VARCHAR    |  
		| director   | VARCHAR    |  
		| imgname    | VARCHAR    |  
		| name       | VARCHAR    |  
		| rate       | DOUBLE     |  
		| releasedate| VARCHAR    |  
		| runtime    | VARCHAR    |  
		| summary    | VARCHAR    |  
		| tag        | VARCHAR    |  
		| location   | VARCHAR    |  
		  
	* relation表（关系表）  
	  
		|   名称     |  数据类型  |  
		| :-----     | :--------  |  
		| rid        | INT        |  
		| userid     | INT        |  
		| mid        | INT        |  
		| rate       | DOUBLE     |  
		| tag        | VARCHAR    |  
		  
	* user表（用户表）  
	  
		|   名称     |  数据类型  |  
		| :-----     | :--------  |  
		| uid        | INT        |  
		| uname      | VARCHAR    |  
		| memail     | VARCHAR    |  
		| upassword  | VARCHAR    |  
		  
4. 备注
	* static文件夹未提交  
	* 电影库信息爬取自豆瓣电影
