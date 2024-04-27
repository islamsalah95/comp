<?php
// $freelancers = $db->run("SELECT * from `employee` where `department`='3'")->fetchAll();
// $freelancers = $db->run("SELECT * from `employee` where `department`='3' AND `company_id` ='" . $_SESSION['company_id'] . "'")->fetchAll();
if ($_SESSION['department'] == 5){
     $freelancers = $db->run("SELECT * from `employee` where `department`='3'")->fetchAll();
    // $freelancers = myQuery("SELECT * from `employee` where `department`='3'");

}
else{
    $freelancers = $db->run("SELECT * from `employee` e left join `employee_company_map` ecm on e.employee_id = ecm.employee_id where e.`department`='3' and ecm.company_id in (" . implode(',', $user_companies) . ") ")->fetchAll();
    // $freelancers = myQuery("SELECT * from `employee` e left join `employee_company_map` ecm on e.employee_id = ecm.employee_id where e.`department`='3' and ecm.company_id in (" . implode(',', $user_companies) . ") ");

}

$emp_details = array();
$load = $_REQUEST['del_id'] ?? '';

if (isset($_REQUEST['del_id'])) {
    $display_msg = '<form method="POST" action="">
<div class="alert alert-success" >
' . $lang["user_delete_confirmation"] . '
<input type="hidden" name="del_id" value="' . $load . '" >
<button name="yes" type="submit" class="btn btn-success btn-xs"  aria-hidden="true"><i class="fa fa-check-square-o"></i></button>
<button name="no" type="submit" class="btn btn-danger btn-xs" aria-hidden="true"><i class="fa fa-remove"></i></button>
</div>
</form>';
}
if (isset($_POST['yes'])) {
    $get_image = $db->get_var("employee", array('employee_id' => $load), 'emp_photo_file');

    $emp_details = $db->get_row('employee', array('employee_id' => $load));
    $delete = $db->delete("employee", array('employee_id' => $load));
    $shift_dl = $db->delete("shift_check", array('employee_id' => $load));

    $feature->rrmdir(SERVER_ROOT . '/uploads/images/' . $_SESSION['company_id'] . '/' . $load);

    if (file_exists(SERVER_ROOT . '/uploads/profile/' . $get_image) && (($get_image) != '')) {
        unlink(SERVER_ROOT . '/uploads/profile/' . $get_image);
    }

    if ($delete) {
        if (file_exists(SERVER_ROOT . '/protected/views/frontend/templates/teleworker_update.php')) {
            $templates = file_get_contents(SERVER_ROOT . '/protected/views/frontend/templates/teleworker_update.php');
            $site_settings = $db->get_row('settings');
            $site_logo = $site_settings['logo'];

            $replacements = array(
                '{SITE_LOGO_SRC}' => SITE_URL . '/uploads/logo/' . $site_logo,
                '{DATE}' => date("F j, Y h:i:s"),
                '{PANEL_HEAD}' => $lang['telework_email_head'],
                '{PANEL_BODY_TEXT}' => $lang['telework_email_body_text'],
                '{MAX_TW_COUNT_LABEL}' => $lang['max_telework_count_label'],
                '{MAX_TW_COUNT}' => COMPANY_ALLOWED_EMPLOYEE,
                '{CURRENT_TW_COUNT_LABEL}' => $lang['current_telework_count_label'],
                '{CURRENT_TW_COUNT}' => $db->get_count('employee', array('company_id' => CURRENT_LOGIN_COMPANY_ID, 'department' => 2)),
                '{CMP_NAME_LABEL}' => $lang['company_name'],
                '{CMP_NAME}' => $company_details['company_name'],
                '{EMP_NAME_LABEL}' => $lang['employee_name'],
                '{EMP_NAME}' => $emp_details['emp_name'] . ' ' . $emp_details['emp_surname'],
                '{EMP_EMAIL_LABEL}' => $lang['email_address'],
                '{EMP_EMAIL}' => $emp_details['email'],
            );

            $message_data = str_replace(array_keys($replacements), array_values($replacements), $templates);
            // $email_list = $db->run("SELECT email from `employee` where (company_id = " . $_SESSION['company_id'] . " and department = 1 ) || (department in (5,6) ) and status = 0 ")->fetchAll();
            $email_list = myQuery("SELECT email from `employee` where (company_id = " . $_SESSION['company_id'] . " and department = 1 ) || (department in (5,6) ) and status = 0 ");

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

            // $email_to = 'hiren.macwan@confidosoft.com';
            // $mail->addAddress($email_to);
            $mail->Subject = '[TechsupTrack] ' . $lang['teleworker_delete_emails_subject'];
            $mail->msgHTML($message_data);
            foreach ($email_list as $email) {
                $mail->clearAllRecipients();
                $mail->addAddress($email['email']);
                // $mail_status = $mail->send();
            }
            // $mail_status = $mail->send();

        }

        $session->redirect('freelancers', frontend);
    }
} elseif (isset($_POST['no'])) {
    $session->redirect('freelancers', frontend);
}

$is_activate = $_REQUEST['activate_id'] ?? '';

if (isset($_REQUEST['activate_id'])) {
    $display_msg = '<form method="POST" action="">
<div class="alert alert-success" >
' . $lang["are_you_sure"] . '
<input type="hidden" name="activate_id" value="' . $is_activate . '" >
<button name="activate" type="submit" class="btn btn-success btn-xs"  aria-hidden="true"><i class="fa fa-check-square-o"></i></button>
<button name="no" type="submit" class="btn btn-danger btn-xs" aria-hidden="true"><i class="fa fa-remove"></i></button>
</div>
</form>';
}
if (isset($_POST['activate'])) {
    $update = $db->update("employee", array('status' => 0), array('employee_id' => $is_activate));

    if ($update) {
        $session->redirect('freelancers', frontend);
    }
}


$is_deactivate = $_REQUEST['deactivate_id'] ?? '';

if (isset($_REQUEST['deactivate_id'])) {
    $display_msg = '<form method="POST" action="">
<div class="alert alert-success" >
' . $lang["are_you_sure"] . '
<input type="hidden" name="deactivate_id" value="' . $is_deactivate . '" >
<button name="deactivate" type="submit" class="btn btn-success btn-xs"  aria-hidden="true"><i class="fa fa-check-square-o"></i></button>
<button name="no" type="submit" class="btn btn-danger btn-xs" aria-hidden="true"><i class="fa fa-remove"></i></button>
</div>
</form>';
}
if (isset($_POST['deactivate'])) {
    $update = $db->update("employee", array('status' => 1), array('employee_id' => $is_deactivate));

    if ($update) {
        $session->redirect('freelancers', frontend);
    }
}
