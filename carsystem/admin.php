<?php
include_once("admin_head.php");
$action=isset($_GET['action'])?$_GET['action']:"login";
switch($action){

case "login":
  if(isset($_SESSION['adminname'])&&$_SESSION['adminname'])echo "<script>location='admin_user.php?action=list'</script>";
  ?>
  <script>
  function check(){
	  if(!$('input[name=username]').val()){alert('USERNAMEを入力ください'');$('input[name=username]').focus();return false;}
	  if(!$('input[name=password]').val()){alert('PASSWORDを入力ください');$('input[name=password]').focus();return false;}
  }
  </script>
  <div style="width:500px;margin:100px auto" align="center">
  <span class='status' style='font-size:20px;'>&nbsp;&nbsp;<i>管理者登録</i></span>&nbsp;&nbsp;&nbsp;&nbsp;
  <form class='myform' action='?action=logingo' method='post' onsubmit='return check()' >
  <span class='myspan px60'>USERNAME：</span><input name='username' style='width:150px;'><br><br>
  <span class='myspan px60'>PASSWORD：</span><input name='password' type='password' style='width:150px;'><br><br>
  <input type='submit' value='登録' class='submit'></form>
  </div>
  <?php
  break;
case "logingo":
    $row=@mysql_fetch_assoc(mysql_query("select * from user where username='{$_POST['username']}' and password='".md5($_POST['password'])."' "));
    if($row['id']){
	  $_SESSION['adminname']=$row['username'];
	  $_SESSION['adminpassword']=$row['password'];	  
	  echo "<script>location='admin.php?'</script>"; 
	  die();
	}
    else {alert('アカウントエラー','admin.php?action=login');}
    break;
case "logout":
    $_SESSION['adminname']="";
	$_SESSION['adminpassword']="";
    unset($_SESSION['adminname'],$_SESSION['adminpassword']);
	echo "<script>location='?action=login'</script>";
    break;
}
include_once("admin_foot.php");
?>
