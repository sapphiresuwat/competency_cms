<?php

$iphost= $_SERVER[SERVER_NAME];
$host_main = "master.cmss-otcsc.com"; # เครื่องหลัก master ที่ ip 122.155.202.62
$url_cmd = "http://61.19.255.79/competency_wcs/";#"http://wcs.cmss-otcsc.com"; # ระบบออกคำสั่ง
#$url_cmd = "http://".$host_main."/competency_wcs/";//url ระบบออกคำสั่ง

$config = array(
    'dbhost'=>'localhost',
    'dbuser'=>'root',
    'dbpass'=>'root',
    'dbs'=>'cmss_master',
    'char_set'=>'tis620',
    'char_collate'=>'tis620_thai_ci',
    'debug'=>false
);


$iphost2 = $host_main;#"personapp.cmss-otcsc.com";# ip สำหรับระบบตรวจสอบรับรองข้อมูล(ip 122.155.202.63) เดิม personapp.cmss-otcsc.com
$iphost3 = $host_main;#"docelec.cmss-otcsc.com"; # สำหรับระบบบันทึกข้อมูล ก.ค.ศ. 16(ip 122.155.202.63) เดิม docelec.cmss-otcsc.com
$iphost4 = $host_main;#"salary.cmss-otcsc.com"; # ระบบเลื่อนเงินเดือน (ip 122.155.202.156) เดิม salary.cmss-otcsc.com
$iphost5 = $host_main;#"eservice.cmss-otcsc.com"; # ระบบ e-service (ip 122.155.202.156) เดิม eservice.cmss-otcsc.com
$temp_ip = "61.19.255.78"; # ip เครื่อง ไฟล์ Server (ใช้ชั่วคราว)


?>