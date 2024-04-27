<?php

// $site_setting = $db->run("SELECT site_setting.* FROM site_setting")->fetchAll();
$site_setting = myQuery("SELECT site_setting.* FROM site_setting");

if (isset($_POST['submit_settings'])) {
	$company_name = $_POST['company_name'];
	$company_email = $_POST['company_email'];
	$company_website = $_POST['company_website'];
	$company_address = htmlentities($_POST['company_address']);
	$country = $_POST['country'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zip = $_POST['zip'];
	$date_format = $_POST['date_format'];
	$telephone1 = $_POST['telephone1'];
	$timezone = $_POST['timezone'];
	$company_currencysymbol = $_POST['company_currencysymbol'];

	$daily_report = isset($_POST['daily_report']) ? $_POST['daily_report'] : 0;
	$weekly_report = isset($_POST['weekly_report']) ? $_POST['weekly_report'] : 0;
	$monthly_report = isset($_POST['monthly_report']) ? $_POST['monthly_report'] : 0;


	$create_date = date('y-m-d,h:i:s');
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$logopic = $_FILES['logopic'];

	$handle = new uploader($logopic);
	$ext = $handle->file_src_name_ext;
	$path = SERVER_ROOT . '/uploads/logo/company_logo/';

	if ($company_name == '') {
		$display_msg = '<div class="alert alert-danger">
		<i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>' . $lang["enter_your_company_name"] . '
		</div>';
	} elseif ($company_email == '') {
		$display_msg = '<div class="alert alert-danger">
		<i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>' . $lang["enter_your_company_email"] . '
		</div>';
	} elseif (!$fv->check_email($company_email)) {
		$display_msg = '<div class="alert alert-danger">
		<i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>' . $lang["enter_valid_email"] . '
		</div>';
	} elseif ($logopic['name'] != '') {

		if (!is_dir($path)) {
			if (!file_exists($path)) {
				mkdir($path);
			}
		}

		if (file_exists(SERVER_ROOT . '/uploads/logo/company_logo/' . $company_details['logo']) && (($company_details['logo']) != '')) {
			unlink(SERVER_ROOT . '/uploads/logo/company_logo/' . $company_details['logo']);
		}
		$newfilename = $handle->file_new_name_body = time();
		$ext = $handle->image_src_type;
		$filename = $newfilename . '.' . $ext;


		if ($handle->image_src_type == 'jpg' || $handle->image_src_type == 'jpeg' || $handle->image_src_type == 'png') {
			if ($handle->uploaded) {
				$handle->Process($path);
				if ($handle->processed) {
					$update = $db->update('company', array('company_name' => $company_name, 'company_email' => $company_email, 'timezone' => $timezone, 'logo' => $filename, 'company_website' => $company_website, 'company_address' => $company_address, 'country' => $country, 'city' => $city, 'state' => $state, 'zip' => $zip, 'date_format' => $date_format, 'telephone1' => $telephone1, 'company_currencysymbol' => $company_currencysymbol, 'daily_report' => $daily_report, 'weekly_report' => $weekly_report, 'monthly_report' => $monthly_report), array('id' => $_SESSION['company_id']));
				}
			}
		}
	} else {
		$update = $db->update('company', array('company_name' => $company_name, 'company_email' => $company_email, 'timezone' => $timezone, 'company_website' => $company_website, 'company_address' => $company_address, 'country' => $country, 'city' => $city, 'state' => $state, 'zip' => $zip, 'date_format' => $date_format, 'telephone1' => $telephone1, 'company_currencysymbol' => $company_currencysymbol, 'daily_report' => $daily_report, 'weekly_report' => $weekly_report, 'monthly_report' => $monthly_report), array('id' => $_SESSION['company_id']));
	}

	if ($update) {
		$company_details = $db->get_row('company', array('id' => $_SESSION['company_id']));

		/*$display_msg='<div class="alert alert-success">
		<i class="lnr lnr-smile"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>Success! In demo you cannot change data.
		</div>';*/
		$display_msg = '<div class="alert alert-success">
		<i class="lnr lnr-smile"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>' . $lang["update_success"] . '
		</div>';
	}
} elseif (isset($_REQUEST['is_block_yes'])) {
	$id = $_REQUEST['is_block_yes'];
	$update = $db->update('site_setting', array('is_blocked' => "no"), array('site_setting_id' => $id));
	if ($update) {
		$session->redirect('site_setting', frontend);
	}
} elseif (isset($_REQUEST['is_block_no'])) {
	$id = $_REQUEST['is_block_no'];
	$update = $db->update('site_setting', array('is_blocked' => "yes"), array('site_setting_id' => $id));
	if ($update) {
		$session->redirect('site_setting', frontend);
	}
}




/******send report mail*******/
require SERVER_ROOT . '/webservice/mail/sendEmail.php';
function sec2hms($secs)
{
  $secs = round($secs);
  $secs = abs($secs);
  $hours = floor($secs / 3600) . ':';
  if ($hours == '0:') $hours = '';
  $minutes = substr('00' . floor(($secs / 60) % 60), -2) . ':';
  $seconds = substr('00' . $secs % 60, -2);
  return ltrim($hours . $minutes . $seconds, '0');
}
function sec2hms_new($seconds)
{

    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $seconds = $seconds % 60;

    return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
}
function convertTimeZone($oTime,$var=null)
{

	/*
	 * otime must be in 2017-03-25 H:i:s format
	 */
	$nTimeZone=new_timezone;
	$oTimeZone=default_timezone;

	date_default_timezone_set($oTimeZone);

	// $originalTime = new DateTime($oTime);
	$originalTime = $oTime !== null ? new DateTime($oTime) : new DateTime();


	$originalTime->setTimeZone(new DateTimeZone($nTimeZone));
	date_default_timezone_set($oTimeZone);

	if(SITE_DATE_FORMAT==1 && $var==null)
	{
	return $originalTime->format('d-m-Y');
	}elseif(SITE_DATE_FORMAT==2 && $var==null)
	{
		return $originalTime->format('m-d-Y');
	}
	elseif(SITE_DATE_FORMAT==3 && $var==null)
	{
		return $originalTime->format('d-M-Y');
	}
	elseif($var=='appdate')
	{
		return $originalTime->format('Y-m-d');
	}
	elseif($var=='time')
	{
		return $originalTime->format('H:i:s');
	}

elseif($var=='false'){
	return $originalTime->format('F-d-Y H:i:s');
}

}
if (isset($_REQUEST['daily_report'])) {
    $start_date = date('Y-m-d');
    $end_date = date('Y-m-d');
	sendReport($start_date ,$end_date ,'Daily Report' );
} 
if (isset($_REQUEST['weekly_report']) ) {
    $end_date = date('Y-m-d', strtotime("-1 days"));
    $start_date = strtotime($end_date . " -6 days");
    $start_date = date('Y-m-d', $start_date);
	sendReport($start_date ,$end_date , 'Weekly Report');
	
} if (isset($_REQUEST['monthly_report']) ) {
    $end_date = date('Y-m-d', strtotime("-1 days"));
    $start_date = strtotime($end_date . " -30 days");
    $start_date = date('Y-m-d', $start_date);
	sendReport($start_date ,$end_date , 'Monthly Report');
}
function sendReport($start_date ,$end_date ,$subject ){
$sql = "
    SELECT e.employee_id, e.emp_name, p.project_name, t.task_name,
           MIN(sc.check_in) as check_in,
           MAX(sc.check_out) as check_out,
           SUM(sc.check_out_time) as working_hours, 
           SUM(sc.approved_time) as approved_time, 
           MAX(sc.current_dt) as current_dt,  -- Assuming you want the maximum current_dt
           ecm.hourly_rate 
    FROM shift_check sc 
    LEFT JOIN employee e ON e.employee_id = sc.employee_id 
    LEFT JOIN projects p ON p.project_id = sc.project_id 
    LEFT JOIN to_do_list t ON t.task_id = sc.task_id 
    LEFT JOIN employee_company_map ecm ON ecm.employee_id = sc.employee_id 
    WHERE sc.company_id = '" . $_SESSION['company_id'] . "' 
    AND sc.current_dt BETWEEN '" . $start_date . "' AND '" . $end_date . "' 
    GROUP BY e.employee_id, p.project_name, t.task_name, ecm.hourly_rate
    ORDER BY e.emp_name ASC;
";

$results = myQuery($sql);
$htmlTable = '<table border="1">
<tr>
	<th>Employee Name</th>
	<th>Project Name</th>
	<th>Task Name</th>
	<th>Date</th>
	<th>Start Time</th>
	<th>End Time</th>
	<th>Total Working Time (HH:MM:SS)</th>
	<th>Approved Hours</th>
	<th>Rejected Hours</th>
	<th>Compute Wages</th>
</tr>';

foreach ($results as $task) {
$htmlTable .= '
<tr>
	<td>' . $task['emp_name'] . '</td>
	<td>' . $task['project_name'] . '</td>
	<td>' . $task['task_name'] . '</td>
	<td>' . $task['current_dt'] . '</td>
	<td>' . convertTimeZone(date("Y-m-d H:i:s", $task['check_in']), 'time') . '</td>
	<td>' . ($task['check_out'] != '' ? convertTimeZone(date("Y-m-d H:i:s", $task['check_out']), 'time') : '') . '</td>
	<td class="text-right entry_wh_' . ($task['id'] ?? '') . '">' . sec2hms_new($task['working_hours']) . '</td>
	<td class="text-right">' . sec2hms_new($task['approved_time']) . '</td>
	<td class="text-right">' . sec2hms_new($task['working_hours'] - $task['approved_time']) . '</td>
	<td class="text-right">' . number_format((float)($task['approved_time'] * ($task['hourly_rate'] / 3600)), 2) . 'SR</td>
</tr>';
}

$htmlTable .= '</table>';

 sendEmail($htmlTable , $_SESSION['email'] , $subject ,  $subject .' '. 'has been sent successfully!');
}
