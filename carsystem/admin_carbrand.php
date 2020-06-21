<?php
include_once("admin_head.php");
getadmin();
$action=isset($_GET['action'])?$_GET['action']:"list";
switch($action){
case "add":
  getadmin();
  $Arr=array();
  if(isset($_GET['id'])&&$_GET['id']){
	  $id=intval($_GET['id']);
	  $Arr=mysql_fetch_assoc(mysql_query("select * from brand where id='$id'"));
	  $Arr=fromTableInForm($Arr);
  }
  ?>
  <script>
  function check(){
	  if(!$('input[name=title]').val()){alert('メーカー名を入力ください');$('input[name=title]').focus();return false;}
  }
  </script>
  <center>
  <div style='width:320px;height:230px;margin-top:20px;' align='left'>
  <form action='?action=save&id=<?php echo $id?>' method='post'  onsubmit='return check()' class='myform'> 
  メーカー名：<input name='title' style='width:160px;' value='<?php echo $Arr['title'] ?>'><br>
   <center><input type='submit' class='submit' value='更新'></center></form>
  </div></center>
  <?php
  break;
case "save":
  getadmin();
  $_POST=escapeArr($_POST);
  if(isset($_GET['id'])&&$_GET['id']){
	$id=intval($_GET['id']);
	$query="update brand set title='{$_POST['title']}' where id='$id'";
	}
  else{
    $query="insert into brand set title='{$_POST['title']}'";
  }
  if(isset($_POST['title'])&&mysql_query($query))
  alert("SUCCESS！","?action=list");
  break;
case "delete":
  getadmin();
  $id=intval($_GET['id']);
  $find=mysql_fetch_assoc(mysql_query("select * from goods  where cid=$id"));
  if($find) alert('商品はすでに登録されている！','?action=list');  
  if(mysql_query("delete from brand  where id=$id"))
  alert('削除成功','?action=list');
  break;
case "alldel":
  getadmin();
  $key=$_POST["allidd"];
  for($i=0;$i<count($key);$i++){
    $find=mysql_fetch_assoc(mysql_query("select * from  goods  where cid={$key[$i]}"));
	if(!$find)mysql_query("delete from brand  where id={$key[$i]}");
  }
  alert("削除成功".count($key)."個！",'?action=list');
  break;
case "list":
   getadmin();
   echo "<form style='padding:0px;margin:0px;' action='?action=list' method='post'>
   <span class='status'>&nbsp;&nbsp;<i>品質管理</i></span> <input type='button' onclick=\"location='?action=add'\" value='追加'> </form>";       
   $countsql="select count(*) from  brand";
   $pagesql="select * from brand  order by id desc  ";
   $bottom="?action=list ";
   $datasql=page($countsql,$pagesql,$bottom,15);
   echo "<form name='delform' id='delform' action='?action=alldel' method='post' class='margin0'>
   <table style='width:98%;' align='center'>";
   if($datasql){
	echo "<tr  bgcolor='#eeeeee' height='30' align='center'><td>メーカー名</td><td>管理</td></tr>";
	while($rs=mysql_fetch_assoc($datasql[1])){
		echo "<tr height='20' onmouseover=\"this.bgColor = '{$W['tr_color']}'\" onmouseout=\"this.bgColor = ''\">
		  <td align='left'><input   type=checkbox value='{$rs['id']}'  name='allidd[]' id='allidd'>{$rs['title']}</td>
          <td align='center'>		  
		  <a href='?action=add&id={$rs['id']}'>編集</a>  &nbsp; &nbsp;
		  <a href='javascript:ask(\"?action=delete&id={$rs['id']}\")'>削除</a>
          </td>
		  </tr>";		  
    }
	echo "<tr><td colspan=2 align='right'>
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