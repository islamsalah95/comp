<?php
error_reporting(E_ERROR | E_PARSE);
ini_set('max_execution_time', 0);

require 'database/db.php';

date_default_timezone_set('Asia/Riyadh');
$start_date = '2018-09-01';
$end_date = '2018-11-30';
$date_range = array();

while (strtotime($start_date) <= strtotime($end_date)){
	$day_name = date('l', strtotime($start_date));
	if($day_name != 'Friday' && $day_name != 'Saturday'){
		array_push($date_range, $start_date);
	}
	$start_date = date('Y-m-d',strtotime("+1 days",strtotime($start_date)));
}

$employees = 	"
					'aishah.almdini@alojaimi.com',
					'arwa.albushil@alojaimi.com',
					'farah.alrbiah@alojaimi.com',
					'fouziah.alghamdi@alojaimi.com',
					'hanan.alarfaj@alojaimi.com',
					'hassh.alathem@alojaimi.com',
					'ibthal.yousef@alojaimi.com',
					'maha.alshammri@alojaimi.com',
					'maha.alkhtib@alojaimi.com',
					'modhy.alshammri@alojaimi.com',
					'munerah.alawidi@alojaimi.com',
					'mushal.alyuosef@alojaimi.com',
					'ream.alotibi@alojaimi.com',
					'sara.altliqi@alojaimi.com',
					'wafa.alzamil@alojaimi.com'
				";

$employee1 = array(
					'aishah.almdini@alojaimi.com',
					'arwa.albushil@alojaimi.com',
					'farah.alrbiah@alojaimi.com',
					'fouziah.alghamdi@alojaimi.com',
				);
$employee2 = array(
					'hanan.alarfaj@alojaimi.com',
					'hassh.alathem@alojaimi.com',
					'ibthal.yousef@alojaimi.com',
					'maha.alshammri@alojaimi.com',
					'maha.alkhtib@alojaimi.com',
					'modhy.alshammri@alojaimi.com',
					'munerah.alawidi@alojaimi.com',
					'mushal.alyuosef@alojaimi.com',
				);
$employee3 = array(
					'ream.alotibi@alojaimi.com',
					'sara.altliqi@alojaimi.com',
					'wafa.alzamil@alojaimi.com'
				);

$sql = "SELECT employee_id, email FROM `employee` WHERE email in (".$employees.")";
$emp_details = $db->get_data('', '', $sql);

$shift_data = array();
foreach ($date_range as $date) {
	foreach ($emp_details as $employee) {
		$company_id = 80;
		$employee_id = $employee['employee_id'];
		$current_dt = $date;
		
		$checkin = array();
		$checkout = array();
		if(in_array($employee['email'], $employee1)){
			$checkin[] = strtotime($date.' 11:00:00 AM');
			$checkout[] = strtotime($date.' 03:00:00 PM');

			$checkin[] = strtotime($date.' 04:00:00 PM');
			$checkout[] = strtotime($date.' 08:00:00 PM');
		}

		if(in_array($employee['email'], $employee2)){
			$checkin[] = strtotime($date.' 08:00:00 AM');
			$checkout[] = strtotime($date.' 12:00:00 PM');

			$checkin[] = strtotime($date.' 01:00:00 PM');
			$checkout[] = strtotime($date.' 05:00:00 PM');
		}

		if(in_array($employee['email'], $employee3)){
			$checkin[] = strtotime($date.' 09:00:00 AM');
			$checkout[] = strtotime($date.' 02:00:00 PM');

			$checkin[] = strtotime($date.' 03:00:00 PM');
			$checkout[] = strtotime($date.' 06:00:00 PM');
		}

		for ($i=0; $i < 2 ; $i++) { 
			$check_out_time = $checkout[$i] - $checkin[$i];
			$shift_data[] = array(
									'company_id' => $company_id,
									'employee_id' => $employee_id,
									'current_dt' => $current_dt,
									'check_in' => $checkin[$i],
									'check_out' => $checkout[$i],
									'check_out_time' => $check_out_time,
									'manual_edit' => 1,
									'create_date' => date('Y/m/d'),
									'ip_address' => $_SERVER['REMOTE_ADDR'],
								);
		}
	}
}

foreach ($shift_data as $shift) {
	echo "<pre>"; print_r($shift); echo "</pre>";
	$insert_data = $db->insert_data('shift_check',$shift);
}

exit();
// echo "<pre>"; print_r($shift_data); exit();
?>