<?php
// session_start();
// $table = 'employee';
// $primaryKey = 'employee_id';
// $columns = array(
//     array('db' => 'employee_id', 'dt' => 0),
//     array('db' => 'emp_name', 'dt' => 1),
//     array('db' => 'email', 'dt' => 2),
// );

// $sql_details = array(
//     'user' => DB_USER,
//     'pass' => DB_PASSWORD,
//     'db'   => DB_NAME,
//     'host' => DB_HOST
// );

// // $where = array("department = '4' AND company_id = '" . $_SESSION['company_id'] . "'");

// // $user_companies = array();
// $user_companies = array($_SESSION['company_id']);
// $companies = $db->run("SELECT emp.company_id, c.company_name FROM employee_company_map emp LEFT JOIN company c on c.id = emp.company_id WHERE employee_id  IN (SELECT e.employee_id FROM employee e LEFT JOIN employee_company_map m on m.employee_id = e.employee_id WHERE m.company_id = " . $_SESSION['company_id'] . " and e.department = 1)")->fetchAll();
// if (!empty($companies)) {
//     foreach ($companies as $c) {
//         $user_companies[] = $c['company_id'];
//     }
// }
// $where = array("department = '4' AND company_id IN (" . implode(',', $user_companies) . ")");

// $output_arr = SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $where);
// foreach ($output_arr['data'] as $key => $value) {
//     $edit_link = $link->link("edit_manager", frontend, '&edit=' . $value[0]);
//     $delete_link = $link->link("managers", '', '&del_id=' . $value[0]);
//     $activate = $db->get_col('employee', array('employee_id' => $value[0]), 'status');
//     if (end($activate) == 1) {
//         $activate_lable = $lang["activate"];
//         $activate_link = $link->link("managers", '', '&activate_id=' . $value[0]);
//         $activate_style = '<a href="' . $activate_link . '" style="margin:0 10px;" "><span class="label label-warning" style="background-color:#203b47;border-color:#203b47;">' . $activate_lable . '</span></a>';
//     } else {
//         $activate_lable = $lang["deactivate"];
//         $activate_link = $link->link("managers", '', '&deactivate_id=' . $value[0]);
//         $activate_style = '<a href="' . $activate_link . '" style="margin:0 10px;" "><span class="label label-warning" style="background-color:#0a9bb9;border-color:#0a9bb9;">' . $activate_lable . '</span></a>';
//     }
//     $output_arr['data'][$key][count($output_arr['data'][$key])] = '<a href="' . $edit_link . '" style="margin:0 10px;" "><span class="btn btn-success fa fa-edit">' . '</span></a><a href="' . $delete_link . '" style="margin:0 10px;" "><span class="btn btn-danger fa fa-trash">' . '</span></a>' . $activate_style;
//     // <a href="' . $activate_link . '" style="margin:0 10px;" "><span class="label label-warning">' . $activate_lable . '</span></a>
// }
// // echo "<pre>"; print_r($output_arr['data']); exit();
// echo json_encode($output_arr);
// exit();

?>
<?php 
// echo $_SESSION['company_id'];

// $user_companies = array($_SESSION['company_id']);
// $companies = $db->run("SELECT emp.company_id, c.company_name FROM employee_company_map emp LEFT JOIN company c on c.id = emp.company_id WHERE employee_id IN (SELECT e.employee_id FROM employee e LEFT JOIN employee_company_map m on m.employee_id = e.employee_id WHERE m.company_id = " . $_SESSION['company_id'] . " and e.department = 1)")->fetchAll();
// if (!empty($companies)) {
//     foreach ($companies as $c) {
//         $user_companies[] = $c['company_id'];
//     }
// }


// // Convert the array to a comma-separated string
// $user_companies_string = implode(',', $user_companies);

// // The SQL query with the replaced parameter
// $sql = "SELECT 
//     employee_id,
//     emp_name,
//     email
// FROM
//     employee
// WHERE
//     department = '4'
//     AND company_id IN ($user_companies_string)";

// $a = $db->run($sql)->fetchAll();
?>


<?php 
$user_companies = array($_SESSION['company_id']);
$companies = $db->run("SELECT emp.company_id, c.company_name FROM employee_company_map emp LEFT JOIN company c on c.id = emp.company_id WHERE employee_id IN (SELECT e.employee_id FROM employee e LEFT JOIN employee_company_map m on m.employee_id = e.employee_id WHERE m.company_id = " . $_SESSION['company_id'] . " and e.department = 1)")->fetchAll();
if (!empty($companies)) {
    foreach ($companies as $c) {
        $user_companies[] = $c['company_id'];
    }
}


// Convert the array to a comma-separated string
$user_companies_string = implode(',', $user_companies);

// The SQL query with the replaced parameter
$sql = "SELECT 
    employee_id,
    emp_name,
    emp_surname,
    email,
    status
FROM
    employee
WHERE
    department = '4'
    AND company_id IN ($user_companies_string)";

$freelancers = $db->run($sql)->fetchAll();
// $freelancers = $db->run("SELECT `e`.* from `employee` e left join `employee_company_map` ecm on e.employee_id = ecm.employee_id where e.`department`='3' and e.`company_id` = " . $_SESSION['company_id'] . " and ecm.employee_id is NULL")->fetchAll();
// $freelancers = $db->run("SELECT `e`.* from `employee` e left join `employee_company_map` ecm on e.employee_id = ecm.employee_id where e.`department`='3' and e.`company_id` = " . $_SESSION['company_id'] . " and ecm.employee_id is NULL")->fetchAll();

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
</form>' . "my id " .  $load ;
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
            $email_list = $db->run("SELECT email from `employee` where (company_id = " . $_SESSION['company_id'] . " and department = 1 ) || (department in (5,6) ) and status = 0 ")->fetchAll();

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

        $session->redirect('registered_freelancers', frontend);
    }

    $_REQUEST['del_id']='';

} elseif (isset($_POST['no'])) {
    $_REQUEST['del_id']='';
    $session->redirect('registered_freelancers', frontend);
}

$is_activate = $_REQUEST['activate_id']?? '';

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
        $session->redirect('registered_freelancers', frontend);
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
        $session->redirect('registered_freelancers', frontend);
    }
}

?>


?>