<?
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
//====END GEN COUNTER====================================
?>
<style>
.num{
	font-size:14px;
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
		background: #ebebeb;
		font-size:14px;
		font-family:Arial, Helvetica, sans-serif
}
</style>
<body>
<table width="168" cellpadding="0" cellspacing="2" >
<tr><th align="left" class="caption" valign="top">ผู้เข้าชมในขณะนี้</th></tr>
<tr><td align="left" class="num">Online: <?=number_format($rs_c[cnum])?> คน</td></tr>
<tr><th align="left" class="caption" valign="top">สถิติ</th></tr>
<tr><td align="left" class="num">View: <?=number_format($rs_3[count_page])?> ครั้ง</td></tr>
</table>
</body>

<?
mysql_close();
?>