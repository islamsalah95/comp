<?php
$specialities = array();
if (file_exists(SERVER_ROOT . '/uploads/job_titles.json')) {
    $specialities = file_get_contents(SERVER_ROOT . '/uploads/job_titles.json');
}
$specialities = json_decode($specialities, true);

$is_search = false;

$company_id = $_SESSION['company_id'];
$employee_id = $_SESSION['employee_id'];

// $search_work_exp=$_POST['search_work_exp'];
// $search_price=$_POST['search_price'];



if (isset($_POST['submit_freelancer']) && $_POST['job_title'] !== '') {
    $job_title=$_POST['job_title'];
    $sql = "
    SELECT DISTINCT
    e.*
    FROM employee e
    LEFT JOIN employee_company ec ON e.employee_id = ec.employee_id AND ec.company_id = $company_id
    LEFT JOIN company comp ON comp.id = ec.company_id
    WHERE e.department = '3'
    AND e.job_title LIKE '%$job_title%';";
    $freelancers = myQuery($sql);
    $is_search=true;
    if(!$freelancers){
        $is_search=false;
    }
}





