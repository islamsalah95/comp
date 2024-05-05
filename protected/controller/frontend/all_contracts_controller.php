<?php

$company_id = $_SESSION['company_id'];
// $employee_id = $_REQUEST['employee_id'];
// if ($_SESSION['department'] == 3) {
//     $employee_id == $_SESSION['employee_id'];
// }
$allowed_types = [5];
if (!in_array($_SESSION['department'], $allowed_types)) {
    echo "<script>window.location = '" . SITE_URL . "'</script>";
}

// $sql = "SELECT ecm.*, concat(e.emp_name, ' ', e.emp_surname) as employee_name, e.IdNumber, e.EstLaborOfficeId, e.EstSequenceNumber, e.employee_national_number, e.dob, e.city_id, c.company_name FROM employee_company_map ecm LEFT JOIN employee e on e.employee_id = ecm.employee_id LEFT JOIN company c on c.id = ecm.company_id WHERE ecm.employee_id = $employee_id and ecm.company_id = $company_id";
// $sql = "SELECT ecm.*, concat(e.emp_name, ' ', e.emp_surname) as employee_name, e.IdNumber, e.EstLaborOfficeId, e.EstSequenceNumber, e.employee_national_number, e.dob, e.city_id, c.company_name FROM employee_company_map ecm LEFT JOIN employee e on e.employee_id = ecm.employee_id LEFT JOIN company c on c.id = ecm.company_id WHERE ecm.gosi_job_title_id IS NOT NULL and ecm.company_id = $company_id";
// $sql = "SELECT ecm.*, concat(e.emp_name, ' ', e.emp_surname) as employee_name, ecm.EstLaborOfficeId, ecm.EstSequenceNumber, ecm.is_molTWC, e.employee_national_number, e.dob, e.city_id, c.company_name, s.state FROM employee_company_map ecm LEFT JOIN employee e on e.employee_id = ecm.employee_id LEFT JOIN `status` s on s.id = ecm.status_id LEFT JOIN company c on c.id = ecm.company_id WHERE ecm.gosi_job_title_id IS NOT NULL and ecm.company_id = $company_id";
// add new columns
$sql = "SELECT ecm.*, concat(e.emp_name, ' ', e.emp_surname) as employee_name, ecm.EstLaborOfficeId, ecm.EstSequenceNumber, ecm.is_molTWC, e.employee_national_number, e.dob, e.city_id, c.company_name, s.state, cc.cancellation_reason_id, cc.comment, cc.actual_worked_hours_at_cancellation FROM employee_company_map ecm LEFT JOIN employee e on e.employee_id = ecm.employee_id LEFT JOIN `status` s on s.id = ecm.status_id LEFT JOIN `cancel_contract` cc on cc.number = ecm.id LEFT JOIN company c on c.id = ecm.company_id WHERE ecm.gosi_job_title_id IS NOT NULL and ecm.company_id = $company_id";
$contracts = $db->run($sql)->fetchAll();
// $contracts = $db->myQuery($sql);

// echo "<pre>"; print_r($contracts); exit();