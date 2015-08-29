<?php
/**
* @comment counter นับจำนวนคนเข้าชมเว็บไซค์
* @projectCode 56CMSS09
* @tor
* @package core
* @author Sathianphong Sukin
* @access public
* @created 21/08/2014
*/
session_start();
include ("config.inc.php");
	include ("../competency_master/config/cmss_var.php");
	include("../competency_master/common/common_competency.inc.php");
	ConHost(HOST,USERNAME_HOST,PASSWORD_HOST);
//====GEN Counter==============================
/*	$host = "localhost";
	$username = "sapphire";
	$password = "sprd!@#$%";
	$cms_db = "competency_cms";


	$myconnect = @mysql_connect($host,$username,$password) ; //OR DIE("Unable to connect to database :: $host ");
	$iresult = mysql_query("SET character_set_results=tis-620");
	$iresult = mysql_query("SET NAMES TIS620");
*/
	$cms_db = "competency_cms";

	$ses_id = session_id() ;
	$str_gen_table = " CREATE TABLE  IF NOT EXISTS `log_counter` (  `file_name` varchar(255) NOT NULL default '',  `count_page` int(11) default NULL,  PRIMARY KEY  (`file_name`)) TYPE=MyISAM; ";
	@mysql_db_query($cms_db,$str_gen_table);

	$file_active = basename($PHP_SELF);
		$file_active ='index.php';
	if($_GET[from]!=""){
		 $file_active =$from;
	}

	
	$str_sql = "SELECT *  from log_counter WHERE file_name = '$file_active' ";
	$query1=@mysql_db_query($cms_db,$str_sql);
	$rs_1 = @mysql_fetch_array($query1);	
		if($rs_1){		
			if($file_active2 != $file_active ){
			$count_nm = $rs_1[count_page] + 1 ;
			session_register("file_active2");
			$file_active2 = $file_active;
			$str_sql2 = " update log_counter SET count_page = '$count_nm' WHERE  file_name = '$file_active' ";
			@mysql_db_query($cms_db,$str_sql2);
			
			}		
		}else{
			session_register("file_active2");
			$n = 606328; // สุ่มค่า หากยังไม่เคย view มาก่อน
			$file_active2 = $file_active;
			$str_rp = " Replace Into log_counter(file_name,count_page) VALUES ('$file_active','$n') "	;
			@mysql_db_query($cms_db,$str_rp);
		}

	$str_sql3 = "SELECT *  from log_counter WHERE file_name = '$file_active' ";
	$query3 = @mysql_db_query($cms_db,$str_sql3);
	$rs_3 = @mysql_fetch_array($query3);
	
	function get_real_ip()
{
	$ip = false;
	if(!empty($_SERVER['HTTP_CLIENT_IP']))	{
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}

	if ($ip){
		return ($_SERVER['REMOTE_ADDR'] . "/$ip");
	}else{
		return ($_SERVER['REMOTE_ADDR'] );
	}
}

$result_c = @mysql_db_query($cms_db,"  SELECT count(session_id)  AS  cnum FROM  log_counterpage  ; ") ;
$rs_c = @mysql_fetch_assoc($result_c);

//@modify Sathianphong 21/08/2014 เพิ่มผู้เข้าเยี่ยมชมเว็บไซค์
	//$date  =date("d-m-Y");
	/* $timeoutseconds = 300;//ตั้งเวลาสำหรับเช็คคนออนไลน์ เป็นวินาที 300= 5 นาที
	$timestamp=time();
	$timeout=$timestamp-$timeoutseconds;
	$date = date("Y-m-d");
	$ip = $_SERVER['REMOTE_ADDR'];
	$sql_counter="INSERT INTO counter(date_visit,ip_visit,visit,time_update,timestamp,file)VALUES('$date', '$ip', '1', NOW(), $timestamp, '$PHP_SELF')";
	@mysql_db_query($cms_db,$sql_counter);
	//ลบออกกรณีที่เกินกำหนดเวลาที่ตั้งไว้แล้ว ให้ลบออกฐานข้อมูล
	mysql_db_query($cms_db, "DELETE FROM counter WHERE timestamp<$timeout") or die("Useronline Database DELETE Error"); */
//@end
//====END GEN COUNTER====================================
?>
<style>
.num{
	font-size:14px;
		font-family:Arial, Helvetica, sans-serif
	font-weight: normal;
	color: #000;
	text-shadow: 0 1px 1px rgba(0,0,0, .3);
}.result_detail{
	font-size:12px;
		font-family:Arial, Helvetica, sans-serif
	font-weight: normal;
	color: #000;
	text-shadow: 0 1px 1px rgba(0,0,0, .3);
}
.caption{
	font-size:14px;
		font-family:Arial, Helvetica, sans-serif
	font-weight: bold;
	color: #000;
	text-shadow: 0 1px 1px rgba(0,0,0, .3);
}
body {
	background: #fbfbfb;
	font-size:14px;
	font-family:Arial, Helvetica, sans-serif;
	margin-left: 0px;
	margin-top: 0px;
	margin-bottom: 0px;
}
</style>
<?php
$db_system='competency_system';
$today = date('Y-m-d');  
//$sql_numcount="SELECT count(DISTINCT(ip_visit)) as visit From counter where file='$PHP_SELF'";

