<?php
if (isset($_POST['submit_user'])) {
    $emp_name = $_POST['emp_name'];
    $emp_surname = $_POST['emp_surname'];
    $address = $_POST['address'];
    $contact1 = $_POST['contact1'];
    $email = $_POST['email'];
    $department = "1";
    $pass = $_POST['password'];
    $create_on = date('y-m-d h:i:s');
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $pro = $_FILES['img'];

    $path = SERVER_ROOT . '/uploads/profile/';

    if (!is_dir($path)) {
        if (!file_exists($path)) {
            mkdir($path);
        }
    }

    // Validate and sanitize user inputs
    $emp_name = trim($emp_name);
    $emp_surname = trim($emp_surname);
    $address = trim($address);
    $contact1 = trim($contact1);
    $email = trim($email);

    if (empty($emp_name) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $display_msg = '<div class="alert alert-danger">
            <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>' . $lang["error_message"] . '
        </div>';
    } else {
        // Check if email already exists in the database
        if ($db->exists('employee', ['email' => $email])) {
            $display_msg = '<div class="alert alert-danger">
                <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>' . $lang["email_exists"] . '
            </div>';
        } else {
            // Hash the password
            $encrypt_password = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 10]);

            if (!empty($pro['name'])) {
                $handle = new uploader($_FILES['img']);
                $newfilename = $handle->file_new_name_body = preg_replace('/\s+/', '', time());
                $ext = strtolower($handle->image_src_type);

                if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                    if ($handle->uploaded) {
                        $handle->Process($path);

                        if ($handle->processed) {
                            $insert = $db->insert('employee', [
                                'emp_name' => $emp_name,
                                'emp_surname' => $emp_surname,
                                'department' => $department,
                                'address' => $address,
                                'contact1' => $contact1,
                                'company_id' => $_SESSION['company_id'],
                                'email' => $email,
                                'password' => $encrypt_password,
                                'create_date' => $create_on,
                                'ip_address' => $ip_address,
                            ]);

                            if ($insert) {
                                $emplast_id = $db->lastInsertId();
                                $insert_map = $db->insert('employee_company_map', ['employee_id' => $emplast_id, 'company_id' => $_SESSION['company_id']]);
                                $path_cmp = SERVER_ROOT . '/uploads/images/' . $_SESSION['company_id'] . '/';
                                $path1 = SERVER_ROOT . '/uploads/images/' . $_SESSION['company_id'] . '/' . $emplast_id . '/';

                                if (!is_dir($path_cmp)) {
                                    mkdir($path_cmp);
                                }

                                if (!file_exists($path1)) {
                                    mkdir($path1);
                                }

                                $display_msg = '<div class="alert alert-success">
                                    <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>' . $lang["add_success"] . '
                                </div>';
                                 /////////////////////////////send user and passowrd
require SERVER_ROOT . '/protected/controller/frontend/send_user_pass.php';
///////////////////////////////////////////////////////////////////
                            }
                        }
                    }
                }
            } else {
                // No file uploaded
                $insert = $db->insert('employee', [
                    'emp_name' => $emp_name,
                    'emp_surname' => $emp_surname,
                    'department' => $department,
                    'address' => $address,
                    'contact1' => $contact1,
                    'company_id' => $_SESSION['company_id'],
                    'email' => $email,
                    'password' => $encrypt_password,
                    'create_date' => $create_on,
                    'ip_address' => $ip_address,
                ]);

                if ($insert) {
                    $emplast_id = $db->lastInsertId();
                    $insert_map = $db->insert('employee_company_map', ['employee_id' => $emplast_id, 'company_id' => $_SESSION['company_id']]);
                    $path_cmp = SERVER_ROOT . '/uploads/images/' . $_SESSION['company_id'] . '/';
                    $path1 = SERVER_ROOT . '/uploads/images/' . $_SESSION['company_id'] . '/' . $emplast_id . '/';

                    if (!is_dir($path_cmp)) {
                        mkdir($path_cmp);
                    }

                    if (!file_exists($path1)) {
                        mkdir($path1);
                    }

                    $display_msg = '<div class="alert alert-success">
                        <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>' . $lang["add_success"] . '
                    </div>';
 /////////////////////////////send user and passowrd
require SERVER_ROOT . '/protected/controller/frontend/send_user_pass.php';
///////////////////////////////////////////////////////////////////
                }
            }
        }
    }
}
?>
