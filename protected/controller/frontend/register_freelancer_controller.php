<?php
/* Job Title */
$specialities = array();
if (file_exists(SERVER_ROOT . '/uploads/job_titles.json')) {
    $specialities = file_get_contents(SERVER_ROOT . '/uploads/job_titles.json');
}
$specialities = json_decode($specialities, true);
/* End Job Title */


/* countries */
$countries = $db->myQuery("SELECT id, name, phone_code FROM countries;");
/* countries*/


if (isset($_SESSION['department'])) {
    if (isset($_SESSION['department']) && ($_SESSION['department'] == 2 || $_SESSION['department'] == 3)) {
        $session->redirect('profile', frontend);
    } else {
        $session->redirect('home', frontend);
    }
}

if (isset($_POST['submit_freelancer'])) {


    $emp_name = $_POST['emp_name'];
    $emp_surname = $_POST['emp_surname'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $passs = $_POST['password'];

    $contact1 = $_POST['contact1'];
    $freelancer_type = 1;
    $freelancer_company = 1;
    $dob = $_POST['dob'];
    $employee_national_number = $_POST['employee_national_number'];
    $city_id = $_POST['city_id'];

    $department = "3";
    $create_on = date('y-m-d h:i:s');
    $ip_address = $_SERVER['REMOTE_ADDR'];

    $job_title = $_POST['job_title'];
    $baccalaureus = $_POST['baccalaureus'];


    $country = $_POST['country_id'];
    $nationality = $_POST['nationality'];
    $skills = $_POST['skills'];
    $working_type = $_POST['working_type'];
    $gender = $_POST['gender'];
    $account_type = 'p';
    $experience_years = $_POST['experience_years'];
    $experiences = $_POST['experiences'];
    $emp_salary = $_POST['emp_salary'];
    $address = $_POST['address'];



    $errors = [];
    $validation = true;

    if ($emp_name == '') {
        $errors['emp_name'] = 'emp name is required';
        $validation = false;
    } 
    if ($emp_surname == '') {
        $errors['emp_surname'] = 'surname name is required';
        $validation = false;
    } 
    
    if ($email == '') {
        $errors['email'] = 'email is required';
        $validation = false;
    } 
    
    if ($password == '') {
        $errors['password'] = 'Password is required';
        $validation = false;
    } 
    // else if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[A-Za-z\d]{8,}$/', $password)) {
    //     $errors['password'] = 'Password must be at least 8 characters long and contain at least one letter and one number';
    // }

    if ($contact1 == '') {
        $errors['phone_number'] = 'phone number is required';
        $validation = false;
    }

    if ($dob == '') {
        $errors['birtday'] = 'dob  is required';
        $validation = false;
    }

    if ($employee_national_number == '') {
        $errors['employee_national_number'] = 'employee national numberis required';
        $validation = false;
    }

    if ($country == '') {
        $errors['country'] = 'country  is required';
        $validation = false;
    } 
    if ($city_id == '') {
        $errors['city'] = 'city is required';
        $validation = false;
    } 
    if ($skills == '') {
        $errors['skills'] = 'skills is required';
        $validation = false;
    } 
    if ($nationality == '') {
        $errors['nationality'] = 'nationality is required';
        $validation = false;
    }
     
    if ($dob == '') {
        $errors['birtday'] = 'dob  is required';
        $validation = false;
    }

        if ($job_title == '') {
        $errors['job_title'] = 'job  is required';
        $validation = false;
    }

    if ($validation ) {        
        $encrypt_password = password_hash($pass, PASSWORD_BCRYPT, ['cost' => 10]);
        $insert = $db->insert('employee', array(
            'emp_name' => $emp_name,
            'emp_surname' => $emp_surname,
            'department' => $department,
            'contact1' => $contact1,
            'company_id' => $freelancer_company,
            'is_company' => $freelancer_type,
            'email' => $email,
            'password' => $encrypt_password,
            'create_date' => $create_on,
            'ip_address' => $ip_address,
            'dob' => $dob,
            'city_id' => $city_id,
            'job_title'     => $job_title,
            'baccalaureus'  => $baccalaureus,
            'employee_national_number' => $employee_national_number,
            'privacy_check' => 1,

            'country' => $country,
            'nationality' => $nationality,
            'skills' => $skills,
            'working_type' => $working_type,
            'gender' => $gender,
            'account_type' => $account_type,
            'experience_years' => $experience_years,
            'experiences' => $experiences,
            'emp_salary' => $emp_salary,
            'address' => $address,
        ));
        $emplast_id = $db->lastInsertId();
        if ($insert &&  $emplast_id) {
            $db->insert(
                'employee_company',
                array('employee_id' => $emplast_id, 'company_id' => 1)
            );
            $_SESSION[ 'msg' ] ='success register';
        }



        if ($insert) {
            /////////////////////////////send user and passowrd/////////////////
            require SERVER_ROOT . '/protected/controller/frontend/send_user_pass.php';
            ///////////////////////////////////////////////////////////////////


            $path_cmp = SERVER_ROOT . '/uploads/images/' . $freelancer_company . '/';
            $path1 = SERVER_ROOT . '/uploads/images/' . $freelancer_company . '/' . $emplast_id . '/';

            if (!is_dir($path_cmp)) {
                mkdir($path_cmp);

                if (!file_exists($path1)) {
                    mkdir($path1);
                }
            }

            $display_msg = '<div class="alert alert-success">
                            <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>' . $lang["add_success"] . '
                        </div>';
            echo "<script>
                setTimeout(function(){
                    window.location = '" . $link->link("login", frontend) . "'
                },2000);</script>";
        } else {
            $display_msg = '<div class="alert alert-danger">
                        <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button">&times;</button>Something went wrong. Please try agian later.
                        </div>';
        }
    }
}
