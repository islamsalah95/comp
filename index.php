<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
@session_start();
//Set in php.ini
$upload_max_size = ini_get('upload_max_filesize');
ini_set('post_max_size', '64M');
ini_set('upload_max_filesize', '64M');
//ini_set('memory_limit', '64M');
//ini_set('max_execution_time', '300');
ini_set('memory_limit', '1024M');
ini_set('max_execution_time', '-1');
//
/**
 * *** define document path**********
 */
define('SERVER_ROOT', dirname(__FILE__));
define('SITE_ROOT', $_SERVER['HTTP_HOST']);
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$get_script_path = pathinfo($_SERVER['SCRIPT_NAME']);
define('SCRIPT_DIR_PATH', $get_script_path['dirname']);
define('SCRIPT_BASE_NAME', $get_script_path['basename']);
define('SCRIPT_FILE_NAME', $get_script_path['filename']);
unset($get_script_path);
if (SCRIPT_DIR_PATH === '/')
    define('SITE_URL', $protocol . SITE_ROOT);
else
    define('SITE_URL', $protocol . SITE_ROOT . SCRIPT_DIR_PATH);

// define ( "SITE_MODE", "debug" );
if (in_array($_SERVER['REMOTE_ADDR'], array("localhost", "127.0.0.1", "::1"))) {
    define("SITE_MODE", "debug");
} else {
    define("SITE_MODE", "prod");
}
if (SITE_MODE == "debug") {
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', '1');
    ini_set('start_up_errors', '1');
    error_reporting(E_ALL ^ E_NOTICE);
} else {
    ini_set('error_reporting', 0);
}
//echo "index"; exit();
if (file_exists(SERVER_ROOT . '/protected/setting/database.php')) {
    require SERVER_ROOT . '/protected/setting/database.php';
}
//echo "index"; exit();
require SERVER_ROOT . '/protected/setting/globals.php';
require SERVER_ROOT . '/protected/setting/router.php';
//////////////////////////Automatic login
if (!isset($_SESSION['email']) ) {

    if (isset($_COOKIE['token'])){
        // if($db->exists('employee', array('token' => $query['token']))){
            $query = $db->get_row('employee', array('token' =>$_COOKIE['token']));
    
            if ($query !== false && is_array($query)) {
                $_SESSION["isAdmin"] = false;
                if ($query['department'] == 1 || $query['department'] == 4 || $query['department'] == 3) {
                    $_SESSION["isAdmin"] = true;
                    $user_companies = array();
                    $employee_company_map = $db->get('employee_company_map', array('employee_id' => $query['employee_id']));
                    if (!empty($employee_company_map)) {
                        foreach ($employee_company_map as $map_data) {
                            if ($db->exists('company', array('id' => $map_data['company_id'])) && $db->get_row('company', array('id' => $map_data['company_id']))['is_valid'] != 0) {
                                $user_companies[] = $map_data['company_id'];
                            }
                        }
                    }
                }
    
                if (is_array($query)) {
                    $session->Open();
                    if (isset($_SESSION)) {
                        $_SESSION['email'] = $query['email'];
                        $_SESSION['employee_id'] = $query['employee_id'];
                        $_SESSION['company_id'] = $query['company_id'];
                        $_SESSION['department'] = $query['department'];
                        $_SESSION['verifyCode'] = 0;
                        if ($query['department'] == 1 || $query['department'] == 4 || $query['department'] == 3) {
                            $_SESSION['user_companies'] = $user_companies;
                            $_SESSION['company_id'] = $user_companies[0];
                        }
    
                        if (isset($_SESSION['department']) && ($_SESSION['department'] == 2)) {
                            $session->redirect('profile', frontend);
                        } else if (isset($_SESSION['department']) && ($_SESSION['department'] == 3)) {
                            $session->redirect('freelancer_profile', frontend);
                        } else {
                            $session->redirect('home', frontend);
                        }
                        $session->redirect('home', frontend);
                    }
                }
            }         
       
    }
} 
/////////////////////////