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
<script  src="include/function.js"></script>
<script>
$().ready(function(){
with(document.documentElement) {bodywidth=(scrollWidth>clientWidth)?scrollWidth:clientWidth;}
var bodyleft=120;
var bodyright=bodywidth-bodyleft-25;
$('#bodyleft').css({'width':bodyleft+'px'});
$('#bodyright').css({'width':bodyright+'px'});
})
</script>
</head>
<body>
<div style=" background-image:url(img/qiche.gif); background-repeat:no-repeat; height:90px; text-indent:200px; font-size:30px; color:#000; font-weight:bold; line-height:90px;letter-spacing:14px;">料料レンタル</div>
<div>
  <div class='ssmenu' id='bodyleft' style="width:150px;font-size:14px; padding:5px 5px 5px 15px;height:600px; line-height:2.5; float:left; border-right:solid 5px #066">
   <b>管理員</b><br />
        &nbsp; &nbsp; <a href='admin_user.php?action=add'>管理員登録</a><br />
        &nbsp; &nbsp; <a href='admin_user.php?action=list'>管理員リスト</a><br />
   <b>会員管理</b><br />
        &nbsp; &nbsp; <a href='admin_member.php?action=add'>会員登録</a><br />
        &nbsp; &nbsp; <a href='admin_member.php?action=list'>会員リスト</a><br />
    <b>車輌分類</b><br />
        &nbsp; &nbsp; <a href='admin_carclass.php?action=add'>追加分類</a><br />
        &nbsp; &nbsp; <a href='admin_carclass.php?action=list'>リスト</a><br />
    <b>品質管理</b><br />
        &nbsp; &nbsp; <a href='admin_carbrand.php?action=add'>メーカー名</a><br />
        &nbsp; &nbsp; <a href='admin_carbrand.php?action=list'>メーカーリスト</a><br />
       
   <b>レンタル管理</b><br />
        &nbsp; &nbsp; <a href='admin_car.php?action=add'>レンタル作成</a><br />
        &nbsp; &nbsp; <a href='admin_car.php?action=list'>レンタルリスト</a><br />
        &nbsp; &nbsp; <a href='admin_carOrders.php?action=list'>予約管理</a><br />
    <a href="javascript:if(confirm('LOGOUT？'))location='admin.php?action=logout'"><b>LOGOUT</b></a><br />
  </div>
  <div style="float:left; margin:auto;" align="left" id='bodyright'>
    
    <?php if(isset($_SESSION['adminname'])) { ?>
    <div style="padding:5px 0px 5px 0px; background-color:#FAFBFC; border:solid 1px #999;">
    &nbsp; &nbsp; >> こんにちは、管理者さん：<?php echo $_SESSION['adminname']?>
    </div>
    <?php 
	}
	?>
    
