<?php
if (isset($_POST) && isset($_POST['selected_company_id']) && $_POST['selected_company_id'] != '') {
  $_SESSION['company_id'] = $_POST['selected_company_id'];
}

$total_projects = $db->get_count('projects', array('company_id' => $_SESSION['company_id']));
$total_tasks = $db->get_count('to_do_list', array('company_id' => $_SESSION['company_id']));

$total_companies = $db->get_count('company');
$total_users = count($db->run('select * from employee where department in (2, 3)')->fetchAll());
  $total_online_users = count(myQuery("SELECT employee_id, COUNT(*) AS total_online_users
FROM `shift_check`
WHERE current_dt = '".date('Y-m-d')."' and (check_out = '' or check_out IS NULL)
GROUP BY employee_id;
"));




$total_freelancer = count($db->run("SELECT * from `employee` where (`department`='3' and `employee_id` in (SELECT `employee_id` FROM employee_company_map WHERE  `company_id` = " . $_SESSION['company_id'] . " ) )")->fetchAll());

$sql = "SELECT p.project_name, COUNT(*) emp_count FROM `project_assign` pa LEFT JOIN projects p on pa.project_id = p.project_id  WHERE p.end_date >= '" . date('Y-m-d') . "' AND pa.company_id = " . $_SESSION['company_id'] . " GROUP BY pa.project_id";
$company_projects = $db->run($sql)->fetchAll();
$cp_data = array(array('Projects', 'Employees Count'));
foreach ($company_projects as $data) {
  $temp_data = array($data['project_name'], (int)$data['emp_count']);
  array_push($cp_data, $temp_data);
}


$asql = "
SELECT 
    sc.employee_id,
    MAX(sc.ip_address) as ip_address,
    MAX(sc.check_in) as check_in,
    (UNIX_TIMESTAMP() - MAX(sc.check_in)) as working_duration,
    CONCAT(e.emp_name, ' ', e.emp_surname) as emp_name,
    MAX(p.project_name) as project_name,
    MAX(t.task_name) as task_name,
    MAX(sc.check_out_time) as check_out_time
FROM 
    shift_check sc 
    LEFT JOIN employee e ON e.employee_id = sc.employee_id 
    LEFT JOIN projects p ON p.project_id = sc.project_id 
    LEFT JOIN to_do_list t ON t.task_id = sc.task_id 
WHERE 
    sc.company_id = " . $_SESSION['company_id'] . " 
    AND sc.current_dt = '" . date('Y-m-d') . "' 
    AND (sc.check_out = '' OR sc.check_out IS NULL)
GROUP BY 
    sc.employee_id

";

        // sc.company_id = " . $_SESSION['company_id'] . "
        // AND sc.current_dt = '" . date('Y-m-d') . "'



$active_employees = myQuery($asql);

$employee_current_working_details = array();
foreach ($active_employees as $emp) {
  $employee_current_working_details[$emp['employee_id']] = $emp['working_duration'];
}

$month_start_date = date('Y-m-01');
$month_end_date = date('Y-m-t');
$employee_working_details = array();
if (!empty($active_employees)) {
  $employee_daily_working_details = $db->run("SELECT e.employee_id, SUM(sc.check_out_time) as daily_duration FROM `shift_check` sc left join employee e on sc.employee_id = e.employee_id  WHERE sc.company_id = " . $_SESSION['company_id'] . " and sc.employee_id in (" . implode(',', array_column($active_employees, 'employee_id')) . ") and sc.current_dt = '" . date('Y-m-d') . "' group by sc.employee_id")->fetchAll();
  $employee_monthly_working_details = $db->run("SELECT e.employee_id, SUM(sc.check_out_time) as monthly_duration FROM `shift_check` sc left join employee e on sc.employee_id = e.employee_id  WHERE sc.company_id = " . $_SESSION['company_id'] . " and sc.employee_id in (" . implode(',', array_column($active_employees, 'employee_id')) . ") and sc.current_dt BETWEEN '" . $month_start_date . "' AND '" . $month_end_date . "' group by sc.employee_id")->fetchAll();
  $employee_total_working_details = $db->run("SELECT e.employee_id, SUM(sc.check_out_time) as total_duration FROM `shift_check` sc left join employee e on sc.employee_id = e.employee_id  WHERE sc.company_id = " . $_SESSION['company_id'] . " and sc.employee_id in (" . implode(',', array_column($active_employees, 'employee_id')) . ")  group by sc.employee_id")->fetchAll();
  foreach ($employee_daily_working_details as $val) {
    $current_duration = ($employee_current_working_details[$val['employee_id']] != '') ? $employee_current_working_details[$val['employee_id']] : 0;
    $employee_working_details[$val['employee_id']]['daily_duration'] = $val['daily_duration'] + $current_duration;
  }
  foreach ($employee_monthly_working_details as $val1) {
    $current_duration = ($employee_current_working_details[$val1['employee_id']] != '') ? $employee_current_working_details[$val1['employee_id']] : 0;
    $employee_working_details[$val1['employee_id']]['monthly_duration'] = $val1['monthly_duration'] + $current_duration;
  }
  foreach ($employee_total_working_details as $val2) {
    $current_duration = ($employee_current_working_details[$val2['employee_id']] != '') ? $employee_current_working_details[$val2['employee_id']] : 0;
    $employee_working_details[$val2['employee_id']]['total_duration'] = $val2['total_duration'] + $current_duration;
  }
}
