<?php
include_once("head.php");
$action=isset($_GET['action'])?$_GET['action']:"index";
switch($action)
{
  case "index":
     ?>
     <div style="border:solid #990 0px; margin-top:0px;" >
       <div style="border-bottom:solid #06F 5px;   padding:10px; color:#03F; font-size:16px; font-weight:bold">lease terms</div>
       <div style="padding:10px; line-height:2">
       lease terms 
        </div>
     </div>
     <?php
  break;
}
include_once("foot.php");
?>
