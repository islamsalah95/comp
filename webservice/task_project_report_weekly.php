<?php
error_reporting(E_ALL);
ini_set('display_errors','1');
ini_set('max_execution_time', 0);
// mail('hiren.macwan@confidosoft.com','Test Cron for send report email new','');
require 'database/db.php';

require 'library/PHPMailer_class.php';
$mail = new PHPMailer;
$mail->SMTPDebug = 2;
$mail->CharSet = 'UTF-8';
$mail->Debugoutput = 'html';
$mail->Host = 'mail.techsupflex.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = "support@techsupflex.com";
$mail->Password = "YW?G*@L*vmNS";
$mail->setFrom('support@techsupflex.com', 'Techsup');
$mail->addReplyTo('support@techsupflex.com', 'Techsup');
// echo "<pre>"; print_r($mail); exit();


function sec2hms_new($seconds) {
    $t = round($seconds);
    return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
}


function send_mail($to = '', $subject = '', $report_html = ''){
	global $mail;
	$mail->clearAllRecipients();
	$mail->addAddress($to);
	$mail->Subject = $subject;
	$mail->msgHTML($report_html);
	echo $report_html;
	// $mail->send();
}


$_REQUEST['type'] = 'weekly';

if(isset($_REQUEST['type']) && $_REQUEST['type'] != ''){
	$report_type = $_REQUEST['type'];
	$start_date = '';
	$end_date = '';
	if($report_type == 'daily'){
		$start_date = date('Y-m-d', strtotime("-1 days"));
		$end_date = date('Y-m-d', strtotime("-1 days"));
	}
	else if($report_type == 'weekly'){
		$start_date = date('Y-m-d', strtotime("-6 days"));
		$end_date = date('Y-m-d', strtotime("-1 days"));	
	}
	else if($report_type == 'monthly'){
		$start_date = date('Y-m-d', strtotime("-1 months"));
		$end_date = date('Y-m-d', strtotime("-1 days"));	
	}
	else{
		$start_date = date('Y-m-d', strtotime("-1 days"));
		$end_date = date('Y-m-d', strtotime("-1 days"));	
	}

	$site_settings = $db->get_data('settings');
	$site_logo = $site_settings[0]['logo'];

	$companies = $db->get_data('company','status = 0');
	// $companies = $db->get_data('company','id = 266 and status = 0');
	$companies = $db->get_data('company','(id = 4 or id = 266) and status = 0');

	foreach ($companies as $company_data) {
		$company_id = $company_data['id'];
		$company_name = $company_data['company_name'];

		// $sql = "SELECT e.emp_name, p.project_name, t.task_name, SUM(sc.check_out_time) as working_hours FROM `shift_check` sc left join `employee` e on e.employee_id = sc.employee_id left join projects p on p.project_id= sc.project_id left join to_do_list t on t.task_id = sc.task_id WHERE sc.company_id = '". $company_id."' and sc.current_dt BETWEEN '".$start_date."' AND '".$end_date."' and e.`department` = 2 GROUP by sc.employee_id,sc.project_id,sc.task_id ORDER BY e.`emp_name` ASC ";
		
		// new query to get all employees task and projects
		$sql = "
				SELECT e.employee_id, e.emp_name, p.project_name, t.task_name, SUM(sc.check_out_time) as working_hours 
				FROM  `employee` e
				left join `shift_check` sc on e.employee_id = sc.employee_id and sc.current_dt BETWEEN '".$start_date."' AND '".$end_date."'
				left join projects p on p.project_id= sc.project_id 
				left join to_do_list t on t.task_id = sc.task_id 
				WHERE e.company_id = '". $company_id."' and e.`department` = 2 and e.status = 0 
				GROUP by e.employee_id,sc.project_id,sc.task_id 
				ORDER BY e.`emp_name` ASC
			";

        $report_data = $db->get_data('','', $sql);
        // echo "<pre>"; print_r($report_data); exit();

        $iasql = "SELECT e.employee_id FROM `employee` e LEFT JOIN shift_check sc on sc.employee_id = e.employee_id WHERE e.company_id = ".$company_id." and e.department = 2 and sc.employee_id is null group by e.employee_id";
		$inactive_employees = $db->get_data('','', $iasql);
		$inactive_emp = array();
		if($inactive_employees && count($inactive_employees) > 0){
		    foreach ($inactive_employees as $inactive_employee) {
		        $inactive_emp[] = $inactive_employee['employee_id'];
		    }
		}
		// echo "<pre>"; print_r($inactive_emp); exit();

    	$html = '';
    	$html .= '<div style="width:100%;border: 1px solid #cdcdcd;padding: 2px;">';
		$html .= '<div style="width:100%;text-align:center;">';
		$html .= '<div style="width: 15%;float:left;" class="header_logo">';
		$html .= '<img style="margin: 5px;min-height: 100px;width:150px;" src="'.DOMAIN_NAME.'/uploads/logo/'.$site_logo.'" />';
		$html .= '</div>';
		$html .= '<div style="width: 85%;float:left;text-align:center;font-family: Arial, Helvetica, sans-serif;" class="header_text">';
		$html .= '<h2>'.ucwords($company_name).'</h2>';
		$html .= '<h4 style="margin:5px;">'.ucfirst($report_type).' Task & Project Work Report </h4>';
		$html .= '<h5 style="margin:5px;">('.date("F j, Y", strtotime($start_date)).' - '.date("F j, Y", strtotime($end_date)).')</h5>';
		$html .= '</div>';
		$html .= '<div style="clear: both;"></div>';
		$html .= '</div>';
    	$html .= '<div class="panel" style="width:100%;text-align:center;font-family: Arial, Helvetica, sans-serif;" >';
    	// $html .= '<div class="panel-heading text-center"><h3>'.ucwords($company_name).' - '.ucfirst($report_type).' Work Report ('.date("F j, Y", strtotime($start_date)).' - '.date("F j, Y", strtotime($end_date)).')</h3></div>';
		$html .= '<div class="panel-body">';
		$html .= '<table id="company_report" style="width:100%;border-collapse: collapse;" class="table table-striped table-bordered text-right">';
		$html .= '<thead style = "background:#17a2b8;">';
		$html .= '<tr>';
		$html .= '<th style="border: 1px solid #ddd;padding:7px;"> Employee Name</th>';
		$html .= '<th style="border: 1px solid #ddd;padding:7px;"> Project</th>';
		$html .= '<th style="border: 1px solid #ddd;padding:7px;"> Task</th>';
		$html .= '<th style="border: 1px solid #ddd;padding:7px;"> Total Working Time (HH:MM:SS)</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody style="text-align:right">';

		$e_html_head = $html;
		$counter = 1;
		if (is_array($report_data) && !empty($report_data)){
			// usort($report_data, function ($item1, $item2) {
			// 	if ($item1['working_hours'] == $item2['working_hours']) return 0;
			// 	return $item1['working_hours'] > $item2['working_hours'] ? -1 : 1;
			// });
			foreach ($report_data as $data){
				$data_background = '';
				if($counter % 2 == 0){$data_background = 'background:#f2f2f2;';}
				if(in_array($data['employee_id'], $inactive_emp)){
					$data_background .= 'color:red;';
				}
				$html .= '<tr style="'.$data_background.'">';
				$html .= '<td style="border: 1px solid #ddd;padding:7px;">'.ucwords($data["emp_name"]).'</td>';
				$html .= '<td style="border: 1px solid #ddd;padding:7px;">'.ucwords($data["project_name"]).'</td>';
				$html .= '<td style="border: 1px solid #ddd;padding:7px;">'.ucwords($data["task_name"]).'</td>';
				$html .= '<td style="border: 1px solid #ddd;padding:7px;">'.sec2hms_new($data["working_hours"]).'</td>';
				$html .= '</tr>';
				$counter++;
			} 
		}
		else{
			$html .= '<tr><td colspan = "3" style="text-align:center;border: 1px solid #ddd;padding:7px;" >No Data.</td></tr>';
		}
		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';
		$report_html = wordwrap($html);
        // echo "<pre>"; print_r($html); exit();

		// $company_id = 4;

		// $m_sql = "select employee_id, email from employee where company_id = ".$company_id." and (department = 4 or department = 1) and status = 0";

		$user_companies = array($company_id);
		$c_sql = "SELECT emp.company_id, c.company_name FROM employee_company_map emp LEFT JOIN company c on c.id = emp.company_id WHERE employee_id  IN (SELECT e.employee_id FROM employee e LEFT JOIN employee_company_map m on m.employee_id = e.employee_id WHERE m.company_id = " . $company_id . " and e.department = 1)";
		$companies = $db->get_data('', '', $c_sql);
		if (!empty($companies)) {
			foreach ($companies as $c) {
				$user_companies[] = $c['company_id'];
			}
		}
		$m_sql = "select employee_id, email from employee where company_id IN (" . implode(',', $user_companies) . ") and (department = 4 or department = 1) and status = 0";
		
		$managers = $db->get_data('','', $m_sql);
		if($managers && !empty($managers)){
			foreach ($managers as $manager) {
				if(isset($manager['email']) && $manager['email'] != ''){
					$subject = ucfirst($report_type).' Task & Project Work Report';

					$to = $manager['email'];
				    // $to = 'hiren.macwan@confidosoft.com';
				    send_mail($to, $subject, $report_html);
				}
			}
		}
		// echo "<pre>"; print_r($managers); exit();
	}
}

?>