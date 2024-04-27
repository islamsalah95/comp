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
	else {
		$user_projects = $db->run("SELECT pa.project_id, p.project_name FROM project_assign pa LEFT JOIN projects p on p.project_id = pa.project_id WHERE pa.employee_id = $employee_id and pa.company_id = $company_id and p.end_date >= '" . date('Y-m-d') . "' ")->fetchAll();
// 		if (empty($user_projects)) {
// 			$user_projects = $db->run("SELECT project_id, project_name FROM projects WHERE project_id = 1")->fetchAll();
// 		}
	    $sessions['data'] = $user_projects ;
		http_response_code(200);
		$sessions['status'] = 200;
	    }
      
      	echo json_encode($sessions);
} else {
	$session->redirect('404', frontend);
}