#@modify Suwat.K เพิ่มเงิอนไขการลบเพื่อเคลี่ยร์ session expire
mysql_db_query($db_system," DELETE from useronline WHERE  timeupdate <  DATE_SUB(NOW(), INTERVAL 30 MINUTE); ");
mysql_db_query($db_system," DELETE from useronline WHERE  timeupdate <  DATE_SUB(NOW(), INTERVAL 10 MINUTE)  AND  appname = 'register' ; ");
#@end

$sql_numcount="SELECT count(sessionid) as visit FROM useronline";
$result= mysql_db_query($db_system,$sql_numcount);
$row = mysql_fetch_assoc($result);  
$visit = $row['visit'];  
//@modify Piyachon 11/9/2557 เพิ่มรายการระบบที่ใช้,เขตที่ใช้
$dis_app = array('login','');
$sql_countdetail="SELECT
	tbl_user.appname,
	tbl_appname.id,
	tbl_appname.detail,
	COUNT(tbl_user.appname) AS sum_all
FROM
	useronline AS tbl_user
LEFT JOIN competency_system.appname_list AS tbl_appname ON tbl_user.appname = tbl_appname.id
GROUP BY
	appname
ORDER BY
	sum_all DESC";
$sql_site_detail="SELECT
	tbl_area.secname_short,
	tbl_user.siteid,
	COUNT(tbl_user.appname) AS sum_all
FROM
	useronline AS tbl_user
LEFT JOIN cmss_master.eduarea AS tbl_area ON tbl_user.siteid = tbl_area.secid
GROUP BY
	appname
ORDER BY
	sum_all DESC";
$result_detail= mysql_db_query($db_system,$sql_countdetail);
$result_site= mysql_db_query($db_system,$sql_site_detail);
?>
<body>
<table width="168" cellpadding="0" cellspacing="2" >
<tr><th align="right" class="caption" valign="top"><a href="http://master.cmss-otcsc.com/competency_master/application/useronline/index.php" target="_blank">จำนวนผู้ใช้งานระบบ</a></th></tr>
<tr><td align="right" class="num">Online : <?php //echo number_format($rs_c[cnum])?><?php echo number_format($visit)?> คน</td></tr>
<tr><th align="right" class="caption" valign="top">ระบบที่เข้าใช้งาน</th></tr>
<?php
while($row_detail = mysql_fetch_assoc($result_detail)){
	if(($i<3)&&(!in_array($row_detail['appname'],$dis_app,false))){
?>
<tr><td align="right" class="result_detail"><?php echo ($row_detail['detail']==''?$row_detail['appname']:$row_detail['detail']).' : '.number_format($row_detail['sum_all'])?>&nbsp;คน</td></tr>
<?php 
	$i++;
	}else{
		$sum_pers = $sum_pers+$row_detail['sum_all'];
	}
} 
$i=0;
?>
<tr><td align="right" class="result_detail">อื่นๆ :&nbsp;<?=number_format($sum_pers)?>&nbsp;คน</td></tr>
<tr><th align="right" class="caption" valign="top">เขตที่เข้าใช้งาน</th></tr>
<?php
while($row_site = mysql_fetch_assoc($result_site)){
	if(($i<3)&&($row_site['secname_short']!='')){
	$secname = explode('(',$row_site['secname_short']);
	$dis_secname = array('สพป.');
?>
<tr><td align="right" class="result_detail"><?php echo str_replace($dis_secname,'',$secname[0]).' : '.number_format($row_site['sum_all'])?>&nbsp;คน</td></tr>
<?php 
	$i++;
	}else{
		$sum_site = $sum_site+$row_site['sum_all'];
	}
} 
$i=0;
?>
<tr><td align="right" class="result_detail">อื่นๆ :&nbsp;<?=number_format($sum_site)?>&nbsp;คน</td></tr>
<? //@end ?>
<tr><th align="right" class="caption" valign="top">สถิติ</th></tr>
<tr><td align="right" class="num">
<?
			$x = number_format($rs_3[count_page]);
			for ($i=0;$i<strlen($x);$i++){
				$digit = substr($x,$i,1);
				echo "<img src='digit/no_{$digit}.png' border=0>";
			}
			?>
</td></tr>
</table>
</body>

<?
mysql_close();
?>