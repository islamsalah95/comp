<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
if ($_REQUEST['token'] && $security->decrypt($_REQUEST['token'], key)) {

	$postdata = file_get_contents("php://input");
	if (empty($postdata) || $postdata = '') {
		$postdata = json_encode($_REQUEST);
	}
	header('Content-Type: application/json');
	$request = array();
	$sessions = array();
	$request = json_decode($postdata, true);
    $employee_id = isset($request['employee_id']) ? $request['employee_id'] : '';
    $company_id = isset($request['company_id']) ? $request['company_id'] : '';
    $project_id = isset($request['project_id']) ? $request['project_id'] : '';





	if ($employee_id == "") {
		$sessions['message'] = "paramter missing  employee_id";
				http_response_code(404);
		$sessions['status'] = 404;
	}
	else if($company_id == ""){
		$sessions['message'] = "paramter missing  company_id";
				http_response_code(404);
		$sessions['status'] = 404;
	}
	else if($project_id == ""){
		$sessions['message'] = "paramter missing  project_id";
				http_response_code(404);
		$sessions['status'] = 404;
	}
	else {
        $user_tasks = $db->run("
            SELECT t.task_id, t.task_name, t.project_id 
            FROM to_do_list t 
            WHERE t.project_id IN (
                SELECT pa.project_id 
                FROM project_assign pa 
                LEFT JOIN projects p ON p.project_id = pa.project_id 
                WHERE pa.employee_id = $employee_id 
                AND pa.company_id = $company_id 
                AND p.end_date >= '" . date('Y-m-d') . "'  
            ) 
            AND t.project_id = $project_id
        ")->fetchAll();

		
// 		if (empty($user_tasks)) {
// 			$user_tasks = $db->run("SELECT task_id, task_name, project_id FROM to_do_list WHERE task_id = 1")->fetchAll();
// 		}
			$sessions['data'] =	$user_tasks;
		http_response_code(200);
		$sessions['status'] = 200;
	    }
	echo json_encode($sessions);
} else {
	$session->redirect('404', frontend);
}
