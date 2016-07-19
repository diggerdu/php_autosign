<?php
ignore_user_abort(true);
//set_time_limit(100); //procession no time limit

function login_post($url, $cookie, $post)
{
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);//登录提交的地址 
    curl_setopt($curl, CURLOPT_HEADER, 0);//是否显示头信息 
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 0);//是否自动显示返回的信息 
    curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie); //设置Cookie信息保存在指定的文件中 
    curl_setopt($curl, CURLOPT_POST, 1);//post方式提交 
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));//要提交的信息 
    curl_exec($curl);//执行cURL 
    curl_close($curl);//关闭cURL资源，并且释放系统资源 
}

function get_content($url, $cookie) { 
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie); //读取cookie 
    $rs = curl_exec($ch); //执行cURL抓取页面内容 
    curl_close($ch); 
    return $rs; 
}

$post = array (
    'email' => '2455527783@qq.com', 
    'passwd' => '198464318', 
    'remember_me' => 'week' 
);

//登录地址 
$loginurl = "http://vwp123.com/user/_login.php";
//设置cookie保存路径 
$cookie = "cookie.txt"; 
//登录后要获取信息的地址 
$indexurl = "http://vwp123.com/user/index.php"; 

//登录后要获取信息的地址 
$signurl = "http://vwp123.com/user/_check.php"; 

//模拟登录 
login_post($loginurl, $cookie, $post); 

//获取登录页的信息 
$content = get_content($indexurl, $cookie);

//匹配页面信息 
if (strrpos($content, "已签到") < 0)
	{echo "Signed";}
else
	{$content = get_content($signurl, $cookie);
	 if (strrpos($content, "已签到") > 0)
		{echo "Sign Successfully";}
	 else
	 	{echo "Fault";}
	}
	
//删除cookie文件 
unlink($cookie);
?>