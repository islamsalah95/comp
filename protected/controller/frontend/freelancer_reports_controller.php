<?php
/*error_reporting(E_ALL);
ini_set('display_errors', 1);*/

$db->order_by = "`id` ASC";
$r_t = '';
$is_rt = '';

$emp_data = 'e.employee_id, e.company_id, ecm.EstLaborOfficeId, ecm.EstSequenceNumber, ecm.is_molTWC, e.emp_name, e.emp_surname, e.email, e.contact1, e.address, c.company_name';

$all_companies_users = $_REQUEST['all_companies'] ?? 0;

if (($_SESSION['department'] == 5) && isset($_REQUEST['all_companies_user'])) {
    $all_companies_users = 1;
}

$sql = "SELECT " . $emp_data . " 
        FROM `employee` e 
        LEFT JOIN `company` c ON c.id = e.company_id 
        LEFT JOIN employee_company_map ecm ON ecm.employee_id = e.employee_id 
        WHERE e.company_id = " . $_SESSION['company_id'] . " AND e.department = 3 AND ecm.is_molTWC = 1";

if ($all_companies_users == 1) {
    $sql = "SELECT " . $emp_data . " 
            FROM `employee` e 
            LEFT JOIN `company` c ON c.id = e.company_id 
            LEFT JOIN employee_company_map ecm ON ecm.employee_id = e.employee_id 
            WHERE e.department = 3 AND ecm.is_molTWC = 1";
}

if (isset($_REQUEST['twc'])) {
    $r_t = 'twc';
    $is_rt = 'twc';
} elseif (isset($_REQUEST['active'])) {
    $r_t = 'active';
    $is_rt = 'active';
    $sql = "SELECT " . $emp_data . ", COUNT(DISTINCT sc.employee_id) as check_count 
            FROM `employee` e 
            LEFT JOIN `company` c ON c.id = e.company_id 
            LEFT JOIN employee_company_map ecm ON ecm.employee_id = e.employee_id 
            LEFT JOIN shift_check sc ON sc.employee_id = e.employee_id 
            WHERE (e.company_id = " . $_SESSION['company_id'] . " AND e.department = 3) AND sc.employee_id IS NOT NULL 
            GROUP BY " . $emp_data;
    if ($all_companies_users == 1) {
        $sql = "SELECT " . $emp_data . ", COUNT(DISTINCT sc.employee_id) as check_count 
                FROM `employee` e 
                LEFT JOIN `company` c ON c.id = e.company_id 
                LEFT JOIN employee_company_map ecm ON ecm.employee_id = e.employee_id 
                LEFT JOIN shift_check sc ON sc.employee_id = e.employee_id 
                WHERE (e.department = 3) AND sc.employee_id IS NOT NULL 
                GROUP BY " . $emp_data;
    }
} elseif (isset($_REQUEST['inactive'])) {
    $r_t = 'inactive';
    $is_rt = 'inactive';
    $sql = "SELECT " . $emp_data . ", COUNT(DISTINCT sc.employee_id) as check_count 
            FROM `employee` e 
            LEFT JOIN `company` c ON c.id = e.company_id 
            LEFT JOIN employee_company_map ecm ON ecm.employee_id = e.employee_id 
            LEFT JOIN shift_check sc ON sc.employee_id = e.employee_id 
            WHERE (e.company_id = " . $_SESSION['company_id'] . " AND e.department = 3) AND sc.employee_id IS NULL 
            GROUP BY " . $emp_data;
    if ($all_companies_users == 1) {
        $sql = "SELECT " . $emp_data . ", COUNT(DISTINCT sc.employee_id) as check_count 
                FROM `employee` e 
                LEFT JOIN `company` c ON c.id = e.company_id 
                LEFT JOIN employee_company_map ecm ON ecm.employee_id = e.employee_id 
                LEFT JOIN shift_check sc ON sc.employee_id = e.employee_id 
                WHERE (e.department = 3) AND sc.employee_id IS NULL 
                GROUP BY " . $emp_data;
    }
} else {
    $r_t = 'twc';
    $is_rt = 'twc';
}

if ($_SESSION['department'] == 5 || $_SESSION['department'] == 1 || $_SESSION['department'] == 4 || $_SESSION['department'] == 6) {
    $employees = $db->myQuery($sql);
}

if (SITE_DATE_FORMAT == 1) {
    $date_format = "DD-MM-YYYY";
} elseif (SITE_DATE_FORMAT == 2) {
    $date_format = "MM-DD-YYYY";
} elseif (SITE_DATE_FORMAT == 3) {
    $date_format = "Day-Month-Year";
}
?>
