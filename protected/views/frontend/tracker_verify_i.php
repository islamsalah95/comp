<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
// if ($_REQUEST['token'] && $security->decrypt($_REQUEST['token'], key)) {

	$postdata = file_get_contents("php://input");
	if (empty($postdata) || $postdata = '') {
		$postdata = json_encode($_REQUEST);
	}
	header('Content-Type: application/json');
	$request = array();
	$sessions = array();
	$request = json_decode($postdata, true);
	$code = $request['code'];
	// $country = $request['country'];
	if ($code == "") {
		$sessions['loginerror'] = "Code Is Empty";
		$sessions['color'] = "danger";
	}
	else {

		if ($db->exists('employee', array('emp_code' => $code))) {
			$query = $db->get_row('employee', array('emp_code' => $code));
			if ($db->exists('company', array('id' => $query['company_id'])) && $query['status'] == 0) {
				$companyrow = $db->get_row('company', array('id' => $query['company_id']));
				$company = $companyrow['company_name'];
				$company_logo = $companyrow['logo'];

				/////////// company image
				if (file_exists(SERVER_ROOT . '/uploads/logo/company_logo/' . $company_logo)) {
					$query['company_logo'] = SITE_URL . '/uploads/logo/company_logo/' . $company_logo;
				}

				/////////// employee image
				if (file_exists(SERVER_ROOT . '/uploads/profile/' . $query['emp_photo_file'])) {
					$query['employee_img'] = SITE_URL . '/uploads/profile/' . $query['emp_photo_file'];
				}


					$sessions['status'] = true;
					$sessions['version'] = trversion;
					$sessions['timezone'] = $companyrow['timezone'];
					$sessions['address'] = $query['address'];
					$sessions['contact1'] = $query['contact1'];


					$sessions['firstname'] = $query['emp_name'];
					$sessions['lastname'] = $query['emp_surname'];
					$sessions['employee_id'] = $query['employee_id'];
					$sessions['company_id'] = $query['company_id'];
					$sessions['company_logo'] = $query['company_logo'];
					$sessions['employee_img'] = $query['employee_img'];
					$sessions['country'] = $query['country'];
					$sessions['hour'] = $query['hour'];
					$sessions['company_name'] = $company;
					$sessions['createddate'] = $query['create_date'];
					$sessions['token'] =  $security->encrypt(time());

					//changes for freelancer
					$sessions['user_type'] = $query['department'];
					$sessions['user_types'] = array(2 => 'employee', 3 => 'freelancer');
					$sessions['is_company'] = $query['is_company'];
					if ($query['department'] == 3) {
						$sessions['freelancer_assigned_companies'] = $db->get('employee_company_map', array('employee_id' => $query['employee_id']));
						$user_companies = $db->run("SELECT c.id, c.company_name FROM company c LEFT JOIN employee_company_map m on m.company_id = c.id WHERE m.employee_id ='" . $query['employee_id'] . "' ")->fetchAll();
						$sessions['user_companies'] = $user_companies;
					}	
				 $db->update("employee", array('emp_code' => null), array('email' =>   $query['email']));
			
			} else {
				$sessions['status'] = false;
			}
		} else {
			$sessions['status'] = false;
			$sessions['loginerror'] = "Wrong Code";
			$sessions['color'] = "danger";
		}
	}
	echo json_encode($sessions);
// } else {
// 	$session->redirect('404', frontend);
// }
