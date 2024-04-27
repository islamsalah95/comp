<style>
    .alert button.close {
        margin-top: -15px;
    }
</style>

<?php
if ($db->get_count('company') == '0') {
    $session->redirect('signup', frontend);
} elseif (isset($_SESSION['email'])) {
    if (isset($_SESSION['department']) && ($_SESSION['department'] == 2 || $_SESSION['department'] == 3)) {
        $session->redirect('profile', frontend);
    } else {
        $session->redirect('home', frontend);
    }
    // $session->redirect('home',frontend);
}

if (isset($_POST['Resend'])) {
	$_SESSION['verify'] = false;

	
}

if (isset($_POST['forgot_pass'])) {

    $email = $_POST['email'];
    //$cookie_set=$_POST['cookie_set'];
    if ($email == '') {
        $display_msg = '<div class="alert alert-danger">
                        <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>' . $lang["enter_your_email_address"] . '
                        </div>';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $display_msg = '<div class="alert alert-danger">
                        <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>' . $lang["enter_valid_email"] . '
                        </div>';
    } elseif (!$db->exists('employee', array('email' => $email))) {
        $display_msg = '<div class="alert alert-danger text-danger text-center">
							<i class="lnr lnr-sad"></i>
									<font color="red"> ' . 'Email not exist' . '</font>
							</div>';
    } else {
                  if(  !isset($_SESSION['verify']) || $_SESSION['verify'] !==true ){

		            // Generate a random code
					$code = rand(10000, 99999);

					// Update the "employee" table with the generated code
					$update = $db->update("employee", array('emp_code' => $code), array('email' =>  $email));

		             //send sms with username and password
					 $query = $db->get_row('employee', array('email' => $email));
					 if ($query['contact1'] != '' && file_exists(SERVER_ROOT . '/webservice/class_sms.php')) {
						require SERVER_ROOT . '/webservice/class_sms.php';
					$msg = "Hello From Flex Congratulations on your Reset Password. Your code is {$code}";
		
						send_sms($query['contact1'],$msg);
					}
				 
				 
				 
				  //send email with username and password
				
				  if (file_exists(SERVER_ROOT . '/webservice/mail/sendEmail.php') 
				  ) {
					  require SERVER_ROOT . '/webservice/mail/sendEmail.php';
				  
					  $msg = 'Hello';
					  $msg .= '<br/>';
					  $msg .= '<b>Hello From Flex Congratulations on your Reset Password  Your code is </b> ' . $code;
		
					  sendEmail($msg,$email,"Welcome To Our Platform ",'Chick Your Email Please' );
		
				  }
	


				  $_SESSION['verify'] = true;
				}

    }
}



if (isset($_POST['change_pass'])) {

    $code = $_POST['code'];
    $pass = $_POST['password'];
    $retypepassword = $_POST['retypepassword'];

    if ($code == '') {
        $display_msg = '<div class="alert alert-danger">
                                <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>' . "wrong code" . '
                                </div>';
    } elseif ($pass == '') {
        $display_msg = '<div class="alert alert-danger">
                                      <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">
                                    &times;</button>
                                     ' . 'code'. '
                               </div>';
    } elseif ($retypepassword == '') {
        $display_msg = '<div class="alert alert-danger">
                                      <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">
                                        &times;</button>
                                     ' . $lang["enter_retype_password"] . '
                               </div>';
    } elseif ($pass != $retypepassword) {
        $display_msg = '<div class="alert alert-danger">
                                     <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">
                                    &times;</button>
                                     ' . $lang["password_not_match"] . '
                               </div>';
    } else {
        try {
            $query = $db->get_row('employee', array('emp_code' => $code));
            if ($query) {
                $encrypt_password = password_hash($pass, PASSWORD_BCRYPT, ['cost' => 10]);
                $update = $db->update("employee", array('password' => $encrypt_password), array('emp_code' =>  $code));
              
                $db->update("employee", array('emp_code' => null), array('emp_code' =>  $code));

                //send email with username and password to new user
                if (file_exists(SERVER_ROOT . '/webservice/mail/sendEmail.php')) {
                    require SERVER_ROOT . '/webservice/mail/sendEmail.php';

                    $msg = 'Hello';
                    $msg .= '<br/>';
                    $msg .= '<b>url : <a href="https://techsupflex.com">https://techsupflex.com</a> </b> ';
                    $msg .= '<br/>';
                    $msg .= '<b>Username : </b> ' . $query['email'];
                    $msg .= '<br/>';
                    $msg .= '<b>Password : </b> ' . $pass;

                    sendEmail($msg, $query['email'], "Welcome To Our Platform ", 'Check Your Email Please');
                }

                $_SESSION["isAdmin"] = false;
                if ($query['department'] == 1 || $query['department'] == 4 || $query['department'] == 3) {
                    $_SESSION["isAdmin"] = true;
                    $user_companies = array();
                    $employee_company_map = $db->get('employee_company_map', array('employee_id' => $query['employee_id']));
                    if (!empty($employee_company_map)) {
                        foreach ($employee_company_map as $map_data) {
                            if ($db->exists('company', array('id' => $map_data['company_id'])) && $db->get_row('company', array('id' => $map_data['company_id']))['is_valid'] != 0) {
                                $user_companies[] = $map_data['company_id'];
                            }
                        }
                    }
                }

                $session->Open();
                $_SESSION['email'] = $query['email'];
                $_SESSION['employee_id'] = $query['employee_id'];
                $_SESSION['company_id'] = $query['company_id'];
                $_SESSION['department'] = $query['department'];
                $_SESSION['verifyCode'] = 0;
                if ($query['department'] == 1 || $query['department'] == 4 || $query['department'] == 3) {
                    $_SESSION['user_companies'] = $user_companies;
                    $_SESSION['company_id'] = $user_companies[0];
                }

                if ($_SESSION['department'] == 2) {
                    $session->redirect('profile', frontend);
                } elseif ($_SESSION['department'] == 3) {
                    $session->redirect('freelancer_profile', frontend);
                } else {
                    $session->redirect('home', frontend);
                }
            } else {
                $display_msg = '<div class="alert alert-danger">
                <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>
                    Wrong code
                </div>';
            }
        } catch (Exception $e) {
			$display_msg = '<div class="alert alert-danger">
			<i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>
				Wrong code
			</div>';
        }
    }
}

?>