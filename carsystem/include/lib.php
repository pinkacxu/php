<?php

function alert($msg,$url='index.php'){
	echo "<script>$().ready(function(){alert('$msg');location='$url';})</script>";die();
}

function getadmin($action='show'){
	  global $A;
	  $A=@mysql_fetch_assoc(mysql_query("select * from user where username='{$_SESSION['adminname']}' and password='{$_SESSION['adminpassword']}' "));
	  if(!$A['id']){
		  if($action=='show'){
			 $_SESSION['adminname']="";
	         $_SESSION['adminpassword']="";
             unset($_SESSION['adminname'],$_SESSION['adminpassword']);
		     echo "<script>location='admin.php'</script>";
		     die("No permission");
		  }
		  else return false;
	  }
	  return true;
}

function checkmember($action='show'){
	  global $M;	  
	  $M=@mysql_fetch_assoc(mysql_query("select * from member where username='{$_SESSION['membername']}' and password='{$_SESSION['memberpassword']}'"));
	  if(!$M['id']){
		  if($action=='show'){
			  $_SESSION['membername']="";$_SESSION['memberpassword']="";
              unset($_SESSION['membername'],$_SESSION['memberpassword']);
              echo "<script>location='member.php?action=Login'</script>";
 		      die("No permission");
		  }
		  else return false;
	  }
	  return true;
}

function page($countsql,$pagesql,$bottomsql,$num=20){global $db;
  $page=isset($_GET['page'])?(intval($_GET['page'])>0?intval($_GET['page']):1):1;
  $total=mysql_result(mysql_query($countsql),0); 
  if($total){
    $total_page=ceil($total/$num);
    $page=($page>$total_page)?$total_page:$page;
    $offset=($page-1)*$num;
    $returns[1]=mysql_query($pagesql." limit $offset,$num");
	$returns[2]=pagechang_style($bottomsql,10,$total_page,$page);
	$returns['pl']="
	 <span style='cursor:pointer;float:left;margin-top:5px;' onclick=\"SelectAll('selectAll','delform','allidd')\">全部/</span>
	 <span style='cursor:pointer;float:left;margin-top:5px;' onclick=\"SelectAll('','delform','allidd')\">反/</span>
	 <span style='cursor:pointer;float:left;margin-top:5px;' onclick=\"SelectAll('selectNo','delform','allidd')\">否</span>";
     $returns['pldelete']="<span style='cursor:pointer;float:left;margin-left:10px;margin-top:5px;' onclick=\"if(checkdelform('delform','allidd')&&confirm('削除？')) delform.submit()\">批量删除</span>";
     return $returns;
	}
  else return false;	
}

function pagechang_style($url,$num,$total_page,$page){
		$str="
		<style>
		.ex_page_bottm{border:solid 1px #ccc;display:inline-block;line-height:20px;font-family:simsun;width:40px;cursor:pointer}
		.ex_page_sec{background-color:#eee; }
		.ex_page_link A:visited {TEXT-DECORATION:none;COLOR:#664444;} 
        .ex_page_link A:link    {text-decoration:none;COLOR:#660000;} 
        .ex_page_link A:hover   {TEXT-DECORATION: none;COLOR:#664444;FONT-WEIGHT: normal;FONT-STYLE: normal;} 
		</style>";
	    $str.=" <div class='ex_page_link'>&nbsp;<a href='{$url}&page=1' ><span class='ex_page_bottm'><center>ホームページ</center></span></a>";
        $tempshang=$page-1;$tempxia=$page+1;
        if($page!=1) $str.="&nbsp;<a href='{$url}&page={$tempshang}'><span class='ex_page_bottm'><center>PAGEUP</center></span></a>";
        for($i=1;$i<=$total_page;$i++)
           if($page==$i) $str.="&nbsp;<a href='{$url}&page={$i}'><span class='ex_page_bottm ex_page_sec' style='width:20px;' ><center>{$i}</center></span></a>";
	       else  if($i-$page>=-$num&&$i-$page<=$num) $str.="&nbsp;<a href='{$url}&page={$i}'><span class='ex_page_bottm' style='width:20px;' ><center>{$i}</center></span></a>";
        if($page!=$total_page)  $str.="&nbsp;<a href='{$url}&page={$tempxia}'><span class='ex_page_bottm'><center>PAGEDOWN</center></span></a>";
        $str.=" 
		&nbsp;<span  class='ex_page_bottm'><center><a href='{$url}&page={$total_page}'>LAST</a></center></span>
		&nbsp;<span  class='ex_page_bottm' ><center>{$page}/{$total_page}</center></span></div>";
        return $str;
}
		
function escape($str){
	if(!get_magic_quotes_gpc()) return addslashes($str); 
	else return $str; 
}

function escapeArr($Ar){
	foreach($Ar as $key=>$value){
		$Ar[$key]=escape($value);
	}
	return $Ar;
}
	
function fromTableInForm($rs){
	foreach($rs as $key=>$value)$rs[$key]=str_replace(array("'","\""),array("&#39;","&#34;"),$value);
	return $rs;
}

function genRandomString($len){$chars = array( "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",  "m", "n", "p", "q", "r", "s", "t", "u", "v",  "w", "x", "y", "z", "A", "B", "C", "D", "E", "F","G", "H", "I", "J", "K", "L", "M", "N", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",  "2",  "3", "4", "5", "6", "7", "8", "9" );$charsLen = count($chars) - 1;shuffle($chars);$output = "";for ($i=0; $i<$len; $i++) { $output .= $chars[mt_rand(0, $charsLen)]; }return $output; }

function select($a,$b){
	if($a===$b)return " selected";
}

function getname($exname){
	$dir = "uploadfile/".date("Y-m")."/";
	if(!is_dir($dir)){mkdir($dir,0777);copy("uploadfile/index.php","{$dir}/index.php");}
	while(true){if(!is_file($dir.$i.".".$exname)){$name=$i.".".$exname;break;} $i++;} return $dir.time().genRandomString(12).$name;
} 

?>