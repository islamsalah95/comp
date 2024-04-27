<?php
if (isset($_POST['submit_user'])) {
    $emp_name = $_POST['emp_name'];
    $emp_surname = $_POST['emp_surname'];
    $address = $_POST['address'];
    $contact1 = $_POST['contact1'];
    $email = $_POST['email'];
    $department = "4";
    $pass = $_POST['password'];
    $assigned_companies = $_POST['company'];

    $create_on = date('y-m-d h:i:s');
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $pro = $_FILES['img'];

    $handle = new uploader($_FILES['img']);
    $path = SERVER_ROOT . '/uploads/profile/';

    if (!is_dir($path)) {
        if (!file_exists($path)) {
            mkdir($path);
        }
    }

    if (($fv->emptyfields(array('emp_name' => $emp_name), NULL)) || 
        ($fv->emptyfields(array('email' => $email), NULL)) ||
        !$fv->check_email($email) ||
        $db->exists('employee', array('email' => $email)) ||
        $fv->emptyfields(array('password' => $pass))) {
        $display_msg = '<div class="alert alert-danger">
                        <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>' . $lang["error_message"] . '
                        </div>';
    } else {
        if (($pro['name']) != '') {
            $newfilename = $handle->file_new_name_body = preg_replace('/\s+/', '', time());
            $ext = $handle->image_src_type;
            $filename = $newfilename . '.' . $ext;

            if ($handle->image_src_type == 'jpg' || $handle->image_src_type == 'jpeg' || $handle->image_src_type == 'JPEG' || $handle->image_src_type == 'png' || $handle->image_src_type == 'JPG') {
                if ($handle->uploaded) {
                    $handle->Process($path);
                    if ($handle->processed) {
                        $encrypt_password = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 10]);
                        $insert = $db->insert('employee', array(
                            'emp_name' => $emp_name,
                            'emp_surname' => $emp_surname,
                            'department' => $department,
                            'address' => $address,
                            'contact1' => $contact1,
                            'company_id' => $_SESSION['company_id'],
                            'email' => $email,
                            'password' => $encrypt_password,
                            'create_date' => $create_on,
                            'ip_address' => $ip_address
                        ));
                        $emplast_id = $db->lastInsertId();
                        if ($insert) {
                            if (!empty($assigned_companies)) {
                                foreach ($assigned_companies as $c_id) {
                                    $insert_map = $db->insert('employee_company_map', array('employee_id' => $emplast_id, 'company_id' => $c_id));
                                }
                            }
                            $path_cmp = SERVER_ROOT . '/uploads/images/' . $_SESSION['company_id'] . '/';
                            $path1 = SERVER_ROOT . '/uploads/images/' . $_SESSION['company_id'] . '/' . $emplast_id . '/';

                            if (!is_dir($path_cmp)) {
                                mkdir($path_cmp);

                                if (!file_exists($path1)) {
                                    mkdir($path1);
                                }
                            }
                             /////////////////////////////send user and passowrd
require SERVER_ROOT . '/protected/controller/frontend/send_user_pass.php';
///////////////////////////////////////////////////////////////////
                            $display_msg = '<div class="alert alert-success">
                                            <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>' . $lang["add_success"] . '
                                            </div>';
                        }
                    }
                }
            }
        } else {
            $encrypt_password = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 10]);
            $insert = $db->insert('employee', array(
                'emp_name' => $emp_name,
                'emp_surname' => $emp_surname,
                'department' => $department,
                'address' => $address,
                'contact1' => $contact1,
                'company_id' => $_SESSION['company_id'],
                'email' => $email,
                'password' => $encrypt_password,
                'create_date' => $create_on,
                'ip_address' => $ip_address
            ));
            $emplast_id = $db->lastInsertId();
            if ($insert) {

                if (!empty($assigned_companies)) {
                    foreach ($assigned_companies as $c_id) {
                        $insert_map = $db->insert('employee_company_map', array('employee_id' => $emplast_id, 'company_id' => $c_id));
                    }
                }
                $path_cmp = SERVER_ROOT . '/uploads/images/' . $_SESSION['company_id'] . '/';
                $path1 = SERVER_ROOT . '/uploads/images/' . $_SESSION['company_id'] . '/' . $emplast_id . '/';

                if (!is_dir($path_cmp)) {
                    mkdir($path_cmp);

                    if (!file_exists($path1)) {
                        mkdir($path1);
                    }
                }
                 /////////////////////////////send user and passowrd
require SERVER_ROOT . '/protected/controller/frontend/send_user_pass.php';
///////////////////////////////////////////////////////////////////
                $display_msg = '<div class="alert alert-success">
                                <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>' . $lang["add_success"] . '
                                </div>';
            }
        }
    }
}
?>

