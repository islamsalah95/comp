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

$sqlPrevious_jobs = "
SELECT DISTINCT
    pa.employee_id, 
    pa.project_id, 
    p.project_name, 
    p.rating,
    p.start_date AS project_start_date,
    p.end_date AS project_end_date, 
    t.start_date AS task_start_date,
    t.task_id,
    t.end_date AS task_end_date, 
    co.start_date AS contract_start_date,
    co.end_date AS contract_end_date,
    co.job_title AS title,
    co.working_hours AS total_working_hours,
    c.company_name, 
    GROUP_CONCAT(DISTINCT t.task_name) AS task_name, 
    SUM(sc.check_out_time) AS working_hours 
FROM 
    project_assign pa 
LEFT JOIN 
    projects p ON pa.project_id = p.project_id 
LEFT JOIN 
    company c ON pa.company_id = c.id 
LEFT JOIN 
    to_do_list t ON pa.project_id = t.project_id 
LEFT JOIN 
    shift_check sc ON (pa.project_id = sc.project_id AND pa.employee_id = sc.employee_id AND pa.company_id = sc.company_id AND t.task_id = sc.task_id) 
LEFT JOIN 
    employee_company_map co ON (co.employee_id = :employee_id AND co.company_id = :company_id AND p.start_date BETWEEN co.start_date AND co.end_date
    AND t.start_date BETWEEN co.start_date AND co.end_date
    )
WHERE 
    pa.employee_id = :employee_id 
GROUP BY 
    pa.employee_id, 
    pa.project_id, 
    p.project_name, 
    p.rating,
    p.start_date,
    p.end_date,
    t.start_date,
    t.end_date,
    t.task_id ,
    co.start_date,
    co.end_date,
    co.job_title,
    co.working_hours,
    c.company_name;  
";
$previous_jobs = $db->sqlPrevious_jobs($employee_id, $company_id,$sqlPrevious_jobs);
$repatedTasks = [];
$previous_jobsArray = [];

// Filter out repeated tasks
foreach ($previous_jobs as $job) {
    $task_id = $job['task_id'];
    if (!in_array($task_id, $repatedTasks)) {
        $repatedTasks[] = $task_id;
        $previous_jobsArray[] = $job;
    }
}




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


