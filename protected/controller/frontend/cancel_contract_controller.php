<!-- cancel_contract_controller.php -->
<?php
require('show_contract_controller.php');

$number = $_GET['number'];

$cancel_reasons = array();
if (file_exists(SERVER_ROOT . '/uploads/cancel_reasons.json')) {
    $cancel_reasons = file_get_contents(SERVER_ROOT . '/uploads/cancel_reasons.json');
}
$cancel_reasons = json_decode($cancel_reasons, true);


if (isset($_POST['cancel_contract'])) {

    $validations = true;
    if ($number < 0 || $number == ''){
        $validations  = false;
    }

    $contract_data['number'] = $number;
    $contract_data['cancellation_reason'] = (array_key_exists($_POST['cancellation_reason_id'], $cancel_reasons)) ? $cancel_reasons[$_POST['cancellation_reason_id']][$_SESSION['site_lang'] . '_name'] : '';
    $contract_data['cancellation_reason_id'] = (array_key_exists($_POST['cancellation_reason_id'], $cancel_reasons)) ? $cancel_reasons[$_POST['cancellation_reason_id']]['id'] : '';
    $contract_data['comment'] = $_POST['comment'];
    $contract_data['actual_worked_hours_at_cancellation'] = $_POST['actual_worked_hours_at_cancellation'];

// echo "<pre>"; print_r($contract_data); exit();

    if ($validations) {

        $insert = $db->insert('cancel_contract', $contract_data);
        $contract_id = $db->lastInsertId();
        if ($insert) {
            // $update = $db->update("employee_company_map", array('status_id' => 8), array('id' => $contract_data['number']));
                // if ($update) {
                    $display_msg = '<div class="alert alert-success">
                    <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>' . $lang["contract_canceled_successfully"] . '
                                </div>';
                    echo "<script>
                        setTimeout(function(){
                            window.location = '" . $link->link("view_cancel_contract", frontend, '&number=' . $number) . "'
                        },2000);
                    </script>";
                // }
        } 
        // window.location = '" . $link->link("all_contracts", frontend, '&employee_id=' . $employee_id) . "'
        else {
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
// end cancel contract