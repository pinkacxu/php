<?php
include_once("admin_head.php");
getadmin();
$action=$_GET['action'];
switch($action){
 case "add": 
  $Arr=array();
  if(isset($_GET['id'])&&$_GET['id']){
	  $id=intval($_GET['id']);
	  $Arr=mysql_fetch_assoc(mysql_query("select * from car where id='$id'"));
	  $Arr=fromTableInForm($Arr);
  }
  ?>
  <script>
  function check(){
	  if(!$('input[name=title]').val()){alert('商品名を入力ください');$('input[name=title]').focus();return false;}
	  <?php if(!$id){?>
	  if(!$('input[name=upload]').val()){alert('写真を入力ください');$('input[name=upload]').focus();return false;}
	  <?php }?>
  }
  </script>
  <center>
  <div style='width:420px;height:230px;margin-top:20px;' align='left'>
  <form style="width:400px;" action='?action=save&id=<?php echo $id?>' method='post'  onsubmit='return check()' class='myform' enctype='multipart/form-data' >
  <span class='myspan' style='width:80px;'>車輌タイプ：</span><select name='cid' style='width:160px;'>
   <?php
   $cQuery=mysql_query("select * from carclass ");
   while($cArr=mysql_fetch_assoc($cQuery)){
	   echo "<option value='{$cArr['id']}' ".select($Arr['cid'],$cArr['id']).">{$cArr['title']}</option>";
   }
   ?>
   </select><br>
   <span class='myspan' style='width:80px;'>メーカー：</span><select name='bid' style='width:160px;'>
   <?php
   $cQuery=mysql_query("select * from brand ");
   while($cArr=mysql_fetch_assoc($cQuery)){
	   echo "<option value='{$cArr['id']}' ".select($Arr['bid'],$cArr['id']).">{$cArr['title']}</option>";
   }
   ?>
   </select><br>
   <span class='myspan' style='width:80px;'>車輌タイプ：</span><input name='title' style='width:160px;' value='<?php echo $Arr['title'] ?>'><br>
   <span class='myspan' style='width:80px;'>レンタル価格：</span><input name='price' style='width:60px;' value='<?php echo $Arr['price'] ?>'>/天<br>
   <span class='myspan' style='width:80px;'>写真アップロード：</span><input type='file' style='width:220px;' id='upload' name='upload'><br>
   <span class='myspan' style='width:80px;'>紹介：</span><textarea  name='content' style='width:400px;height:100px;'><?php echo $Arr['content'] ?></textarea><br>  
   <center><input type='submit' class='submit'value='更新''></center></form>
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
 if(isset($_GET['id'])&&$_GET['id']){
	$id=intval($_GET['id']);
	$fsql=$_POST['picurl']?",picurl='{$_POST['picurl']}'":"";
    $query="update car set 
	cid='{$_POST['cid']}',
	bid='{$_POST['bid']}',
	title='{$_POST['title']}',
	price='{$_POST['price']}',
	content='{$_POST['content']}' $fsql where id=$id";
  }
  else{
    $query="insert into car set 
	cid='{$_POST['cid']}',
	title='{$_POST['title']}',
    picurl='{$_POST['picurl']}',
	bid='{$_POST['bid']}',
    price='{$_POST['price']}',
    content='{$_POST['content']}'";
  }
  if(isset($_POST['title'])&&mysql_query($query)) alert("操作成功！","?action=list");
  else die($query);
  break;
case "delete":
  getadmin();
  $id=intval($_GET['id']);
  if(mysql_query("delete from car where id=$id"))
  alert("DELETE！","?action=list");
  break;
case "alldel":
  getadmin();
  $key=$_POST["allidd"];
  for($i=0;$i<count($key);$i++){
	  mysql_query("delete from car where id={$key[$i]}"); 
  }
  alert("DELETE".count($key)."個！","?action=list");
  break;
case "list":
   echo "<form style='padding:0px;margin:0px;' action='?action=list' method='post'>
   <span class='status'>&nbsp;&nbsp;<i>レンタル管理</i></span>&nbsp;&nbsp;&nbsp;&nbsp;
   車名：<input name='title' value='{$_REQUEST['title']}' style='padding:0px;margin:0px;'>
    <input type='submit' value='捜索'>   <input type='button' onclick=\"location='?action=add'\" value='追加'></form>";   
   $fsql="";$fpage="";
   if(isset($_REQUEST['title'])&&$_REQUEST['title']){$fsql.=" and title like '%{$_REQUEST['title']}%'";$fpage="&title={$_REQUEST['title']}";}
   if(isset($_REQUEST['cid'])&&$_REQUEST['cid']){$fsql.=" and cid like '%{$_REQUEST['cid']}%'";$fpage="&cid={$_REQUEST['cid']}";}

 
   $countsql="select count(*) from car where 1=1 $fsql";
   $pagesql="select * from  car where 1=1 $fsql order by id desc  ";
   $bottom="?action=list{$fpage}";
   $datasql=page($countsql,$pagesql,$bottom,15);
   echo "<form name='delform' id='delform' action='?action=alldel' method='post' class='margin0'>
   <table style='width:98%;' align='center'>";
   if($datasql){
	echo "<tr  bgcolor='#eeeeee' height='30' align='center'><td>名</td><td>类</td><td>価格</td><td>写真</td><td>紹介</td><td>管理</td></tr>";
	while($rs=mysql_fetch_assoc($datasql[1])){
		 $type=mysql_fetch_assoc(mysql_query("select * from carclass where id='{$rs['cid']}'"));    
	   	 echo "<tr height='20' onmouseover=\"this.bgColor = '{$W['tr_color']}'\" onmouseout=\"this.bgColor = ''\">
		  <td align='left'><input   type=checkbox value='{$rs['id']}'  name='allidd[]' id='allidd'>{$rs['title']}</td>
		  <td align='center'>{$type['title']}</td>
		  <td align='center'>{$rs['price']}/日</td> 
		  <td align='center'><a href='{$rs['picurl']}' target='_blank'>総覧</a></td>
		  <td align='left'>{$rs['content']}</td>
          <td align='center'>		  
		  <a href='?action=add&id={$rs['id']}'>編集</a>  &nbsp; &nbsp;
		  <a href='javascript:ask(\"?action=delete&id={$rs['id']}\")'>削除</a>
          </td>
		  </tr>";
    }
	echo "<tr><td colspan=7 align='right'>
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