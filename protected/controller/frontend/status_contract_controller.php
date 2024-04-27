<?php

$ref_num = $_GET['ref_num'];
// $contract_id = $_GET['contract_id'];
// $company_id = $_SESSION['company_id'];
// $allowed_types = [3, 4, 5];
$allowed_types = [1, 3, 4, 5 ,6];
if (!in_array($_SESSION['department'], $allowed_types) || $ref_num < 0 || $ref_num == '') {
    echo "<script>window.location = '" . SITE_URL . "'</script>";
}

// $sql = "SELECT ecm.*, concat(e.emp_name, ' ', e.emp_surname) as employee_name, e.employee_national_number, e.dob, e.city_id, c.company_name FROM employee_company_map ecm LEFT JOIN employee e on e.employee_id = ecm.employee_id LEFT JOIN company c on c.id = ecm.company_id WHERE ecm.company_id = $company_id and ecm.id = $contract_id ";
// $contract_details = $db->run($sql)->fetchAll();

// if (is_array($contract_details) && !empty($contract_details)) {
//     $contract = $contract_details[0];
// } else {
//     echo "<script>window.location = '" . SITE_URL . "'</script>";
// }

// echo "<pre>"; print_r($contract_details); exit();


$validations = true;
$contract_status = [];

if ($validations) {

    //add url for test environment
    // $url = "https://external-api.mrn-uat.espace.ws/api/v1/contracts_requests/" . $ref_num;
    $url = "https://external-api.mrn.sa/api/v1/contracts_requests/" . $ref_num;//production env.

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    // add X-Client-Number ,X-Secret-Key for test environment
    // curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json','X-Secret-Key: DmkaTNSQrqKDc5r6tAZDRgsv','X-Client-Number: 726552444','Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json','X-Secret-Key: mnXLk2Yi9eT87RrkyU4Nr8mN','X-Client-Number: 9496095213','Content-Type: application/json')); //production env.

    $result = curl_exec($ch);
    curl_close($ch);

    if ($result) {
        $res = json_decode($result, true);
        // echo "<pre>"; print_r($res); exit();
        if (isset($res['reference_number']) && $res['reference_number'] != '') {
            $contract_status = $res;
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

// echo "<pre>"; print_r($contract_status); exit();