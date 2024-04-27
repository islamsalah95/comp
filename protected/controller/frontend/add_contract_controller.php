<?php

// $cities = array();
// if (file_exists(SERVER_ROOT . '/uploads/cities.json')) {
//     $cities = file_get_contents(SERVER_ROOT . '/uploads/cities.json');
// }
// $cities = json_decode($cities, true);

$specialities = array();
if (file_exists(SERVER_ROOT . '/uploads/job_titles.json')) {
    $specialities = file_get_contents(SERVER_ROOT . '/uploads/job_titles.json');
}
$specialities = json_decode($specialities, true);

$eid = $_REQUEST['employee_id'];
$contract_id = 0;

if (isset($_POST['submit_contract'])) {

    $validations = true;
    $employee_id = $_POST['eid'];
    if ($eid != $employee_id) {
        $validations  = false;
    }

    $contract_data['company_id'] = $_SESSION['company_id'];
    $contract_data['employee_id'] = $employee_id;
    $contract_data['start_date'] = $_POST['start_date'];
    $contract_data['end_date'] = $_POST['end_date'];
    $contract_data['gosi_job_title_id'] = $_POST['job_title'];
    $contract_data['hourly_rate'] = $_POST['hourly_rate'];
    $contract_data['working_hours_per_day'] = $_POST['working_hours_per_day'];
    $contract_data['working_hours_per_week'] = $_POST['working_hours_per_week'];
    $contract_data['working_hours'] = $_POST['working_hours'];
    $contract_data['job_title'] = (array_key_exists($_POST['job_title'], $specialities)) ? $specialities[$_POST['job_title']][$_SESSION['site_lang'] . '_Title'] : '';

    $contract_data['EstLaborOfficeId'] = $_POST['EstLaborOfficeId'];
    $contract_data['EstSequenceNumber'] = $_POST['EstSequenceNumber'];
    $contract_data['is_molTWC'] = $_POST['is_molTWC'];

    $contract_data['created_by'] = $_SESSION['employee_id'];
    // created 
    $contract_data['status_id'] = 1;

    // $employee_data = $db->run("SELECT e.IdNumber, e.EstLaborOfficeId, e.EstSequenceNumber, e.employee_national_number, e.dob, e.city_id FROM  employee e  WHERE e.employee_id = $employee_id")->fetchAll();
    // if (is_array($employee_data) && count($employee_data) > 0) {
    //     $data = array_merge($employee_data[0], $contract_data);
    // }

   // foreach ($contract_data as $key => $value) {
    //    if ($key != 'working_hours_per_day' && $value == '') {
            $validations = false;
    //    }
    //}
    $validations = true;

    if ($validations) {
        $insert = $db->insert('employee_company_map', $contract_data);
        $contract_id = $db->lastInsertId();
        if ($insert) {
            $display_msg = '
            <div class="alert alert-success">
                                <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>' . $lang["add_success"] . '
                            </div>';
            echo "<script>
                    setTimeout(function(){
                        window.location = '" . $link->link("all_contracts", frontend) . "'
                    },2000);
                </script>";
        } else {
            // $db->debug(); exit();
            $display_msg = '<div class="alert alert-danger">
                                <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>' . $lang["error_occured"] . '
                            </div>';
        }
    } else {
        $display_msg = '<div class="alert alert-danger">
                            <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>' . $lang["required_field_error"] . '
                        </div>';
    }
}

if ($contract_id > 0) {
    $email = $db->run("SELECT email from `employee` where employee_id = " . $eid)->fetchAll();
    if (!empty($email) && isset($email[0]['email']) && $email[0]['email'] != '') {
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
        $mail->clearAllRecipients();

        $mail->Subject = '[TechsupFlex]  New Contract';

        $message_data = '';
        $message_data .= '<div style="width:100%;border: 1px solid #cdcdcd;padding: 2px;">';
        $message_data .= '<div style="width:100%;text-align:center;margin-bottom: 10px;">';
        $message_data .= '<div>';
        $message_data .= '<img style="width:150px" src="' . SITE_URL . '/uploads/logo/techsupflex.png">';
        $message_data .= '</div>';
        $message_data .= '<div style="text-align:center;font-family: Arial, Helvetica, sans-serif;">';
        $message_data .= '<h2>New Contract Details</h2>';
        $message_data .= '<h5 style="margin:5px;">(' . date("F j, Y h:i:s") . ')</h5>';
        $message_data .= '<h5 style="margin:5px;color:red;">Important: contract end after 48 hours (from the contract start date)</h5>';
        $message_data .= '</div><hr>';
        $message_data .= '<br/><br/>';
        $message_data .= '<div style="clear: both;"></div>';
        $message_data .= '</div>';
        $message_data .= '<div style="width:100%;text-align:center">Please click on button below to check your contract details:';
        $message_data .= '<br/><br/>';
        $message_data .= '<a style="background-color:#203b47;color:#fff;padding:5px 10px;margin:5px;border-radius:3px;text-decoration:none;" href = "' . SITE_URL . '/index.php?user=view_contract&contract_id=' . $contract_id . '" target = "_blank">Contract Details</a>';
        $message_data .= '<br/><br/>';
        $message_data .= '</div>';
        $message_data .= '</div>';
        $mail->msgHTML($message_data);
        // $mail->addAddress("hiren.macwan@confidosoft.com");
        $mail->addAddress($email[0]['email']);
        $mail_status = $mail->send();
    }

    $freelancer_data = $db->run("SELECT contact1 from `employee` where employee_id = " . $eid)->fetchAll();
    if (!empty($freelancer_data) && isset($freelancer_data[0]['contact1']) && $freelancer_data[0]['contact1'] != '') {
        //send sms with username and password to new user
        if (file_exists(SERVER_ROOT . '/webservice/class_sms.php')) {
            require SERVER_ROOT . '/webservice/class_sms.php';
            $sms = new SMS();
            $msg = 'Hello';
            $msg .= '<br/>';
            $msg .= '<b>url : <a href="https://techsupflex.com">https://techsupflex.com</a> </b> ';
            $msg .= '<br/>';
            $msg .= 'Please click on button below to check your contract details:';
            $msg .= '<br/>';
            $msg .= '<a style="background-color:#203b47;color:#fff;padding:5px 10px;margin:5px;border-radius:3px;text-decoration:none;" href = "' . SITE_URL . '/index.php?user=view_contract&contract_id=' . $contract_id . '" target = "_blank">Contract Details</a>';
            $data = array(
                'mobile_number' => $freelancer_data[0]['contact1'],
                'text' => $msg
            );
            $sms->send_sms($data);
        }
        //end changes
    }
}