<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

//$DOMAIN_NAME = "http://localhost/techsup_flex_time/";
$DOMAIN_NAME = "https://46.151.212.57/";


// //MYSQL DATABASE ACCESS SETTINGS
// $DBHost="127.0.0.1";
// $DBUser="techsupf_techsup";
// $DBPass="techsup_flex_time";
// $DBName="techsupf_flex_time";
// $DBprefix="";

//MYSQL DATABASE ACCESS SETTINGS
$DBHost="localhost";
$DBUser="root";
$DBPass="";
$DBName="techsupf_flex_time";
$DBprefix="";

define('DOMAIN_NAME', $DOMAIN_NAME);
$is_local = array('127.0.0.1', '::1');
if(in_array($_SERVER['REMOTE_ADDR'], $is_local)){
    define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'].'/');
}
else{
    define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'].'/');
}
define('DBHost', $DBHost);
define('DBUser', $DBUser);
define('DBPass', $DBPass);
define('DBName', $DBName);
define('DBprefix', $DBprefix);
?>