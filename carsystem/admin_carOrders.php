<?php
include_once("admin_head.php");
getadmin();
$action=$_GET['action'];
switch($action){
  case "edit":
  getadmin();
  $id=intval($_GET['id']);
  $Arr=mysql_fetch_assoc(mysql_query ("select * from orders   where id=$id"));
  $Arr=fromTableInForm($Arr);
  ?>
  <script>
  function check(){
	   
   }
  </script>
  <center>
  <div style='width:550px;margin-top:20px;' align='left'>
  <form style='width:550px;' action='?action=save&id=<?php echo $id?>' method='post'  onsubmit='return check()' class='myform' enctype='multipart/form-data' >
   <span class='myspan' style='width:80px;'>住所：</span><input name='address' style="width:400px;" value='<?php echo $Arr['address'] ?>'/><br />
   <span class='myspan' style='width:80px;'>コメント：</span><textarea name='content' style="width:400px;height:60px;"><?php echo $Arr['content'] ?></textarea><br />
   <span class='myspan' style='width:80px;'>状態：</span><select name='status' style='padding:0px;margin:0px;'>
   <option value='4' <?php echo select($Arr['status'],'4')?>>完了</option>
   <option value='3' <?php echo select($Arr['status'],'3')?>>取引開始</option>
   <option value='2' <?php echo select($Arr['status'],'2')?>>取引中</option>
   <option value='1' <?php echo select($Arr['status'],'1')?>>支払い完了</option>
   <option value='0' <?php echo select($Arr['status'],'0')?>>未処理</option>
   </select> 
   <center><input type='submit' value='編集' class='submit'></center></form>
  </div></center>
  <?php
  break;
case "save":
  getadmin();
  $_POST=escapeArr($_POST);
  $id=intval($_GET['id']);
  $query="update `orders` set 
  address='{$_POST['address']}',
  content='{$_POST['content']}',
  status='{$_POST['status']}' where id=$id";
  if(isset($_POST['status'])&&mysql_query($query)) alert("SUCCESS！","?action=list");
  else die($query);
  break;
case "delete":
  getadmin();
  $id=intval($_GET['id']);
  if(mysql_query("delete from orders where id=$id"))
  alert("削除成功！","?action=list");
  break;
case "alldel":
  getadmin();
  $key=$_POST["allidd"];
  for($i=0;$i<count($key);$i++){
	  mysql_query("delete from orders where id={$key[$i]}"); 
  }
  alert("削除成功".count($key)."個！","?action=list");
  break;
case "list":
  getadmin();
   echo "<form style='padding:0px;margin:0px;' action='?action=list' method='post'>
   <span class='status'>&nbsp;&nbsp;<i>予約管理</i></span>&nbsp;&nbsp;&nbsp;&nbsp;
   状態：<select name='status' style='padding:0px;margin:0px;'>
   <option>無制限</option>
   <option value='4'  ".select('4',$_REQUEST['status']).">完了</option>
   <option value='3'  ".select('3',$_REQUEST['status']).">取引開始</option>
   <option value='2'  ".select('2',$_REQUEST['status']).">取引中</option>
   <option value='1'  ".select('1',$_REQUEST['status']).">支払い完了</option>
   <option value='0'  ".select('0',$_REQUEST['status']).">未処理</option>
   </select>
    <input type='submit' value='捜索'>  </form>";   
   $fsql="";$fpage="";  
   if(isset($_REQUEST['status'])&&$_REQUEST['status']!=='無制限'){ $fsql.=" and status='{$_REQUEST['status']}'";$fpage.="&status={$_REQUEST['status']}";}
   $countsql="select count(*) from orders where 1=1 $fsql";
   $pagesql="select * from  orders where 1=1 $fsql order by id desc  ";
   $bottom="?action=list{$fpage}";
   $datasql=page($countsql,$pagesql,$bottom,15);
   echo "<form name='delform' id='delform' action='?action=alldel' method='post' class='margin0'>
   <table style='width:98%;' align='center'>";
   if($datasql){
	echo "<tr  bgcolor='#eeeeee' height='30' align='center'>
	<td>番号</td><td>詳細</td><td>住所</td><td>コメント</td><td>状態</td><td>予約日時</td><td>管理</td></tr>";	
	while($rs=mysql_fetch_assoc($datasql[1])){    
	  $goodsArr=mysql_fetch_assoc(mysql_query("select * from car where id={$rs['carid']}")); 
	  echo "<tr height='20' onmouseover=\"this.bgColor = '{$W['tr_color']}'\" onmouseout=\"this.bgColor = ''\">
		  <td align='left'><input   type=checkbox value='{$rs['id']}'  name='allidd[]' id='allidd'>{$rs['number']}</td>
		  <td align='center'>レンタル車名：{$goodsArr['title']} &nbsp;&nbsp; 価格：{$goodsArr['price']} / 日 </td>
		  <td align='center'>{$rs['address']}</td>
		  <td align='left'>{$rs['content']}</td>
		  <td align='center'>";
		  switch($rs['status']){
			  case "0":echo "未処理";break;
			  case "1":echo "取引開始";break;
			  case "2":echo "取引中";break;
			  case "3":echo "取引完了";break;
			  case "4":echo "返送完了";break;
		  }
		  echo"</td>
	      <td>{$rs['zdates']}</td>
          <td align='center'>		  
		  <a href='?action=edit&id={$rs['id']}'>編集</a>  &nbsp; &nbsp;
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
   echo "</table></form>";
   break;
}
include_once("admin_foot.php");
?>