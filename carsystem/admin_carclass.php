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
	  $Arr=mysql_fetch_assoc(mysql_query("select * from carclass where id='$id'"));
	  $Arr=fromTableInForm($Arr);
  }
  ?>
  <script>
  function check(){
	  if(!$('input[name=title]').val()){alert('分類名を入力ください');$('input[name=title]').focus();return false;}
  }
  </script>
  <center>
  <div style='width:320px;height:230px;margin-top:20px;' align='left'>
  <form action='?action=save&id=<?php echo $id?>' method='post'  onsubmit='return check()' class='myform' enctype='multipart/form-data'> 
  <span class='myspan' style='width:80px;'>分類名：</span><input name='title' style='width:160px;' value='<?php echo $Arr['title'] ?>'><br>
  <span class='myspan' style='width:80px;'>写真：</span><input type='file' style='width:220px;' id='upload' name='upload'><br>
   <center><input type='submit' class='submit' value='更新'></center></form>
  </div></center>
  <?php
  break;
case "save":
  getadmin();
  $_POST=escapeArr($_POST);
  //
  $exname=strtolower(substr($_FILES['upload']['name'],(strrpos($_FILES['upload']['name'],'.')+1)));
  $uploadfile = getname($exname);
  $exetxt=array("jpg","gif","png");
  if (!in_array ($exname,array("exe","php","js","asp","aspx","jsp","html","htm"),true)&&in_array ($exname,$exetxt,true)&&$_FILES['upload']['size']>0&&move_uploaded_file($_FILES['upload']['tmp_name'],$uploadfile))
  $_POST['picurl']=$uploadfile; 
  //
  $baseQuery="title='{$_POST['title']}'";
  $baseQuery.=$_POST['picurl']?",picurl='$_POST[picurl]'":"";
  if(isset($_GET['id'])&&$_GET['id']){
	$id=intval($_GET['id']);
	$query="update carclass set $baseQuery where id='$id'";
	}
  else{
    $query="insert into carclass set $baseQuery";
  }
  if(isset($_POST['title'])&&mysql_query($query))
  alert("SUCCESS！","?action=list");
  break;
case "delete":
  getadmin();
  $id=intval($_GET['id']);
  $find=mysql_fetch_assoc(mysql_query("select * from car  where cid=$id"));
  if($find) alert('商品はすでに登録されている！','?action=list');  
  if(mysql_query("delete from carclass  where id=$id"))
  alert('削除成功','?action=list');
  break;
case "alldel":
  getadmin();
  $key=$_POST["allidd"];
  for($i=0;$i<count($key);$i++){
    $find=mysql_fetch_assoc(mysql_query("select * from  car  where cid={$key[$i]}"));
	if(!$find)mysql_query("delete from carclass  where id={$key[$i]}");
  }
  alert("削除".count($key)."個！",'?action=list');
  break;
case "list":
   getadmin();
   echo "<form style='padding:0px;margin:0px;' action='?action=list' method='post'>
   <span class='status'>&nbsp;&nbsp;<i>分類管理</i></span> <input type='button' onclick=\"location='?action=add'\" value='追加'> </form>";       
   $countsql="select count(*) from  carclass";
   $pagesql="select * from carclass  order by id desc  ";
   $bottom="?action=list ";
   $datasql=page($countsql,$pagesql,$bottom,15);
   echo "<form name='delform' id='delform' action='?action=alldel' method='post' class='margin0'>
   <table style='width:98%;' align='center'>";
   if($datasql){
	echo "<tr  bgcolor='#eeeeee' height='30' align='center'><td>名</td><td>写真</td><td>管理</td></tr>";
	while($rs=mysql_fetch_assoc($datasql[1])){
		echo "<tr height='20' onmouseover=\"this.bgColor = '{$W['tr_color']}'\" onmouseout=\"this.bgColor = ''\">
		  <td align='left'><input   type=checkbox value='{$rs['id']}'  name='allidd[]' id='allidd'>{$rs['title']}</td>
		  <td><a href='{$rs['picurl']}' target='_blank'><img src='{$rs['picurl']}'></a></td>
          <td align='center'>		  
		  <a href='?action=add&id={$rs['id']}'>編集</a>  &nbsp; &nbsp;
		  <a href='javascript:ask(\"?action=delete&id={$rs['id']}\")'>削除</a>
          </td>
		  </tr>";		  
    }
	echo "<tr><td colspan=3 align='right'>
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