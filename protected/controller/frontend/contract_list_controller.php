<?php
require('all_contracts_controller.php');

$number_id = $_GET['number'];
// start MRN contract list API
$validations = true;
$contract_list_api = [];

if ($validations) {
    // $url = "https://external-api.mrn-uat.espace.ws/api/v1/contracts";
    $url = "https://external-api.mrn.sa/api/v1/contracts";//production env.

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    // curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json','X-Secret-Key: DmkaTNSQrqKDc5r6tAZDRgsv','X-Client-Number: 726552444','Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json','X-Secret-Key: mnXLk2Yi9eT87RrkyU4Nr8mN','X-Client-Number: 9496095213','Content-Type: application/json')); //production env.

    $result = curl_exec($ch);
    curl_close($ch);
    // echo "<pre>" . print_r($result); exit();

    if ($result) {
        $res = json_decode($result, true);
        if (count($res) !== 0 || !empty($res)) {
            $contract_list_api = $res;
        // echo "<pre>" . print_r($contract_list_api); exit();
        } else {
            $display_msg = '<div class="alert alert-danger">
                                    <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>' . $res['message'] . '
                                </div>';
        }
    }
} else {
    $display_msg = '<div class="alert alert-danger">
                            <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>' . $lang["error_occured"] . '
                        </div>';
}
// end MRN contract list API