<?php
session_start();
include_once('include/db.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="img/inc.css" type="text/css" rel="stylesheet" />
<title>料料レンタル</title>
<script src="include/jquery-1.3.2.min.js"></script>
</head>
<body >
<div style="background-color:#5e073e; background-image:url(img/top.png);background-repeat:no-repeat;height:250px; font-size:20px; color:#FFF; font-weight:bold; line-height:40px; padding:5px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif  " align="center">
  <div style="width:1000px;height:250px;" align="left">
    <span class="myspan" style="margin-left:400px; margin-top:100px; font-size:40px; letter-spacing:20px;">&nbsp;料料レンタル</span>
  </div>
</div>

<div  align="left"  style=" margin:10px auto; width:1000px; border:solid 1px #999; padding:0px 10px; background-color:#F5F5F5; padding-bottom:10px;">
  <div style="width:100%; margin:auto; padding:10px;" align="center">
     <form action="index.php" method="post">
    <input name="searchTtile" style="width:300px;height:20px;" /> &nbsp; 
    <input type="submit" value="搜索" class="submit" />  &nbsp; &nbsp; 
      <a href='index.php'>ホームページ</a>&nbsp;|&nbsp; <a href='zunintiaokuan.php'>Lease terms</a>&nbsp;|  <a href='admin.php'>管理者登入</a>&nbsp;| 
    </form> 
 
  </div>

<div style="  padding:10px; " class="ssmenu">
 <?php
   $classQuery=mysql_query("select * from carclass");
   while($classArr=mysql_fetch_assoc($classQuery)){
	   echo "<span class='myspan' style='width:120px;'> 
	   <center> <img src='{$classArr['picurl']}'></center> 
	   <center><a href='index.php?cid={$classArr['id']}' style='font-weight:bolder;margin:auto 10px;'>{$classArr['title']}</a> 
	   </center>
	   </span>" ;
   }
 ?>
</div>

 <div style="background-color:#FFF; padding:10px; border:solid 1px #999" class="ssmenu">
 
 </div>

 <div style="float:left;width:282px; margin-top:10px;">
     <div style="width:260px; background-color: #663;padding:10px; color:#FFF; font-weight:bold">マイページセンター</div>
     <?php 
	 if($M['id']){
	 ?>
     <div  class='myform' style='width:250px; height:200px; border:#663 solid 5px; margin-top:0px; line-height:3' align="center">
	 <a href='index.php' style='font-weight:bolder; color: #03F;'>ホームページ</a> <br />
	 <a href='member.php?action=Logout' style='font-weight:bolder; color: #03F;'>LOGOUT</a>  <br />  
     <a href='member.php?action=Edit' style='font-weight:bolder; color: #03F;'>PASSWORD変更</a>  <br />  
	 <a href='member.php?action=changeInfo' style='font-weight:bolder; color: #03F;'>更新</a>  <br />  
     <a href='car.php?action=orders_list' style='font-weight:bolder; color: #03F;'>予約確認</a>  <br />  
 
     </div>
     <?php
     }
	 else
	 {
     ?>
  <script>
  function check(){
	  if(!$('input[name=username]').val()){alert('USERNAMEを入力ください');$('input[name=username]').focus();return false;}
	  if(!$('input[name=password]').val()){alert('PASSWORDを入力ください');$('input[name=password]').focus();return false;}
	  return true;
  }
  </script>
  <div style='margin:0px auto;' align='left'>
  <form name='loginForm' id='loginForm' class='myform' action='member.php?action=LoginGo' method='post' onsubmit='return check()' style='width:250px; border:#663 solid 5px; margin-top:0px;'>
  <span class='myspan' style='width:100px;'>会員番号：</span><input name='username' style='width:150px;'><br><br>
  <span class='myspan' style='width:100px;'>パスワード：</span><input name='password' type='password' style='width:150px;'><br><br>
  <center> 
  <input type='submit' value='登録' class='submit'> 
  <input  onclick="if(check()){
    document.getElementById('loginForm').action='member.php?action=RegGo';
    loginForm.submit();
  }"  type='button' value='新アカウント登録' class='submit'></center>
  </form>
  </div>
     <?php }?>
    <div style="width:260px; background-color:#663;padding:10px; color:#FFF; margin-top:10px;font-weight:bold">人気車</div>
    <div  class='myform' style='width:250px; height:750px; border:#663 solid 5px; margin-top:0px; line-height:3'>
    <?php
	$query=mysql_query("select * from  car   order by click desc  limit 0,4");
	while($hotArr=mysql_fetch_assoc($query)){
	   echo "<div style='float:left;line-height:2' align='center'>
		   <a href='car.php?action=show&id={$hotArr['id']}'><img src='{$hotArr['picurl']}' style='width:180px;height:140px;border:solid 1px #ccc; margin:10px 27px;'></a><br>
		   {$hotArr['title']} &nbsp; <font color='#ff0000'>いいね&nbsp{$hotArr['click']}</font>
		   </div>";
	}
	?>
    </div>
 </div>
 
 <div style="float:right; width:710px;">