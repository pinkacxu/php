<?php
include_once("head.php");
$action=isset($_GET['action'])?$_GET['action']:"index";
switch($action)
{
  case "index":
     ?>
     <div style="border:solid #990 0px; margin-top:0px;">
     <div style="border-bottom:solid #663 5px;   padding:10px; color:#663; font-size:16px; font-weight:bold">
     <?php
	 if(isset($_REQUEST['cid'])&&$_REQUEST['cid']){
		 $searchArr=mysql_fetch_assoc(mysql_query("select * from carclass where id='{$_REQUEST['cid']}'"));
		 echo "{$searchArr['title']} 最新情報";
	 }
	 else echo "最新レンタル情報";
	 ?>
     </div>
     <?php
	  if(isset($_REQUEST['cid'])&&$_REQUEST['cid']){$fsql.=" and cid like '%{$_REQUEST['cid']}%'";$fpage="&cid={$_REQUEST['cid']}";}
	  if(isset($_REQUEST['searchTtile'])&&$_REQUEST['searchTtile']){$fsql.=" and title like '%{$_REQUEST['searchTtile']}%'";$fpage="&searchTtile={$_REQUEST['searchTtile']}";}
	  
	  
      $countsql="select count(*) from car where 1=1 $fsql";
      $pagesql="select * from  car where 1=1 $fsql order by id desc  ";
      $bottom="?action=index{$fpage}";
      $datasql=page($countsql,$pagesql,$bottom,12);
      if($datasql){
		  while($rs=mysql_fetch_assoc($datasql[1])){
	       echo "<div style='float:left;line-height:2' align='center'>
		   <a href='car.php?action=show&id={$rs['id']}'><img src='{$rs['picurl']}' style='width:180px;height:140px;border:solid 1px #ccc; margin:10px 27px;'></a><br>
		   {$rs['title']} &nbsp; {$rs[price]}円/日
		   </div>";
		  }
      }
	echo "
	<div  style='clear:left;'></div>
	<div  style='margin-top:30px;' align='right'>{$datasql[2]}</div>";
 
 

	 ?>
     
     </div>
     <?php
  break;
}
include_once("foot.php");
?>
