<?php
include_once("admin_head.php");
getadmin();
$action=isset($_GET['action'])?$_GET['action']:"list";
switch($action){
  case "add":
  $Arr=array();
  if(isset($_GET['id'])&&$_GET['id']){
	  $id=intval($_GET['id']);
	  $Arr=mysql_fetch_assoc(mysql_query("select * from user where id='$id'"));
	  $Arr=fromTableInForm($Arr);
  }
  ?>
  <script>
  function check(){
	  if(!$('input[name=username]').val()){alert('USERNAMEを入力ください');$('input[name=username]').focus();return false;}
	  <?php if(!$id){?>
	  if(!$('input[name=password]').val()){alert('PASSWORDを入力ください');$('input[name=password]').focus();return false;}
	  <?php }?>
  }
  </script>
  <center>
  <div style='width:420px;height:230px;margin-top:20px;' align='left'>
  <form action='?action=save&id=<?php echo $id?>&iframe=1' method='post'  onsubmit='return check()' class='myform'>
  USERNAME：<input name='username' style='width:160px;' value='<?php echo $Arr['username']?>'><br>
  PASSWORD：<input name='password' type='password' style='width:160px;' ><br> 
  <center><input type='submit' value='更新'' class='submit'></center></form>
  </div></center>
  <?php
  break;
case "save":
  $_POST=escapeArr($_POST);
  if(isset($_GET['id'])&&$_GET['id']){
    $id=intval($_GET['id']);
	$find=mysql_fetch_assoc(mysql_query ("select id from user where username='{$_POST['username']}' and id!=$id"));
    if($find['id'])alert("アカウントはすでに存在している","?action=list");
    if($_POST['password']) {$fsql=",password='".md5($_POST['password'])."'";}
    else $fsql="";
    $query="update user set username='{$_POST['username']}' $fsql where id={$id}";
	}
  else{
	$find=mysql_fetch_assoc(mysql_query ("select id from user where username='{$_POST['username']}'"));
    if($find['id'])alert("アカウントはすでに存在している","?action=add");
    $_POST['password']=md5($_POST['password']);
    $query="insert into user set username='{$_POST['username']}',password='{$_POST['password']}'";
  }
  if(isset($_POST['username'])&&mysql_query($query))
  alert("操作成功！","?action=list");
  break;
case "delete":
  $id=intval($_GET['id']);
  $find=mysql_fetch_assoc(mysql_query ("select id from user where id!=$id"));
  if(!$find['id'])alert("削除できない","?action=list");
  if(mysql_query("delete from user where id=$id")) alert("削除成功！","?action=list"); 
  break;
case "alldel":
  $key=$_POST["allidd"];
  for($i=0;$i<count($key);$i++){
    $find=mysql_fetch_assoc(mysql_query ("select id from user where id!={$key[$i]}"));
    if($find['id']) mysql_query("delete from user where id={$key[$i]}"); 
  }
  alert("削除成功".count($key)."個！","?action=list");
  break;
case "list":
   echo "<form style='padding:0px;margin:0px;' action='?action=list' method='post'>
   <span class='status'>&nbsp;&nbsp;<i>USER管理</i></span>&nbsp;&nbsp;&nbsp;&nbsp;名：<input name='username' value='{$_REQUEST['username']}' style='padding:0px;margin:0px;'>
   <input type='submit' value='検索''> <input type='button' onclick=\"location='?action=add'\" value='追加'> </form>";   
   $fsql="";$fpage="";
   if(isset($_REQUEST['username'])&&$_REQUEST['username']){$fsql.=" and username like '%{$_REQUEST['username']}%'";$fpage="&username={$_REQUEST['username']}";}  
 
  
   $query=mysql_query("select * from  user where 1=1 $fsql order by id desc");
   echo "<table style='width:98%;' align='center'>
   <tr  bgcolor='#eeeeee' height='30' align='center'><td>アカウント</td><td>管理</td></tr>";
   while($rs=mysql_fetch_assoc($query)){
	   	  echo "<tr height='20'>
		  <td align='left'>{$rs['username']}</td>
          <td align='center'>		  
		  <a href='?action=add&id={$rs['id']}'>編集</a>  &nbsp; &nbsp;
		  <a href='javascript:if(confirm(\"delete？\"))location=\"?action=delete&id={$rs['id']}\" '>削除</a> 
		  </td>
		  </tr>";
   }
   echo "</table>"; 
   break;
}
include_once("admin_foot.php");
?>