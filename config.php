<?php

$iphost = $_SERVER[SERVER_NAME]; # อ้างถึง host
$url_cmd = 'http://$iphost/competency_wcs/';//url ระบบออกคำสั่ง

$config = array(
    'dbhost'=>'localhost',
    'dbuser'=>'root',
    'dbpass'=>'root',
    'dbs'=>'cmss_master',
    'char_set'=>'tis620',
    'char_collate'=>'tis620_thai_ci',
    'debug'=>false
);


?>