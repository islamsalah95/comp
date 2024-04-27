<?php
require('show_contract_controller.php');

$number = $_GET['number'];

$cancel_reasons = array();
if (file_exists(SERVER_ROOT . '/uploads/cancel_reasons.json')) {
    $cancel_reasons = file_get_contents(SERVER_ROOT . '/uploads/cancel_reasons.json');
}
$cancel_reasons = json_decode($cancel_reasons, true);

$allowed_types = [1, 3, 4, 5, 6];
if (!in_array($_SESSION['department'], $allowed_types) || $number < 0 || $number == '') {
    echo "<script>window.location = '" . SITE_URL . "'</script>";
}

$sql = "SELECT cc.number, cc.cancellation_reason_id, cc.cancellation_reason, cc.comment, cc.actual_worked_hours_at_cancellation, cc.status as cancel_status, cc.reference_number as cancel_reference_number, cc.message as cancel_message FROM `cancel_contract` cc WHERE cc.number = $number";
$contract_details = $db->run($sql)->fetchAll();

if (is_array($contract_details) && !empty($contract_details)) {
    $contract = $contract_details[0];
} else {
    echo "<script>window.location = '" . SITE_URL . "'</script>";
}

// echo "<pre>"; print_r($contract_details); exit();

if (isset($_POST['integrate_contract'])) {

    $validations = true;
    if ($number < 0 || $number == ''){
        $validations  = false;
    }

    if ($validations) {
        // echo "<pre>"; print_r($contract); exit();
        // $url = "https://external-api.mrn-uat.espace.ws/api/v1/contracts/cancel";
        $url = "https://external-api.mrn.sa/api/v1/contracts/cancel";//production env.

        $data = array(
            'contracts' => [array(
                'number' => $contract['number'],
                'cancellation_reason_id' => $contract['cancellation_reason_id'],
                'comment' => $contract['comment'],
                'actual_worked_hours_at_cancellation' => $contract['actual_worked_hours_at_cancellation'],
            )]
        );
        $data = json_encode($data);
        // echo $data; exit();

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json','X-Secret-Key: DmkaTNSQrqKDc5r6tAZDRgsv','X-Client-Number: 726552444','Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json','X-Secret-Key: mnXLk2Yi9eT87RrkyU4Nr8mN','X-Client-Number: 9496095213','Content-Type: application/json')); //production env.

        $result = curl_exec($ch);
        curl_close($ch);

        if ($result) {
            $res = json_decode($result, true);
            if (isset($res['reference_number']) && $res['reference_number'] != '') {
                $update = $db->update(
                    'cancel_contract',
                    array(
                        'status' => 200,
                        'reference_number' => $res['reference_number'],
                        'message' => $res['message'],
                    ),
                    array(
                        'number' => $number
                    )
                );
                if ($update) {
                    $display_msg = '<div class="alert alert-success">
                                    <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>' . $res['message'] . '
                                </div>';
                    echo "<script>
                            setTimeout(function(){
                                window.location = '" . $link->link("view_cancel_contract", frontend, '&number=' . $number) . "'
                            },2000);
                        </script>";
                } else {
                    // $db->debug(); exit();
                    $display_msg = '<div class="alert alert-danger">
                                <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>' . $lang["error_occured"] . '
                            </div>';
                }
            } else {
                // print_r($res); exit();
                $display_msg = '<div class="alert alert-danger">
                                    <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>' . $res['status'] . ' | ' .  $res['message'] . '
                                </div>';
            }
        }
    } else {
        $display_msg = '<div class="alert alert-danger">
                            <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>' . $lang["error_occured"] . '
                        </div>';
    }
}