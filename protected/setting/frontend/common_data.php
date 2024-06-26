<?php

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
/////////////////////////End Automatic login

if (!$session->Check()) {

    $session->redirect('login', frontend);
}

$user_companies = array();

if ($_SESSION['department'] == 5) {
    $company = $db->run("SELECT * from `company`")->fetchAll();
    if (($_SESSION['company_id'] == '' || $_SESSION['company_id'] == 0) && !empty($company)) {
        $_SESSION['company_id'] = 1;
    }

    $companies = $db->run("SELECT id as company_id, company_name FROM company")->fetchAll();
    if (!empty($companies)) {
        foreach ($companies as $c) {
            // $user_companies[$c['company_id']] = $c['company_name'];
            $user_companies[] = $c['company_id'];
        }
    }
    // echo "<pre>"; print_r($user_companies); exit();
} else if ($_SESSION['department'] == 1  || $_SESSION['department'] == 4 || $_SESSION['department'] == 3) {
    $user_companies = $_SESSION['user_companies'];
} else {
    $user_companies[] = $_SESSION['company_id'];
}

if ($_SESSION['department'] == 1 || $_SESSION['department'] == 4 || $_SESSION['department'] == 3) {
   
    $user_id2=$_SESSION[ 'employee_id' ];
    if ( $_SESSION['department'] == 2 || $_SESSION['department'] == 3) {
        $sql2 = "
        SELECT company.* 
        FROM company
        INNER JOIN employee_company ON employee_company.company_id = company.id 
        INNER JOIN employee ON employee.employee_id = employee_company.employee_id  
        INNER JOIN employee_company_map ON employee_company_map.employee_id = employee.employee_id AND employee_company_map.company_id = company.id 
        WHERE employee.employee_id = $user_id2 
        GROUP BY company.id;
    ";
    }else{
        $sql2 = "
        SELECT company.* 
        FROM company
        INNER JOIN employee_company ON employee_company.company_id = company.id 
        INNER JOIN employee ON employee.employee_id = employee_company.employee_id  
        WHERE employee.employee_id =$user_id2;
    ";
    }
 $company =$db->run($sql2)->fetchAll();


 if ($company) {
    foreach ($company as $c) {
        $user_companies[] = $c['id'];
    }
}


    // $company = $db->run("SELECT * from `company` where id in (" . implode(',', $_SESSION['user_companies']) . ") ")->fetchAll();
}

// $employees = $db->get_all('employee', array('company_id' => $_SESSION['company_id']));
$employees = $db->run("SELECT * from `employee` where (`department`='2' AND `company_id` ='" . $_SESSION['company_id'] . "') or (`department`='3' and `company_id` in (" . implode(',', $user_companies) . ") ) ")->fetchAll();

$user_id = $_SESSION['employee_id'];
$user_details = array();
$users_name = array();

if ($_SESSION['department'] != 2) {
    $user_details = $db->get_all('employee', array('employee_id' => $user_id))[0];
}

foreach ($employees as $val) {
    if ($val['department'] == 2 || $val['department'] == 3) {
        $users_name[] = $val;
        if ($val['employee_id'] == $user_id) {
            $user_details = $val;
        }
    } else {
        if ($val['department'] == 1  && $val['employee_id'] == $user_id) {
            $user_details = $val;
        } elseif ($_SESSION['department'] == 5 || $_SESSION['department'] == 4 || $_SESSION['department'] == 6) {
            if ($val['employee_id'] == $user_id) {
                $user_details = $val;
            }
        }
    }
}

$user_count = count($users_name);
$company_details = $db->get_row('company', array('id' => $_SESSION['company_id']));


define('SITE_DATE_FORMAT', $company_details['date_format']);
if (isset($company_details['name'])) {
    define('SITE_NAME', $company_details['name']);
} else {
    // Handle the case when 'name' key is not found, e.g., provide a default value.
    define('SITE_NAME', 'Default Site Name');
}define('default_timezone', date_default_timezone_get());
define('new_timezone', $company_details['timezone']);

define('CURRENT_LOGIN_ID', $_SESSION['employee_id']);
define('CURRENT_LOGIN_COMPANY_ID', $_SESSION['company_id']);
define('COMPANY_ALLOWED_EMPLOYEE', $company_details['currently_allowed_employee']);


