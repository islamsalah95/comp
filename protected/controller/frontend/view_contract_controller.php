<?php

// $cities = array();
// if (file_exists(SERVER_ROOT . '/uploads/cities.json')) {
//     $cities = file_get_contents(SERVER_ROOT . '/uploads/cities.json');
// }
// $cities = json_decode($cities, true);

$load = $_REQUEST['contract_id'];

$specialities = array();
if (file_exists(SERVER_ROOT . '/uploads/job_titles.json')) {
    $specialities = file_get_contents(SERVER_ROOT . '/uploads/job_titles.json');
}
$specialities = json_decode($specialities, true);

$contract_id = $_POST['contract_id'];
$company_id = $_SESSION['company_id'];
// $allowed_types = [3, 4, 5];
$allowed_types = [1, 3, 4, 5, 6];
if (!in_array($_SESSION['department'], $allowed_types) || $contract_id < 0 || $contract_id == '') {
    echo "<script>window.location = '" . SITE_URL . "'</script>";
}

// $sql = "SELECT ecm.*, concat(e.emp_name, ' ', e.emp_surname) as employee_name, e.IdNumber, e.EstLaborOfficeId, e.EstSequenceNumber, e.employee_national_number, e.dob, e.city_id, c.company_name FROM employee_company_map ecm LEFT JOIN employee e on e.employee_id = ecm.employee_id LEFT JOIN company c on c.id = ecm.company_id WHERE ecm.company_id = $company_id and ecm.id = $contract_id ";
$sql = "SELECT ecm.*, concat(e.emp_name, ' ', e.emp_surname) as employee_name, e.employee_national_number, e.dob, e.city_id, c.company_name FROM employee_company_map ecm LEFT JOIN employee e on e.employee_id = ecm.employee_id LEFT JOIN company c on c.id = ecm.company_id WHERE ecm.company_id = $company_id and ecm.id = $contract_id ";
$contract_details = $db->run($sql)->fetchAll();

if (is_array($contract_details) && !empty($contract_details)) {
    $contract = $contract_details[0];
} else {
    echo "<script>window.location = '" . SITE_URL . "'</script>";
}

// echo "<pre>"; print_r($contract_details); exit();


if (isset($_POST['integrate_contract'])) {

    $validations = true;
    $cid = $_POST['cid'];
    if ($cid != $contract_id) {
        $validations  = false;
    }

    if ($validations) {

        // echo "<pre>"; print_r($contract); exit();
        //url for test environment
        // $url = "https://external-api.mrn-uat.espace.ws/api/v1/contracts";
        $url = "https://external-api.mrn.sa/api/v1/contracts/";  //production env.

        $data = array(

            'contracts' => [array(
                'job_title' => $contract['job_title'],
                'start_date' => $contract['start_date'],
                'end_date' => $contract['end_date'],
                // 'working_hours_per_day' => $contract['working_hours_per_day'] + 0,
                'hourly_rate' => $contract['hourly_rate'] + 0,
                // 'working_hours_per_week' => $contract['working_hours_per_week'] + 0,
                'total_working_hours' => $contract['working_hours'] + 0,
                'city_id' => $contract['city_id'] + 0,
                'gosi_job_title_id' => $contract['gosi_job_title_id'] + 0,
                'employee_national_number' => $contract['employee_national_number'] + 0,
                'employee_dob_hijri' => $contract['dob'],
                'employer_labor_office_id' => $contract['EstLaborOfficeId'],
                'employer_sequence_number' => $contract['EstSequenceNumber'],

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
        // add X-Client-Number ,X-Secret-Key for test environment
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json','X-Secret-Key: DmkaTNSQrqKDc5r6tAZDRgsv','X-Client-Number: 726552444','Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json','X-Secret-Key: mnXLk2Yi9eT87RrkyU4Nr8mN','X-Client-Number: 9496095213','Content-Type: application/json')); //production env.

        $result = curl_exec($ch);
        curl_close($ch);

        if ($result) {
            $res = json_decode($result, true);
            // echo "<pre>"; print_r($res); exit();
            if (isset($res['reference_number']) && $res['reference_number'] != '') {
                $update = $db->update(
                    'employee_company_map',
                    array(
                        'status' => 200,
                        'reference_number' => $res['reference_number'],
                        'message' => $res['message'],
                    ),
                    array(
                        'id' => $contract_id
                    )
                );
                if ($update) {
                    $display_msg = '<div class="alert alert-success">
                                    <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>' . $res['message'] . '
                                </div>';
                    echo "<script>
                            setTimeout(function(){
                                window.location = '" . $link->link("view_contract", frontend, '&contract_id=' . $contract_id) . "'
                            },2000);
                        </script>";
                } else {
                    $display_msg = '<div class="alert alert-danger">
                                <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>' . $lang["error_occured"] . '
                            </div>';
                }
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
}
