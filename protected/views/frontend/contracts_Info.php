<?php

/*error_reporting(E_ALL);
ini_set('display_errors', 1);*/
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
if ($_REQUEST['token'] && $security->decrypt($_REQUEST['token'], key)) {
    function convert_Hours($seconds)
    {
        return $seconds / 3600;
    }
    function secondsToTime($seconds)
    {
        $days = floor($seconds / (3600 * 24));
        $hours = floor(($seconds % (3600 * 24)) / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        // Format the time
        $time = sprintf("%02d:%02d:%02d:%02d", $days, $hours, $minutes, $seconds);

        return $time;
    }
    function get_report_hours($employee_id, $start_date, $end_date,$db, $department = null)
    {
        $report_details = $db->myQuery("SELECT e.employee_id, e.emp_name, sum(sc.check_out_time) as working_hours 
            FROM `shift_check` sc 
            LEFT JOIN `employee` e ON e.employee_id = sc.employee_id 
            LEFT JOIN projects p ON p.project_id = sc.project_id 
            LEFT JOIN to_do_list t ON t.task_id = sc.task_id 
            WHERE e.employee_id = $employee_id AND sc.current_dt BETWEEN '" . $start_date . "' AND '" . $end_date . "' ORDER BY e.emp_name ASC");
        return $report_details;
    }

    $postdata = file_get_contents("php://input");
    if (empty($postdata) || $postdata = '') {
        $postdata = json_encode($_REQUEST);
    }
    header('Content-Type: application/json');
    $request = array();
    $sessions = array();
    $request = json_decode($postdata, true);
    $employee_id = $request['employee_id'];
    if ($employee_id == "") {
        $sessions['loginerror'] = "employee_id Is reuired";
        $sessions['color'] = "danger";
        $sessions['status'] = 400;
        http_response_code(400);
    } else {

        $sql = "SELECT 
    ecm.employee_id,
    ecm.working_hours as total_hours,
    ecm.start_date,
    ecm.end_date,
    ecm.working_hours_per_day,
    ecm.hourly_rate,
    ecm.working_hours_per_week,
    CONCAT(e.emp_name, ' ', e.emp_surname) as employee_name
    FROM 
        employee_company_map ecm 
    LEFT JOIN 
        employee e ON e.employee_id = ecm.employee_id 
    LEFT JOIN 
        `status` s ON s.id = ecm.status_id 
    LEFT JOIN 
        `cancel_contract` cc ON cc.number = ecm.id
    LEFT JOIN 
        company c ON c.id = ecm.company_id
    WHERE 
        ecm.gosi_job_title_id IS NOT NULL 
        AND ecm.employee_id = $employee_id
        AND ecm.end_date = (
            SELECT MAX(end_date) 
            FROM employee_company_map 
            WHERE employee_id = $employee_id
        );
    ";



        $contracts = $db->run($sql)->fetchAll();



        $sessions['contact_info'] = $contracts;


        $report = get_report_hours($contracts[0]['employee_id'], $contracts[0]['start_date'], $contracts[0]['end_date'],$db);

        $sessions['get_report_hours'] = [
            'compleated_hours' => secondsToTime($report[0]['working_hours']),
            'Format' => 'days:hours:minutes:seconds',
            'Total_seconds_ccompleated' => $report[0]['working_hours']
        ];

        $sessions['status'] = 200;
        http_response_code(200);
    }

    echo json_encode($sessions);
} else {
    $session->redirect('404', frontend);
}
