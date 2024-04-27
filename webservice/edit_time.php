<?php

error_reporting(E_ERROR | E_PARSE);
ini_set('max_execution_time', 0);

require 'database/db.php';

// $companies = $db->get_data('company','status = 0');
$companies = $db->get_data('company','id = 4 and status = 0');
// echo "<pre>"; print_r($companies); exit();
foreach ($companies as $company) {
	$company_id = $company['id'];
	date_default_timezone_set($company['timezone']);
	$yesterday = date('Y-m-d',strtotime("-1 days"));
	$update_time = (int)(time()-(8*3600));
	$sql = "SELECT * FROM `shift_check` WHERE company_id = '".$company_id."' and current_dt = '".$yesterday."' AND check_in <= '".$update_time."' AND (check_out = '' OR check_out is null) ORDER BY shift_check.`id` DESC";
	$shift_data = $db->get_data('','', $sql);
	foreach ($shift_data as $sdata) {
		$shift_id = $sdata['id'];
		$eid = $sdata['employee_id'];
		$empty_check_in = $sdata['check_in'];
		$new_check_out = $empty_check_in;
		$check_out_time = 0;

		// $s_sql = "SELECT * FROM `shift_check` WHERE current_dt = '".$yesterday."' AND employee_id = ".$eid;
		$s_sql = "SELECT shift_check.employee_id, shift_check.current_dt, MIN(shift_check.check_in) as check_in, MAX(shift_check.check_out) as check_out, SUM(shift_check.check_out_time) as working_hours from shift_check  WHERE shift_check.company_id = '". $company_id."' and shift_check.current_dt = '".$yesterday."' and  shift_check.employee_id = '".$eid."' GROUP BY shift_check.employee_id, shift_check.current_dt ORDER BY shift_check.`id` DESC";
		$employee_data = $db->get_data('','', $s_sql);
		$total_check_out_time = $employee_data[0]['working_hours'];
		$total_work_hours = 8*3600;

		$day_end_time = strtotime(date('Y-m-d')) - 1;
		if((int)($day_end_time - $empty_check_in) < (8*3600)){
			$total_work_hours = (int)($day_end_time - $empty_check_in);
		}
		$remaining_hours = (int)($total_work_hours - $total_check_out_time);
		if($remaining_hours > 0){
			$new_check_out = (int)$empty_check_in+$remaining_hours;
			$check_out_time = $remaining_hours;
		}

		$data = array(
			'check_out' => $new_check_out,
			'check_out_time' => $check_out_time,
			'cron_edit' => 1,
		);
		$where = array('id' => $shift_id);
		$update_data = $db->update_data('shift_check', $data, 'id = '.$shift_id);
		// echo "<pre>"; print_r($new_check_out); exit();
	}
	// echo "<pre>"; print_r($shift_data); exit();
}

?>