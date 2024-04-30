<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
// echo "hello"; exit();
if ($_POST['token'] ) {

	$postdata = file_get_contents("php://input");

	header('Content-Type: application/json');

	$requests = array();
	$postdata = json_encode($_GET);
	$sessions = array();
	// $requests = json_decode($postdata, true);

   $requests['check_in']= $_POST['check_in'] ;
   $requests['check_out']=$_POST['check_out'] ?? '';;
   $requests['employee_id'] = $_POST['employee_id'];
   $requests['company_id']  = $_POST['company_id'];
  $requests['project_id']  = $_POST['project_id'];
  $requests['task_id']  = $_POST['task_id'];
//   $requests['last_id']  =  $_POST['last_id'] ;
//   $requests['check_out_time'] = $_POST['check_out_time'] ?? '';
//   $requests['last_id'] = $_POST['last_id'] ?? '';


	$check_in = $requests['check_in'] ;
	$check_out = $requests['check_out'] ;
	$employee_id = $requests['employee_id'];
	$company_id = $requests['company_id'];
	$project_id = $requests['project_id'];
	$task_id = $requests['task_id'];
	$last_id = $requests['last_id'] ?? '';






$company_details = $db->get_row('company', array('id' => $company_id));

define('default_timezone', date_default_timezone_get());
define('new_timezone', $company_details['timezone']);
date_default_timezone_set(new_timezone); // Use the variable directly, not as a string

$current_time = time();

// ... (rest of your code)



	$check_in = strtotime($check_in); // Assuming $requests['check_in'] holds the date string

      $requests['current_dt'] = date("Y-m-d", time());
//    $requests['current_dt'] = date("Y-m-d", $check_in);


	$check_out_time = $requests['check_out_time'] ?? '';
	$requests["create_date"] = date('Y/m/d');
	$requests["ip_address"] = $_SERVER['REMOTE_ADDR'];


	if ($db->exists('company', array('id' => $company_id)))
		if ($db->exists('employee', array('employee_id' => $employee_id))) {
			
			$last_shift_task = myQuery( "
			SELECT *
			FROM shift_check
			WHERE employee_id = '$employee_id'
				AND company_id = '$company_id'
				AND project_id = '$project_id'
				AND task_id = '$task_id'
			LIMIT 1
		" );
			
		
		if ($check_out == "") {
				// if ($check_in >= ($current_time - (60 * 5)) && $check_in <= ($current_time + (60 * 5))) {
					unset($requests['user']);
					unset($requests['token']);

					//note
					$requests['check_in']= intval($requests['check_in']) ;


					            //get last shift task within day and add new time
								if ( $last_shift_task ) {
									$sessions[ 'last_id' ] = $last_shift_task[ 0 ][ 'id' ];
									$sessions[ 'status' ] = true;
								} else {
									$insert = $db->insert( 'shift_check', $requests );
									if ( $insert ) {
										$sessions[ 'last_id' ] = $db->lastInsertId();
										$sessions[ 'status' ] = true;
									} else {
										$sessions[ 'last_id' ] = false;
										$sessions[ 'status' ] = false;
									}
					
								}

					// $insert = $db->insert('shift_check', $requests);
					// if ($insert) {
					// 	$sessions['last_id'] = $db->lastInsertId();
					// 	$sessions['status'] = true;
					// } else {
					// 	$sessions['last_id'] = false;
					// 	$sessions['status'] = false;
					// }
				// } else {
				// 	$sessions['last_id'] = false;
				// 	$sessions['status'] = false;
				// }
			} elseif ($check_out !== "") {
				$check_out_time = $_POST['check_out_time'] ?? '';
                $last_id= $_POST['last_id'] ?? '';

				


				if ( $last_shift_task ) {
					$totalCheck_out_time = $check_out_time + $last_shift_task[ 0 ][ 'check_out_time' ] ;
					$update = $db->update( 'shift_check', array( 'check_out_time' => intval( $totalCheck_out_time ), 'check_out' => intval( $check_out ) ), array( 'id' => $last_shift_task[ 0 ][ 'id' ] ) );
					if ( $update ) {
						$sessions[ 'last_id' ] = $last_shift_task[ 0 ][ 'id' ];
						$sessions[ 'status' ] = true;
					} else {
						$sessions[ 'last_id' ] = false;
						$sessions[ 'status' ] = false;
					}
				} else {
					$update = $db->update( 'shift_check', array( 'check_out_time' => intval( $check_out_time ), 'check_out' => intval( $check_out ) ), array( 'id' => $last_id ) );
					if ( $update ) {
						$sessions[ 'last_id' ] = $last_id;
						$sessions[ 'status' ] = true;
					} else {
						$sessions[ 'last_id' ] = false;
						$sessions[ 'status' ] = false;
					}
	
				}


				// if ($check_out >= ($current_time - (60 * 5)) && $check_out <= ($current_time + (60 * 5))) {
					// $update = $db->update("shift_check", array('check_out_time' => intval($check_out_time), 'check_out' => intval($check_out)), array('id' => $last_id));
					// if ($update) {
					// 	$sessions['last_id'] = $last_id;
					// 	$sessions['status'] = true;
					// } else {
					// 	$sessions['last_id'] = false;
					// 	$sessions['status'] = false;
					// }
				// } else {
				// 	$sessions['last_id'] = false;
				// 	$sessions['status'] = false;
				// }
			}
		} else {
			$sessions['last_id'] = false;
			$sessions['status'] = false;
		}
	echo json_encode($sessions);
} else {
	$sessions['status'] = false;
	echo json_encode($sessions);
	// $session->redirect('404', frontend);
}
