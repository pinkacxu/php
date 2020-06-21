<?php
//データベース連接//
  $conn = @mysql_connect("localhost","root","root") or die("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />データベース連接できません：" . mysql_error());
  mysql_select_db("car",$conn) or die("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />データベース選択できません：" . mysql_error());
  mysql_set_charset("utf8");



  error_reporting(E_ALL & ~E_NOTICE);
  date_default_timezone_set("Asia/Japan");



  include_once("include/lib.php");


  $M=array();
  $A=array();
  if(isset($_SESSION['membername'])&&$_SESSION['membername'])checkmember();
  if(isset($_SESSION['adminname'])&&$_SESSION['adminname'])  getadmin();
  $W['tr_color']="#eeeeee";


?>