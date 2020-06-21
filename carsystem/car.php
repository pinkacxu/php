<?php
include_once("head.php");
$action=isset($_GET['action'])?$_GET['action']:"show";
switch($action){
  case "show";
    $id=intval($_GET['id']);
    mysql_query("update car set click=click+1 where id=$id");
    $carArr=mysql_fetch_assoc(mysql_query("select * from car where id='$id'"));
	$pp=mysql_fetch_assoc(mysql_query("select * from brand where id='$carArr[bid]'"));
	$class=mysql_fetch_assoc(mysql_query("select * from carclass where id='$carArr[cid]'"));
	?>
    <script>
	function check2(){
		if(!$("input[name=address]").val()){alert('住所を入力ください'');$("input[name=address]").focus();return false;}
		if(!$("textarea[name=content]").val()){alert('コメントを入力ください');$("textarea[name=content]").focus();return false;}
		return true;
	}
	function yuding(tag,rq){
		if(tag==0)alert("予約不可");
		else{
			var dates=$("input[name=dates]").val();
			var Arrs =[];
			if(dates){
				Arrs = dates.split(",");
			}
			if(Arrs.indexOf(rq)<0){
				Arrs.push(rq);
            }
			else{
				Arrs.splice(Arrs.indexOf(rq),1);
			}
			var newstring=Arrs.join(",");
			$("input[name=dates]").val(newstring);		
			$("td[id^=r]").css({"background":"#66CC66"});		 
			for(var i=0;i<Arrs.length;i++){
               var tags=Arrs[i];
			   $("#r"+tags).css({"background":"#cccccc"});
            }	
		}
	}
    </script>
    <link href="img/calendar_style.css" type="text/css" rel="stylesheet" />
    <?php
	echo "<div style='margin-top:20px;'> 
	 <form name='thisform' action='?action=addorders&id=$id' method='post' style='line-height:2;margin-top:20px;'>
	   <img src='{$carArr['picurl']}' style='border:solid 3px #fff;width:300px;height:250px;float:left;margin:20px;'>
	   <input name='dates' type='hidden'>
	   メーカー名：{$pp[title]}<br>
	   車輌名：{$carArr['title']}<br>
	   車輌タイプ：{$class['title']}<br>
	   価格：{$carArr['price']}<br>
	   いいね数：{$carArr['click']}<br>
	   アドレス：<input name='address' style='width:200px'> <br>
	   コメント：<textarea name='content' style='width:280px;height:90px;'></textarea><br><br>";	   
       echo "<div><div class = 'today'  style='width:90px;height:30px;margin:10px;background-color:#66CC66;color:#000;text-align:center'>可</div></div>";
	   echo "<div><div class = 'sunday' style='width:90px;height:30px;margin:10px;background-color:#FFCC33;color:#000;text-align:center'>不可</div></div>";      
        $params = array();
        if (isset($_GET['year']) && isset($_GET['month'])) {
            $params = array('year' => $_GET['year'], 'month' => $_GET['month'],);
        }
        
        require_once ('include/calendar.php');
        $cal = new calendar($params);
        if (isset($_GET['name'])) {
            $a = $_GET['name'];
            $cal->_Setsun($a);
        }
        if (isset($_GET['forbidden'])) {
            $b = $_GET['forbidden'];
            $cal->_SetTitlehide($b);
        }
        if(isset($_GET['monthhide'])){
            $c = $_GET['monthhide'];
            $cal->_setMonth($c);
        }
       $cal->_drawCalendar();	   	 	   
	   echo "<div style='width:200px;margin:auto'>
	   <img src='img/buy.gif' style='margin:30px auto;cursor:pointer' onclick='";
	   if($M['id']) echo"if(check2())thisform.submit();";
	   else echo "alert(\"登録してください！\");";
	   echo"'></div>
	  </form><br>
	   紹介：{$carArr['content']}
	</div>";
  break;

  case "addorders":
  if(!$M['id']) die();
  $_POST=escapeArr($_POST);
  $num=intval($_POST['num']);
  if($num<=0)$num=1;
  //print_r($_POST);die();
  $query="insert into orders set
  address='{$_POST['address']}',
  content='{$_POST['content']}',
  mid='{$M['id']}',
  zdates='{$_POST['dates']}',
  number='".date("YmdHis").genRandomString(5)."',
  carid='{$_GET['id']}'";
  if(mysql_query($query)){
	   alert("提出成功！","?action=orders_list");
  }
  else die($query);
  break;
  
  case "orders_list":
 
   $countsql="select count(*) from orders where mid='{$M['id']}'";
   $pagesql="select * from  orders where mid='{$M['id']}' order by id desc  ";
   $bottom="?action=orders_list";
   $datasql=page($countsql,$pagesql,$bottom,15);
   echo "
   <table style='width:98%;margin-top:10px;' align='center'>";
   if($datasql){
	echo "<tr  bgcolor='#eeeeee' height='30' align='center'>
	<td>番号</td><td>詳細</td><td>住所</td><td>コメント</td><td>状態</td></tr>";	
	while($rs=mysql_fetch_assoc($datasql[1])){    
	  $carArr=mysql_fetch_assoc(mysql_query("select * from car where id={$rs['carid']}")); 
	  echo "<tr height='25' onmouseover=\"this.bgColor = '{$W['tr_color']}'\" onmouseout=\"this.bgColor = ''\">
		  <td align='left'>{$rs['number']}</td>
		  <td align='left'>レンタル車名：{$carArr['title']} <br> 価格：{$carArr['price']} / 日 </td>
		  <td align='center'>{$rs['address']}</td>
		  <td align='center'>{$rs['content']}</td>
		  <td align='center'>";
		  switch($rs['status']){
			  case "0":echo "未処理";break;
			  case "1":echo "取引中";break;
			  case "2":echo "配送中";break;
			  case "3":echo "取引完了";break;
			  case "4":echo "返送完了";break;
		  }
		  echo"</td>
	      
		  </tr><tr><td>予約日付</td><td colspan=4 align='center'>{$rs['zdates']}</td></tr>";
    }
	echo "<tr><td colspan=5 align='right'>
	             <div style='width:280px;float:left'></div>
	             <div  style='float:right'>{$datasql[2]}</div>
	             <div style='clear:both;'></div>
	      </td></tr>";
   }
   echo "</table></form>";
  break;
  
}
include_once("foot.php");
?>
