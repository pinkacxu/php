<?php
include_once("admin_head.php");
getadmin();
$action=isset($_GET['action'])?$_GET['action']:"list";
switch($action){
case "add":
  $Arr=array();
  if(isset($_GET['id'])&&$_GET['id']){
	  $id=intval($_GET['id']);
	  $Arr=mysql_fetch_assoc(mysql_query("select * from member where id='$id'"));
	  $Arr=fromTableInForm($Arr);
  }
  ?>
  <script>
  function check(){
	  if(!$('input[name=username]').val()){alert('USERNAMEを入力ください');$('input[name=username]').focus();return false;}
	  <?php if(!$id) {?>
	  if(!$('input[name=password]').val()){alert('PASSWORDを入力ください');$('input[name=password]').focus();return false;}
	  <?php }?>
	  if(!$('input[name=realname]').val()){alert('本人姓名');$('input[name=realname]').focus();return false;}
  }
  </script>
  <center>
  <div style='width:420px;height:230px;margin-top:20px;' align='left'>
  <form action='?action=save&id=<?php echo $id?>' method='post'  onsubmit='return check()' class='myform'>
  <span class="myspan" style="width:100px;">USERNAME：</span><input name='username' style='width:160px;' value='<?php echo $Arr['username'];?>'><br>
  <span class="myspan" style="width:100px;">PASSWORD：</span><input name='password' type='password' style='width:160px;'><br> 
  <span class="myspan" style="width:100px;">本人姓名：</span><input name='realname' style='width:160px;' value='<?php echo $Arr['realname'];?>'><br>
  <span class="myspan" style="width:100px;">性別：</span><select name='gender' style='width:160px;'><option>男</option><option <?php echo select("女",$Arr['gender']) ?>>女</option></select><br> 
  <span class="myspan" style="width:100px;">電話：</span><input name='tel' style='width:160px;' value='<?php echo $Arr['tel'];?>'><br>
  <span class="myspan" style="width:100px;">EMAIL：</span><input name='email' style='width:160px;' value='<?php echo $Arr['email'];?>'><br>
  <center><input type='submit' value='更新' class='submit'></center></form>
  </div></center>
  <?php
  break;
case "save":
  $_POST=escapeArr($_POST);
  if(isset($_GET['id'])&&$_GET['id']){
	  $id=intval($_GET['id']);
	  $find=mysql_fetch_assoc(mysql_query ("select id from member where username='{$_POST['username']}' and id!=$id"));
      if($find['id'])alert("アカウントはすでに存在している","?action=list");
      if($_POST['password']) {$fsql=",password='".md5($_POST['password'])."'";}
      else $fsql="";
	  $query="update member set
      username='{$_POST['username']}',
      realname='{$_POST['realname']}',
      tel='{$_POST['tel']}',
	  email='{$_POST['email']}',
      gender='{$_POST['gender']}'  $fsql where id={$id}";
	}
	else {
	  $find=mysql_fetch_assoc(mysql_query ("select id from member where username='{$_POST['username']}'"));
      if($find['id'])alert("アカウントはすでに存在している","?action=add");
      $_POST['password']=md5($_POST['password']);
      $query="insert into member set 
      username='{$_POST['username']}',
      password='{$_POST['password']}',
      realname='{$_POST['realname']}',
      tel='{$_POST['tel']}',
	  email='{$_POST['email']}',
      gender='{$_POST['gender']}'";
	} 
    if(isset($_POST['username'])&&mysql_query($query))
    alert("操作成功！","?action=list");
  break;
 case "delete":
  $id=intval($_GET['id']);
  if(mysql_query("delete from member where id=$id")) alert("削除成功！","?action=list");;
  break;
 case "alldel":
  $key=$_POST["allidd"];
  for($i=0;$i<count($key);$i++){
     mysql_query("delete from member where id={$key[$i]}"); 	    
  }
  alert("削除成功".count($key)."個！","?action=list");
  break;
case "list":
   echo "<form style='padding:0px;margin:0px;' action='?action=list' method='post'>
   <span class='status'>&nbsp;&nbsp;<i>会員管理</i></span>&nbsp;&nbsp;&nbsp;&nbsp;用户名：<input name='username' value='{$_REQUEST['username']}' style='padding:0px;margin:0px;'>
   <input type='submit' value='検索'> <input type='button' onclick=\"location='?action=add'\" value='追加'> </form>";   
   $fsql="";$fpage="";
   if(isset($_REQUEST['username'])&&$_REQUEST['username']){
	   $fsql.=" and username like '%{$_REQUEST['username']}%'";
	   $fpage="&username={$_REQUEST['username']}";
   }  
 
 
   $countsql="select count(*) from  member where 1=1 $fsql";
   $pagesql="select * from  member where 1=1 $fsql order by id desc  ";
   $bottom="?action=list{$fpage}";
   $datasql=page($countsql,$pagesql,$bottom,15);
   echo "<form name='delform' id='delform' action='?action=alldel' method='post' class='margin0'>
   <table style='width:98%;' align='center'>";
   if($datasql){
	echo "<tr  bgcolor='#eeeeee' height='30' align='center'><td>USERNAME</td><td>名</td><td>性别</td><td>電話</td><td>EMAIL</td><td>管理</td></tr>";
	while($rs=mysql_fetch_assoc($datasql[1])){   
		echo "<tr height='20' onmouseover=\"this.bgColor = '{$W['tr_color']}'\" onmouseout=\"this.bgColor = ''\">
		  <td align='left'><input   type=checkbox value='{$rs['id']}'  name='allidd[]' id='allidd'>{$rs['username']}</td>
		  <td align='center'>{$rs['realname']}</td>
		  <td align='center'>{$rs['gender']}</td>
		  <td align='center'>{$rs['tel']}</td>
		  <td align='center'>{$rs['email']}</td>
          <td align='center'>		  
		  <a href='?action=add&id={$rs['id']}'>編集</a>  &nbsp; &nbsp;
		  <a href='javascript:ask(\"?action=delete&id={$rs['id']}\")'>削除</a>
          </td>
		  </tr>";
    }
	echo "<tr><td colspan=6 align='right'>
	             <div style='width:280px;float:left'>{$datasql['pl']}{$datasql['pldelete']}</div>
	             <div  style='float:right'>{$datasql[2]}</div>
	             <div style='clear:both;'></div>
	      </td></tr>";
   }
   echo "</table></from>";
   break;
}
include_once("admin_foot.php");
?>