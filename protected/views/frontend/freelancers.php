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
// $sql = "
// SELECT
//     employee.employee_id,
//     employee.company_id,
//     employee.status,
//     emp_name,
//     email,
//     CASE 
//         WHEN employee_company_map.end_date < CURDATE() THEN 0
//         ELSE 1
//     END AS condition_result
// FROM
//     employee
// LEFT JOIN employee_company_map ON employee.employee_id = employee_company_map.employee_id
// WHERE
//     department = '3' AND employee_company_map.company_id = :company_id
//     AND employee_company_map.end_date = (
//         SELECT MAX(end_date) 
//         FROM employee_company_map 
//         WHERE employee_id = employee.employee_id
//     );
// ";




// // Prepare the statement
// $stmt = $db->prepare($sql);

// // Bind the 'company_id' parameter from the session variable
// $stmt->bindParam(':company_id', $_SESSION['company_id']);

// // Execute the statement
// $stmt->execute();

// // Fetch the results
// $freelancers = $stmt->fetchAll();

$company_id = $_SESSION['company_id'];
// $sql = "
// SELECT
//     e.employee_id,
//     e.company_id,
//     e.status,
//     e.emp_name,
//     e.email,
//     CASE 
//         WHEN employee_company_map.end_date < CURDATE() THEN 0
//         ELSE 1
//     END AS condition_result
// FROM
//     employee e
// LEFT JOIN employee_company ec ON e.employee_id = ec.employee_id AND ec.company_id = $company_id
// LEFT JOIN employee_company_map ON ec.employee_id = employee_company_map.employee_id
// WHERE
//     e.department = '3' AND employee_company_map.company_id = $company_id
//     AND employee_company_map.end_date = (
//         SELECT MAX(end_date) 
//         FROM employee_company_map 
//         WHERE employee_id = ec.employee_id
//     );
// ";
$sql = "
    SELECT DISTINCT
        e.employee_id,
        e.company_id,
        e.status,
        e.emp_name,
        e.email,
        CASE 
            WHEN ecm.end_date < CURDATE() THEN 0 
            ELSE 1
        END AS condition_result
    FROM employee e
    LEFT JOIN employee_company ec ON e.employee_id = ec.employee_id AND ec.company_id = $company_id
    LEFT JOIN employee_company_map ecm ON ec.employee_id = ecm.employee_id AND ecm.company_id = $company_id
    WHERE e.department = '3'
    AND ecm.employee_id IS NOT NULL
    AND ecm.end_date = (
        SELECT MAX(end_date) 
        FROM employee_company_map 
        WHERE employee_id = ec.employee_id
        AND company_id = $company_id
    );
";


