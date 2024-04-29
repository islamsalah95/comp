<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    if ($db->exists('company', array('id' => 1))) {
        $setting = $db->get_row('company', array('id' => 1));
    } else {
        $setting = $db->get_row('settings');
    }

    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php if ($db->exists('company', array('id' => 1))) { ?>
            <?php echo $setting['company_name']; ?>
        <?php } else { ?>
            <?php echo $setting['name']; ?>
        <?php } ?>
    </title>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400,700|Roboto:300,400,700" rel="stylesheet">
    <link href="<?php echo SITE_URL . '/assets/frontend/css/bootstrap.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo SITE_URL . '/assets/frontend/css/style.css'; ?>" rel="stylesheet">
    <link href="<?php echo SITE_URL . '/assets/frontend/plugins/font-awesome/css/font-awesome.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo SITE_URL . '/assets/frontend/plugins/chosen/chosen.min.css'; ?>" rel="stylesheet">
    <!-- custom css -->
    <link href="<?php echo SITE_URL . '/assets/frontend/css/custom.css'; ?>" rel="stylesheet">
    <link href="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-datepicker/bootstrap-datepicker.css'; ?>" rel="stylesheet">

    <link href="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-hijridate/css/bootstrap-datetimepicker.min.css'; ?>" rel="stylesheet">

    <style>
        .privacy_links {
            text-decoration: underline;
            font-weight: bold;
            text-align: center;
            border: 1px solid gray;
            border-radius: 5px;
            text-transform: uppercase;
            margin: 10px;
            padding: 5px;
        }

        .privacy_links:hover {
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <div id="container">
        <div class="boxed">
            <div id="content-container" style="padding-top: 15px;">
                <div id="page-content">

                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <?php if (isset($display_msg)) {
                                echo $display_msg;
                            } ?>
                            <div class="eq-height">
                                <div class="col-sm-12 eq-box-sm">
                                    <div class="panel">
                                        <div>
                                            <div class="center" style="text-align:center;">
                                                <!-- <img src="<?php echo SITE_URL . '/uploads/logo/' . $setting['logo']; ?>" width="200px;"> -->
                                                <?php if ($db->exists('company', array('id' => 1))) {
                                                    if ($setting['logo'] == '') {
                                                ?>
                                                        <img src="<?php echo SITE_URL . '/uploads/noimage.png'; ?>" width="150px;">
                                                    <?php } else { ?>
                                                        <img src="<?php echo SITE_URL . '/uploads/logo/company_logo/' . $setting['logo']; ?>" width="200px;" />

                                                    <?php }
                                                } else { ?>
                                                    <!-- <img  src="<?php echo SITE_URL . '/uploads/logo/' . $setting['logo']; ?>" class="img-circle"/> -->
                                                    <img src="<?php echo SITE_URL . '/uploads/logo/' . $setting['logo']; ?>" width="200px;" />
                                                <?php } ?>
                                                <div class="registration"> Log In to account ! <a href="<?php echo $link->link('login', frontend); ?>"> <span class="text-primary"> Sign In </span> </a> </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <div class="panel-heading">
                                            <h3 class="panel-title text-center">Freelancer Registration</h3>
                                        </div>
                                        <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" id="addUserFrom">
                                            <input type="hidden" name="profilesize" id="profilesize">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-6">



                                                        <div class="form-group">
                                                            <div class="text-left">
                                                                <label class="text-muted"><?php echo $lang['first_name']; ?></label>
                                                                <input class="form-control" type="text" placeholder="<?php echo $lang['enter_your_name']; ?> *" name="emp_name">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="text-left">
                                                                <label class="text-muted"><?php echo $lang['last_name']; ?></label>
                                                                <input class="form-control" type="text" placeholder="<?php echo $lang['enter_your_surname']; ?>" name="emp_surname">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="text-left">
                                                                <label class="text-muted"><?php echo $lang['email_id']; ?></label>
                                                                <input class="form-control" type="text" placeholder="<?php echo $lang['enter_your_email_address']; ?> *" name="email">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="text-left">
                                                                <label class="text-muted"><?php echo $lang['password']; ?></label>
                                                                <input class="form-control" type="password" placeholder="<?php echo $lang['enter_password']; ?> *" name="password">
                                                            </div>
                                                        </div>


                                                        <div class="form-group hidden">
                                                            <div class="text-left">
                                                                <label class="text-muted"><?php echo $lang['address']; ?></label>
                                                                <textarea class="form-control" name="address" placeholder="<?php echo $lang['enter_your_address']; ?>"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="text-left">
                                                                <label class="text-muted"><?php echo $lang['phone_number']; ?></label>
                                                                <input class="form-control" type="text" placeholder="<?php echo $lang['enter_your_phone_number']; ?>" name="contact1">
                                                            </div>
                                                        </div>



                                                        <div class="form-group">
                                                            <label class="text-muted text-capitalize"><?php echo "سنوات الخبرة " ?>:</label>
                                                            <select name="experiences" class="form-control select_experiences" required>
                                                                <?php for ($i = 0; $i < 60; $i++) { ?>
                                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="text-muted text-capitalize"><?php echo "مستوى الخبرة" ?>:</label>
                                                            <select name="experience_years" class="form-control select_experience_years" required>
                                                                <option value="b"> مبتدِئ  </option>
                                                                <option value="i"> متمرس </option>
                                                                <option value="s"> متمكن </option>
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="text-muted text-capitalize"><?php echo 'النوع ' ?></label>
                                                            <select name="gender" class="form-control select_genderworking_type" required>
                                                                <option value="m"> ذكر </option>
                                                                <option value="f"> انثى </option>
                                                                ?>
                                                            </select>
                                                        </div>


                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group hidden">
                                                            <label class="text-muted"><?php echo $lang['is_mol_TWC']; ?> </label>
                                                            <select name="is_molTWC" class="form-control" id="allowed">
                                                                <option value="0"><?php echo $lang['no']; ?></option>
                                                                <option value="1"><?php echo $lang['yes']; ?></option>
                                                            </select>
                                                        </div>


                                                        <div class="form-group text-left">
                                                            <label><?php echo $lang['date_of_birth']; ?> * : </label>
                                                            <input type="text" placeholder="yyyy-mm-dd" name="dob" id="dob" class="form-control" required />
                                                        </div>

                                                        <div class="form-group text-left">
                                                            <label><?php echo $lang['employee_national_number']; ?> * : </label>
                                                            <input type="text" placeholder="<?php echo $lang['employee_national_number']; ?>" name="employee_national_number" class="form-control" required />
                                                        </div>



                                                        <div class="form-group text-left">
                                                            <label><?php echo "جنسية"; ?> : </label>
                                                            <select class="form-control selectpicker" name="nationality">
                                                                <option value=""><?= "جنسية" ?></option>
                                                                <?php
                                                                $nationalities = array();
                                                                if (file_exists(SERVER_ROOT . '/uploads/nationalities.json')) {
                                                                    $nationalities = file_get_contents(SERVER_ROOT . '/uploads/nationalities.json');
                                                                }
                                                                $nationalities = json_decode($nationalities, true);
                                                                foreach ($nationalities as $key => $value) {
                                                                ?>
                                                                    <option value="<?php echo $value['Arabic_Nationality']; ?>"><?php echo $value['Arabic_Nationality']; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>




                                                        <div class="form-group text-left">
                                                            <label><?php echo $lang['country']; ?>:</label>
                                                            <select class="form-control selectpicker" name="country_id" id="country_id">
                                                                <option value=""><?php echo $lang['select_a_country']; ?></option>
                                                                <?php foreach ($countries as $country) { ?>
                                                                    <option value="<?php echo $country['id']; ?>"><?php echo $country['name']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group text-left">
                                                            <label><?php echo $lang['city']; ?>:</label>
                                                            <select class="form-control selectpicker" name="city_id" id="city_id">
                                                                <option value=""><?php echo $lang['select_city']; ?></option>
                                                            </select>
                                                        </div>


                                                        <div class="form-group hidden">
                                                            <label class="control-label"><?php echo $lang['upload_pic']; ?></label>
                                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                                <div class="fileupload-new img-thumbnail">
                                                                    <img src="<?php echo SITE_URL . '/uploads/noimage.png'; ?>" width="100%">
                                                                </div>
                                                                <div>
                                                                    <br>
                                                                    <input type="file" name="img" accept="image/*">
                                                                </div>
                                                                <small>Only jpg , png & jpeg (Max : <?php echo $upload_max_size; ?>)</small>
                                                            </div>
                                                        </div>

                                                        <!-- <hr> -->
                                                        <div class="form-group hidden">
                                                            <label class="control-label text-bold"><?php echo $lang['freelancer_company_details']; ?> </label>
                                                        </div>

                                                        <div class="form-group row hidden">
                                                            <div class="col-md-4"><label class="text-muted"><?php echo $lang['freelancer_type']; ?></label></div>
                                                            <div class="col-md-8">
                                                                <select name="freelancer_type" class="form-control " id="freelancer_type">
                                                                    <option value="1" selected><?php echo $lang['individual']; ?></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="job_title"><?= $lang['job_title'] ?> </label>
                                                            <select name="job_title" class="form-control select_job" required>
                                                                <option value=""><?= $lang['select_option'] ?></option>
                                                                <?php
                                                                foreach ($specialities as $specialityID => $speciality) {
                                                                ?>
                                                                    <option value="<?= $speciality[$_SESSION['site_lang'] . '_Title']; ?>"><?= $speciality[$_SESSION['site_lang'] . '_Title']; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="text-muted text-capitalize"><?php echo 'نوع العمل ' ?></label>
                                                            <select name="working_type" class="form-control select_working_type" required>
                                                                <option value="a"> حضور </option>
                                                                <option value="r"> عن بعد</option>
                                                                ?>
                                                            </select>
                                                        </div>



                                                        <div class="form-group">
                                                            <label class="text-muted text-capitalize"><?= $lang['baccalaureus'] ?></label>
                                                            <?php
                                                            $dropdown_arr = array($lang['nohighschool'], $lang['highschool'], $lang['bachelor'], $lang['master'], $lang['doctoral']);
                                                            ?>
                                                            <select name="baccalaureus" class="form-control select_baccalaureus" required>
                                                                <option value=""><?= $lang['select_option'] ?></option>
                                                                <?php
                                                                foreach ($dropdown_arr as $id => $deg_val) {
                                                                ?>
                                                                    <option value="<?= $deg_val; ?>"><?= $deg_val; ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>




                                                    </div>



                                                    <div class="col-sm-12">
                                                    <div class="form-group text-left">
                                                            <label><?php echo "مهارات" ?>:</label>
                                                            <textarea type="text" placeholder="<?php echo "مهارات" ?>" name="skills" class="big-box-textarea form-control" rows="5" cols="50"></textarea>
                                                        </div>
                                                    </div>



                                                </div>
                                                <div class="row">
                                                    <div class="text-left privacy_checkbox_container col-md-12">
                                                        <input name="privacy_checkbox" type="checkbox" value="1" class="form-control privacy_checkbox col-md-1" style="width: auto !important; height: auto; margin-right: 10px;" required />
                                                        <!-- <span class="col-md-11"><?php echo $lang['privacy_policy']; ?></span> -->
                                                        <span class="col-md-11">I have read and agree to the Terms and Conditions and <a target="_blank" href="<?php echo $link->link('privacy_policy', frontend); ?>"> <span class="text-primary"> Privacy Policy </span> </a></span>
                                                    </div>
                                                </div>

                                                <div class="panel-footer text-center">
                                                    <button class="btn btn-success register_button" type="submit" name="submit_freelancer" disabled><i class="fa fa-save"></i> Register</button>

                                                </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="<?php echo SITE_URL . '/assets/frontend/js/jquery-2.1.1.min.js'; ?>"></script>
    <script src="<?php echo SITE_URL . '/assets/frontend/js/bootstrap.min.js'; ?>"></script>
    <script src="<?php echo SITE_URL . '/assets/frontend/plugins/chosen/chosen.jquery.min.js'; ?>"></script>
    <!-- jQuery-Vaildation -->
    <script src="<?php echo SITE_URL . '/assets/frontend/plugins/jquery-validation/jquery.validate.min.js'; ?>"></script>
    <script src="<?php echo SITE_URL . '/assets/frontend/plugins/jquery-validation/additional-methods.min.js'; ?>"></script>
    <script src="<?php echo SITE_URL . '/assets/frontend/js/form-validation.js'; ?>"></script>

    <script src="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-datepicker/bootstrap-datepicker.js'; ?>"></script>
    <script src="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-datepicker/moment.js'; ?>" type="text/javascript"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
    <script src="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-hijridate/js/bootstrap-hijri-datetimepicker.min.js'; ?>"></script>
    <script>
        $(document).ready(function() {
            $('#country_id').on('change', function() {
                var countryId = $(this).val();
                if (countryId) {
                   var url = '<?php echo $link->link("get_cities", frontend); ?>';
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: {
                            country_id: countryId
                        },
                        success: function(data) {
                            $('#city_id').html(data);
                        }
                    });
                } else {
                    $('#city_id').html('<option value=""><?php echo $lang['select_city']; ?></option>');
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('.select_job').chosen();
            $('#select_city').chosen();

            $('#privacy_container').show();
            $('.privacy_checkbox').click(function() {
                $(".register_button").attr('disabled', 'disabled');
                if ($(this).is(":checked")) {
                    $(".register_button").removeAttr('disabled');
                }
            });

            $('.birthdate').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                endDate: '+0d',
                todayHighlight: true,
                startView: 2
            });

            $("#dob").hijriDatePicker({
                showTodayButton: true,
                showClear: true,
                hijri: true,
                format: 'YYYY-MM-DD'
            });
        });
    </script>

</body>

</html>