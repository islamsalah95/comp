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



// if (isset($_POST['submit_freelancer']) && $_POST['job_title'] !== '') {
//     $job_title=$_POST['job_title'];
//     $sql = "
//     SELECT DISTINCT
//     e.*
//     FROM employee e
//     LEFT JOIN employee_company ec ON e.employee_id = ec.employee_id AND ec.company_id = $company_id
//     LEFT JOIN company comp ON comp.id = ec.company_id
//     WHERE e.department = '3'
//     AND e.job_title LIKE '%$job_title%';";
//     $freelancers = $db->myQuery($sql);
//     $is_search=true;
//     if(!$freelancers){
//         $is_search=false;
//     }
// }


if (isset($_POST['submit_freelancer'])) 
 {

    $job_title = isset($_POST['job_title']) ? $_POST['job_title'] : '';
    $emp_name = isset($_POST['emp_name']) ? $_POST['emp_name'] : '';
    $experiences = isset($_POST['experiences']) ? $_POST['experiences'] : '';

    $sql = "
    SELECT DISTINCT
    e.*
    FROM employee e
    LEFT JOIN employee_company ec ON e.employee_id = ec.employee_id 
    LEFT JOIN company comp ON comp.id = ec.company_id
    WHERE e.department IN (2,3)";

    $conditions = array();

    if (!empty($job_title)) {
        $conditions[] = "e.job_title LIKE '%$job_title%'";
    }
    if (!empty($emp_name)) {
        $conditions[] = "e.emp_name LIKE '%$emp_name%'";
    }
    if (!empty($experiences)) {
        $conditions[] = "e.experiences = '$experiences'";
    }

    if (!empty($conditions)) {
        $sql .= " AND " . implode(" AND ", $conditions);
    }

    $freelancers = $db->myQuery($sql);
    
    
    $is_search=true;
    if(!$freelancers){
        $is_search=false;
    }
}






