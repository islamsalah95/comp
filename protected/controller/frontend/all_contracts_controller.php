<?php
function sec2hms_new($seconds)
{

    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $seconds = $seconds % 60;

    return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
}

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
// $sql = "SELECT ecm.*, concat(e.emp_name, ' ', e.emp_surname) as employee_name, ecm.EstLaborOfficeId, ecm.EstSequenceNumber, ecm.is_molTWC, e.employee_national_number, e.dob, e.city_id, c.company_name, s.state, cc.cancellation_reason_id, cc.comment, cc.actual_worked_hours_at_cancellation FROM employee_company_map ecm LEFT JOIN employee e on e.employee_id = ecm.employee_id LEFT JOIN `status` s on s.id = ecm.status_id LEFT JOIN `cancel_contract` cc on cc.number = ecm.id LEFT JOIN company c on c.id = ecm.company_id WHERE ecm.gosi_job_title_id IS NOT NULL and ecm.company_id = $company_id";
// $contracts = $db->run($sql)->fetchAll();
// LEFT JOIN `shift_check` sc on sc.employee_id = e.employee_id  AND sc.company_id = $company_id  
// (select sum(sc.approved_time) from shift_check sc where sc.employee_id = e.employee_id  AND sc.company_id = $company_id ) as approved_time

$sql = "SELECT 
            ecm.*, 
            concat(e.emp_name, ' ', e.emp_surname) as employee_name,
            SUM(sc.approved_time) AS approved_time, 
            sc.create_date,
            sc.id as sc_id,
            ecm.EstLaborOfficeId,
            ecm.EstSequenceNumber,
            ecm.is_molTWC, 
            ecm.start_date,
            ecm.end_date,
            e.employee_national_number,
            e.dob,
            e.city_id,
            c.company_name, 
            s.state,
            cc.cancellation_reason_id,
            cc.comment,
            cc.actual_worked_hours_at_cancellation 
        FROM 
            employee_company_map ecm 
        LEFT JOIN 
            employee e on e.employee_id = ecm.employee_id 
        LEFT JOIN 
            `status` s on s.id = ecm.status_id 
        LEFT JOIN 
            `cancel_contract` cc on cc.number = ecm.id 
        LEFT JOIN 
            company c on c.id = ecm.company_id
        LEFT JOIN 
            `shift_check` sc on
             sc.employee_id = e.employee_id 
             AND
              sc.company_id = $company_id 
              AND
             sc.create_date between ecm.start_date and ecm.end_date   
        WHERE 
            ecm.gosi_job_title_id IS NOT NULL and ecm.company_id = $company_id
        GROUP BY 
            ecm.EstLaborOfficeId,
            ecm.EstSequenceNumber,
            ecm.is_molTWC,
            e.employee_national_number,
            e.dob,
            e.city_id,
            c.company_name, 
            s.state,
            cc.cancellation_reason_id,
            cc.comment,
            cc.actual_worked_hours_at_cancellation";


$contracts = $db->myQuery($sql);

// echo "<pre>"; print_r($contracts); exit();


