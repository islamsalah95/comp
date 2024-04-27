<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if($_SESSION['company_id'] && $_SESSION['employee_id'] && $_SESSION['department']==2 || $_SESSION['department']==3    ){
    $company_id = $_SESSION['company_id'];
    $employee_id = $_SESSION['employee_id'];
}else{
$company_id = $_SESSION['company_id'];
$employee_id = $_POST['employee_id'];
}

// $company_id = $_SESSION['company_id'];
// $employee_id = $_SESSION['employee_id'];

// $sqlPrevious_jobs=" SELECT pa.employee_id, pa.project_id, p.project_name, p.rating, c.company_name, GROUP_CONCAT(DISTINCT t.task_name) as task_name, SUM(sc.check_out_time) as working_hours 
//                     FROM project_assign pa 
//                     LEFT JOIN projects p on pa.project_id = p.project_id 
//                     LEFT JOIN company c ON pa.company_id = c.id 
//                     LEFT JOIN to_do_list t on pa.project_id = t.project_id 
//                     LEFT JOIN shift_check sc on (pa.project_id = sc.project_id AND pa.employee_id = sc.employee_id AND pa.company_id = sc.company_id AND t.task_id = sc.task_id) 
//                     WHERE pa.employee_id = $employee_id AND pa.company_id = $company_id GROUP BY pa.project_id";
// $previous_jobs = $db->run($sqlPrevious_jobs)->fetchAll();

$previous_jobs = sqlPrevious_jobs( $employee_id ,  $company_id );


$sql = "SELECT working_hours,
        id,
        start_date,
        end_date,
        working_hours_per_day,
        hourly_rate, 
        working_hours_per_week,
        gosi_job_title_id,
        job_title,
        created_on, 
        message
        FROM employee_company_map  
        WHERE 
        employee_id = $employee_id 
        AND 
        company_id = $company_id";
 $contracts = $db->run($sql)->fetchAll();