$freelancers = myQuery($sql);

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
</form>' . "my id " .  $load;
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

        $session->redirect('freelancers', frontend);
    }

    $_REQUEST['del_id'] = '';
} elseif (isset($_POST['no'])) {
    $_REQUEST['del_id'] = '';
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

?>



<div id="content-container">
    <div class="pageheader">
        <h3><i><img src="<?php echo SITE_URL . '/uploads/logo/company_icons/icons_flex-25.png'; ?>" style="width:40px;height:40px;margin:0 10px;" alt="Freelancer Picture"></i><?php echo $lang['freelancers']; ?></h3>
        <div class="breadcrumb-wrapper">
            <span class="label"><?php echo $lang['you_are_here']; ?>:</span>
            <ol class="breadcrumb">
                <li> <a href="<?php echo $link->link('home', frontend); ?>"> <?php echo $lang['dashboard']; ?> </a> </li>
                <li class="active"><?php echo $lang['freelancers']; ?></li>
            </ol>
        </div>
    </div>
    <div id="page-content">
        <div class="panel-heading">
            <span class="pull-right">
                <a class="btn btn-primary" href="<?php echo $link->link('add_freelancer', frontend); ?>"><i class="fa fa-plus"></i> <?php echo $lang['add_freelancer']; ?></a>
            </span>
        </div>


        <?php echo $display_msg ?? ''; ?>
        <table id="example1" class="cell-border example1 table table-striped table1 delSelTable">
            <thead>
                <tr>
                    <th><?php echo $lang['id']; ?></th>
                    <th><?php echo $lang['name']; ?></th>
                    <th><?php echo $lang['email']; ?></th>
                    <th width="20%"><?php echo $lang['action']; ?></th>
                </tr>
            </thead>
            <tbody>


            <?php if (is_array($freelancers)) {
    foreach ($freelancers as $freelancer) { ?>

        <tr>
            <td>
                <?php echo $freelancer['employee_id']; ?>
            </td>
            <td>
                <?php echo $freelancer['emp_name']; ?>
            </td>
            <td>
                <?php echo $freelancer['email']; ?>
            </td>
            <td style="display: flex; justify-content: flex-start;align-items: center;">
                <!-- <a href="<?php echo $link->link("edit_freelancer", frontend, '&edit=' . $freelancer['employee_id']); ?>" class="btn btn-success fa fa-edit"></a> -->

                <form method="post" action="<?= $link->link("edit_freelancer", frontend) ?>">
                    <input type="hidden" name="edit" value="<?= $freelancer['employee_id'] ?>">
                    <button type="submit" class="btn btn-success fa fa-edit" style="margin: 3px;"></button>
                </form>

                <form action="" method="post">
                    <input type="hidden" name="del_id" value="<?php echo $freelancer['employee_id']; ?>">
                    <button class="btn btn-danger fa fa-trash" type="submit" name="del" style="margin: 3px;"></button>
                </form>

                <?php
                if ($freelancer['status'] != 0) { ?>
                    <form action="" method="post">
                        <input type="hidden" name="activate_id" value="<?php echo $freelancer['employee_id']; ?>">
                        <button class="btn btn-warning" type="submit" name="activateid" style=" margin: 3px; padding-top: 3px;padding-bottom: 3px;"><?php echo $lang['activate']; ?></button>
                    </form>
                <?php } else { ?>
                    <form action="" method="post">
                        <input type="hidden" name="deactivate_id" value="<?php echo $freelancer['employee_id']; ?>">
                        <button class="btn btn-warning" type="submit" name="deactivateid" style=" margin: 3px; padding-top: 3px;padding-bottom: 3px;"><?php echo $lang['deactivate']; ?></button>
                    </form>
                <?php } ?>

                <!-- If not expired == 0 -->
                <?php if ($freelancer['condition_result'] == 0) { ?>
                    <form method="post" action="<?= $link->link('add_contract', frontend) ?>">
                        <input type="hidden" name="employee_id" value="<?= $freelancer['employee_id'] ?>">
                        <button type="submit" class="btn btn-primary fa fa-plus" style="margin: 3px;"></button>
                    </form>
                <?php } ?>

                <form method="post" action="<?php echo $link->link('previous_jobs', frontend); ?>">
                    <input type="hidden" name="employee_id" value="<?= $freelancer['employee_id'] ?>">
                    <input type="hidden" name="company_id" value="<?= $freelancer['company_id'] ?>">
                    <button type="submit" class="btn btn-info" style="margin: 3px;">Info</button>
                </form>
            </td>
        </tr>
<?php }
} ?>

            </tbody>
        </table>
    </div>
</div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#example1').DataTable({
            // dom: 'lfBrtip',
            "dom": "<'row'<'col-md-4'l><'col-md-8'Bf>>" + "<'row'<'col-md-6'><'col-md-6'>>" + "<'row'<'col-md-12't>><'row'<'col-md-6'i><'col-md-6'p>>",
            buttons: [{
                    extend: 'csv',
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                }
            ],
            "responsive": true,
            "language": {
                "paginate": {
                    "previous": '<i class="fa fa-angle-left"></i>',
                    "next": '<i class="fa fa-angle-right"></i>'
                }
            },
            "iDisplayLength": 10,
            "oLanguage": {
                'sUrl': '//cdn.datatables.net/plug-ins/1.10.19/i18n/<?php echo $_SESSION['site_lang']; ?>.json'
            }
        });
    });
</script>