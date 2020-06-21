<?php
include_once("head.php");
$action=isset($_GET['action'])?$_GET['action']:"Login";
switch($action)
{
 case "Login":
 ?>
   <script>
  function check(){
	  if(!$('input[name=username]').val()){alert('用户名不能为空');$('input[name=username]').focus();return false;}
	  if(!$('input[name=password]').val()){alert('密码不能为空');$('input[name=password]').focus();return false;}
  }
  </script>
  <div style='margin:100px auto;width:300px;' align='left'>
  <form class='myform' action='?action=LoginGo' method='post' onsubmit='return check()' style='width:250px;'>
  <span class='myspan' style='width:70px;'>USERNAME：</span><input name='username' style='width:150px;'><br><br>
  <span class='myspan' style='width:70px;'>PASSWORD：</span><input name='password' type='password' style='width:150px;'><br><br>
  <center> <input type='submit' value='登録' class='submit'> <input  onclick="location='?action=Reg'"  type='button' value='新登録' class='submit'></center>
  </form>
  </div>
 <?php
 break;
 case "LoginGo":
  $_POST=escapeArr($_POST);
  $row=mysql_fetch_assoc(mysql_query ("select * from member where username='{$_POST['username']}' and password='".md5($_POST['password'])."'  "));
  if($row['id']){
	  $_SESSION['membername']=$row['username'];
	  $_SESSION['memberpassword']=$row['password'];
	  
	  echo "<script>location='index.php'</script>";
	  }
  else {alert('登録エラー','index.php');}	
  break;
  case "Reg":
  ?>
 <script>
  function check(){
	  if(!$('input[name=username]').val()){alert('USERNAMEを入力ください');$('input[name=username]').focus();return false;}
	  if(!$('input[name=password]').val()){alert('PASSWORDを入力ください');$('input[name=password]').focus();return false;}
  }
  </script>
  <div style='width:430px;height:230px;margin:120px auto;' align='left'>
  <form class='myform' action='?action=RegGo' method='post' onsubmit='return check()' >
  <span class='myspan' style='width:70px;'>USERNAME：</span><input name='username'   style='width:150px;'><br><br>
  <span class='myspan' style='width:70px;'>PASSWORD：</span><input name='password' type='password' style='width:150px;'><br><br>
  <center> <input type='submit' value='登録' class='submit'></center>
  </form>
  </div>
 <?php
 break;
 case "RegGo":
   $_POST=escapeArr($_POST);
   if(!isset($_POST['username'])||!$_POST['username']){alert('USERNAME','?action=Reg');}
   $finde=@mysql_fetch_assoc(mysql_query("select * from member where username='{$_POST['username']}'"));
   if($finde['id']){alert('アカウントはすでに存在している','index.php');}
   if(mysql_query("insert into  member set username='{$_POST['username']}',password='".md5($_POST['password'])."' "));
   alert('SUCCESS','index.php');
  break;
  case "Edit":
  ?>
 <script>
  function check(){
	  if(!$('input[name=passwordold]').val()){alert('PASSWORDを入力ください');$('input[name=passwordold]').focus();return false;}
	  if(!$('input[name=passwordnew]').val()){alert('新PASSWORDを入力ください');$('input[name=passwordnew]').focus();return false;}
  }
  </script>
  <div style='width:430px;height:230px;margin:120px auto;' align='left'>
  <form class='myform' action='?action=EditGo' method='post' onsubmit='return check()' >
  <span class='myspan' style='width:70px;'>PASSWORD：</span><input name='passwordold' type='password' style='width:150px;'><br><br>
  <span class='myspan' style='width:70px;'>新PASSWORD：</span><input name='passwordnew' type='password' style='width:150px;'><br><br>
  <center> <input type='submit' value='更新' class='submit'></center>
  </form>
  </div>
 <?php
 break;
 case "EditGo":
   $_POST=escapeArr($_POST);
   $finde=mysql_fetch_assoc(mysql_query("select * from member where username='{$M['username']}'"));
   if($finde['password']!=md5($_POST['passwordold'])){alert('パスワード不正','?action=Edit');}
   else{
	   mysql_query("update member set password='".md5($_POST['passwordnew'])."' where  username='{$M['username']}'");
	   $_SESSION['membername']="";$_SESSION['memberpassword']="";
       unset($_SESSION['membername'],$_SESSION['memberpassword']);
	   alert('更新成功','index.php');
   }
 break;
 case "changeInfo":
 ?>
   <script>
  function check(){
	  if(!$('input[name=realname]').val()){alert('本人姓名を入力ください');$('input[name=realname]').focus();return false;}
  }
  </script>
  <center>
  <div style='width:420px;height:230px;margin-top:20px;' align='left'>
  <form action='?action=changeInfoGo' method='post'  onsubmit='return check()' class='myform'>
   <span class="myspan" style="width:70px;">本人姓名：</span><input name='realname' style='width:160px;' value='<?php echo $M['realname'];?>'><br>
  <span class="myspan" style="width:70px;">性别：</span><select name='gender' style='width:160px;'><option>男</option><option <?php echo select("女",$M['gender']) ?>>女</option></select><br> 
  <span class="myspan" style="width:70px;">電話：</span><input name='tel' style='width:160px;' value='<?php echo $M['tel'];?>'><br>
  <span class="myspan" style="width:70px;">EMAIL：</span><input name='email' style='width:160px;' value='<?php echo $M['email'];?>'><br>
  <center><input type='submit' value='更新' class='submit'></center></form>
  </div></center>

 <?php
 break;
 case "changeInfoGo":
   $query="update member set
      realname='{$_POST['realname']}',
      tel='{$_POST['tel']}',
	  email='{$_POST['email']}',
      gender='{$_POST['gender']}'  where id={$M['id']}";
    if(isset($_POST['realname'])&&mysql_query($query))
    alert("SUCCESS！","index.php");
 break;
 case "Logout":
   $_SESSION['membername']="";
   $_SESSION['memberpassword']="";
   unset($_SESSION['membername'],$_SESSION['memberpassword']);
   echo "<script>location='index.php'</script>";
 break;
}
include_once("foot.php");
?>
