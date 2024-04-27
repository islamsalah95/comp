<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

	$postdata = file_get_contents("php://input");
	if (empty($postdata) || $postdata = '') {
		$postdata = json_encode($_REQUEST);
	}
	header('Content-Type: application/json');
	$request = array();
	$sessions = array();
	$request = json_decode($postdata, true);
	$email = $request['email'];
	$pass = $request['password'];
	// $country = $request['country'];
	if ($email == "") {
		$sessions['loginerror'] = "Email Is Empty";
		$sessions['color'] = "danger";
	} elseif ($pass == "") {
		$sessions['loginerror'] = "Password Is Empty";
		$sessions['color'] = "danger";
	} else {

		if ($db->exists('employee', array('email' => $email))) {
			$query = $db->get_row('employee', array('email' => $email));
			if ($db->exists('company', array('id' => $query['company_id'])) && $query['status'] == 0) {

				$verify_pass = $password->verify($pass, $query['password'], PASSWORD_DEFAULT);
				if (!$verify_pass) {
					$sessions['loginerror'] = "Wrong Password";
					$sessions['color'] = "danger";
				} elseif (isset($companyrow['status']) && $companyrow['status'] == 1) {
					$sessions['loginerror'] = "Account not activated";
					$sessions['color'] = "danger";
				} else {
					//*****send verfication code
					// Generate a random code
					$code = rand(10000, 99999);
					// Update the "employee" table with the generated code
			
					$update = $db->update("employee", array('emp_code' => $code), array('email' =>  $email));


				// 	if (file_exists(SERVER_ROOT . '/webservice/mail/sendEmail.php') ) {
				// 	require SERVER_ROOT . '/webservice/mail/sendEmail.php';
				// 	// Call the sendEmail function with the generated code
				// 	sendEmail("code: $code" , $email  ,"verification Code","verification Code" .' '. 'has been sent' );

				// 	}

				//     //send sms with code 
					if ($query['contact1'] != '' && file_exists(SERVER_ROOT . '/webservice/class_sms.php')) {
						require SERVER_ROOT . '/webservice/class_sms.php';
					$msg = "Hello From Flex verification code:{$code}";
		
						send_sms($query['contact1'],$msg);
					}
					
					$sessions['status'] = true;
					$sessions['version'] = trversion;
					$sessions['token'] =  $security->encrypt(time());
					$sessions['message'] = "verification Code has been sent" . ' '.	$code;

	
				}
			} else {
				$sessions['status'] = false;
			}
		} else {
			$sessions['status'] = false;
			$sessions['loginerror'] = "Wrong Email";
			$sessions['color'] = "danger";
		}
	}
	echo json_encode($sessions);
