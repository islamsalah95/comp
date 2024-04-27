<?php

error_reporting(E_ERROR | E_PARSE);
ini_set('max_execution_time', 0);

require 'database/db.php';
require 'class_sms.php';

$sms = new SMS();
echo $sms->check_balance(); exit();

$companies = $db->get_data('company','status = 0');
$companies = $db->get_data('company','(id = 4 or id = 5) and status = 0');

foreach ($companies as $company_data) {
	$company_id = $company_data['id'];
	$company_name = $company_data['company_name'];

	// get total employees for company
	$tsql = "SELECT e.employee_id FROM `employee` e  WHERE e.company_id = ".$company_id." and e.department = 2 and status = 0";
	$t_employees = $db->get_data('','', $tsql);
	$total_employees = count($t_employees);
	// end 

	// get inactive user
	$iasql = "SELECT e.employee_id FROM `employee` e LEFT JOIN shift_check sc on sc.employee_id = e.employee_id WHERE e.company_id = ".$company_id." and e.department = 2 and sc.employee_id is null group by e.employee_id";
	$i_employees = $db->get_data('','', $iasql);
	$inactive_employees = count($i_employees);
	// end

	// get number of users registered in month
	$start_date = date('Y-m-d', strtotime("-1 months"));
	$end_date = date('Y-m-d', strtotime("-1 days"));

	$mrsql = "SELECT e.employee_id FROM `employee` e  WHERE e.company_id = ".$company_id." and e.department = 2 and date(create_date) between '".$start_date."' and '".$end_date."' ";
	$m_r_employees = $db->get_data('','', $mrsql);
	$month_registered_employees = count($m_r_employees);
	// end

	// get managers 
	$m_sql = "select employee_id, email, contact1 from employee where company_id = ".$company_id." and (department = 4 or department = 1) and status = 0";
	$managers = $db->get_data('','', $m_sql);
	if($managers && !empty($managers)){
		foreach ($managers as $manager) {
			if(isset($manager['contact1']) && $manager['contact1'] != ''){
				$msg = '';
				$msg .= '<b>Company :</b> '.$company_name;
				$msg .= '<br/>';
				$msg .= '<b>Employees Registered in last 30 days : </b> '.$month_registered_employees;
				$msg .= '<br/>';
				$msg .= '<b>Total Employees : </b> '.$total_employees;
				$msg .= '<br/>';
				$msg .= '<b>Inactive Employees : </b> '.$inactive_employees;
				$data = array(
								'mobile_number' => $manager['contact1'],
								'text' => $msg
							);
				echo $msg; echo "<br/>";echo "<br/>";
				// $sms->send_sms($data);
			}
		}
	}
	// end
}
exit();
?>