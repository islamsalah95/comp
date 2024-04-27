<?php
//$table = 'employee';
$table = 'employee left join employee_company_map on employee.employee_id = employee_company_map.employee_id';

$primaryKey = 'employee`.`employee_id';
$columns = array(
	array('db' => 'employee`.`employee_id', 'dt' => 0),
	array('db' => 'emp_name', 'dt' => 1),
	array('db' => 'email', 'dt' => 2),
);

$c_columns = array(
	array('db' => 'employee_id', 'dt' => 0),
	array('db' => 'emp_name', 'dt' => 1),
	array('db' => 'email', 'dt' => 2),
);

$sql_details = array(
	'user' => DB_USER,
	'pass' => DB_PASSWORD,
	'db'   => DB_NAME,
	'host' => DB_HOST
);

// $where = array("department = '3'");
// if($_SESSION['department'] == 5){
// 	$where = array("department = '3'");
// }
// else{
// 	$user_companies = array($_SESSION['company_id']);
// 	if(isset($_SESSION['user_companies'])){
// 		$user_companies = $_SESSION['user_companies'];
// 	}
// 	// $companies = $db->run("SELECT emp.company_id, c.company_name FROM employee_company_map emp LEFT JOIN company c on c.id = emp.company_id WHERE employee_id  IN (SELECT e.employee_id FROM employee e LEFT JOIN employee_company_map m on m.employee_id = e.employee_id WHERE m.company_id = " . $_SESSION['company_id'] . " and e.department = 3)")->fetchAll();
// 	// if (!empty($companies)) {
// 	// 	foreach ($companies as $c) {
// 	// 		$user_companies[] = $c['company_id'];
// 	// 	}
// 	// }
// 	$where = array("department = '3' and employee_company_map.company_id in (" . implode(',', $user_companies) . ") ");
// }
//$where = array("department = '3' and company_id = '" . $_SESSION['company_id'] . "' and status = '0'");
$where = array("department = '3' and employee_company_map.company_id = '" . $_SESSION['company_id'] . "'");

$group_by = "group by employee.employee_id";
$output_arr = SSP::custom_complex($_GET, $sql_details, $table, $primaryKey, $columns, $where, '', $group_by, $c_columns);
foreach ($output_arr['data'] as $key => $value) {
	$edit_link = $link->link("edit_freelancer", frontend, '&edit=' . $value[0]);
	$delete_link = $link->link("freelancers", '', '&del_id=' . $value[0]);
	$activate = $db->get_col('employee', array('employee_id' => $value[0]), 'status');
	if (end($activate) == 1) {
		$activate_lable = $lang["activate"];
		$activate_link = $link->link("freelancers", '', '&activate_id=' . $value[0]);
	} else {
		$activate_lable = $lang["deactivate"];
		$activate_link = $link->link("freelancers", '', '&deactivate_id=' . $value[0]);
	}
	$contract_link = $link->link("contracts", frontend, '&employee_id=' . $value[0]);
	$contract_btn = '<a href="' . $contract_link . '" style="margin:0 10px;" "><span class="label label-info">' . $lang["contracts"] . '</span></a>';
	$output_arr['data'][$key][count($output_arr['data'][$key])] = $contract_btn . '<a href="' . $edit_link . '" style="margin:0 10px;" "><span class="label label-success">' . $lang["update"] . '</span></a><a href="' . $delete_link . '" style="margin:0 10px;" "><span class="label label-danger">' . $lang["delete"] . '</span></a><a href="' . $activate_link . '" style="margin:0 10px;" "><span class="label label-warning">' . $activate_lable . '</span></a>';
	//echo "<pre>"; print_r($output_arr['data'][$key]); exit();
}
//echo "<pre>"; print_r($output_arr['data']); exit();
echo json_encode($output_arr);
exit();
