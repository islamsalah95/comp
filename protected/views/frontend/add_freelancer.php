<link href="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-hijridate/css/bootstrap-datetimepicker.min.css'; ?>" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
<script src="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-hijridate/js/bootstrap-hijri-datetimepicker.min.js'; ?>"></script>

<div id="content-container">
    <div class="pageheader hidden-xs">
        <h3><i class="fa fa-home"></i><?php echo $lang['add_freelancer']; ?></h3>
        <div class="breadcrumb-wrapper">
            <span class="label"><?php echo $lang['you_are_here']; ?>:</span>
            <ol class="breadcrumb">
                <li> <a href="<?php echo $link->link('home', frontend); ?>"> <?php echo $lang['dashboard']; ?> </a> </li>
                <li> <a href="<?php echo $link->link('freelancers', frontend); ?>"><?php echo $lang['freelancers']; ?> </a> </li>
                <li class="active"><?php echo $lang['add_freelancer']; ?></li>
            </ol>
        </div>
    </div>
    <div id="page-content">
        <div class="row">
            <?php echo $display_msg ?? ''; ?>
            <div class="eq-height">
                <div class="col-sm-12 eq-box-sm">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-control">
                                <button class="btn btn-default" onclick="goBack()"><i class="fa fa-arrow-circle-left"></i> <?php echo $lang['go_back']; ?></button>
                            </div>
                            <h3 class="panel-title"><?php echo $lang['add_freelancer']; ?></h3>
                        </div>
                        <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" id="addUserFrom">
                            <input type="hidden" name="profilesize" id="profilesize">

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-5">



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

                                        <div class="form-group">
                                            <div class="text-left">
                                                <label class="text-muted"><?php echo $lang['phone_number']; ?></label>
                                                <input class="form-control" type="text" placeholder="<?php echo $lang['enter_your_phone_number']; ?>" name="contact1">
                                            </div>
                                        </div>

                                        <div class="form-group text-left">
                                            <label><?php echo $lang['date_of_birth']; ?> * : </label>
                                            <input type="text" placeholder="yyyy-mm-dd" id="dob" name="dob" class="form-control" required />
                                        </div>


                                        <div class="form-group">
                                            <div class="text-left">
                                                <label class="text-muted"><?php echo $lang['address']; ?></label>
                                                <textarea class="form-control" name="address" placeholder="<?php echo $lang['enter_your_address']; ?>"></textarea>
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
                                            <label class="text-muted text-capitalize"><?php echo 'النوع ' ?></label>
                                            <select name="gender" class="form-control select_genderworking_type" required>
                                                <option value="m"> ذكر </option>
                                                <option value="f"> انثى </option>

                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="text-muted text-capitalize"><?php echo "مستوى الخبرة" ?>:</label>
                                            <select name="experience_years" class="form-control select_experience_years" required>
                                                <option value="b"> مبتدِئ </option>
                                                <option value="i"> متمرس </option>
                                                <option value="s"> متمكن </option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="text-muted text-capitalize"><?php echo 'نوع العمل ' ?></label>
                                            <select name="working_type" class="form-control select_working_type" required>
                                                <option value="a"> حضور </option>
                                                <option value="r"> عن بعد</option>
                                            </select>
                                        </div>




                                    </div>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-6">

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


                                        <div class="form-group">
                                            <label class="text-muted text-capitalize"><?php echo "سنوات الخبرة " ?>:</label>
                                            <select name="experiences" class="form-control select_experiences" required>
                                                <?php for ($i = 0; $i < 60; $i++) { ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                <?php } ?>
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



                                        <div class="form-group">
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

                                        <hr>
                                        <div class="form-group">
                                            <label class="control-label text-bold"><?php echo $lang['freelancer_company_details']; ?> </label>
                                        </div>





                                        <div class="form-group row">
                                            <div class="col-md-4"><label class="text-muted"><?php echo $lang['freelancer_type']; ?> : </label></div>
                                            <div class="col-md-8">
                                                <select name="freelancer_type" class="form-control " id="freelancer_type">
                                                    <option value="0"><?php echo $lang['company']; ?></option>
                                                    <option value="1"><?php echo $lang['individual']; ?></option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row freelancer_company_container">
                                            <div class="col-md-4">
                                                <label class="text-muted"><?php echo $lang['freelancer'] . ' ' . $lang['company']; ?> : </label>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="demo-cs-multiselect" id="freelancer_company" name="freelancer_company[]" multiple tabindex="4">
                                                    <?php if (is_array($company)) foreach ($company as $value) { ?>
                                                        <option value="<?php echo $value['id']; ?>" <?php if ($value['id'] == $_SESSION['company_id']) echo "selected"; ?>><?php echo $value['company_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group text-left">
                                            <label><?php echo "مهارات" ?>:</label>
                                            <textarea type="text" placeholder="<?php echo "مهارات" ?>" name="skills" class="big-box-textarea form-control" rows="5" cols="50"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-footer text-center">
                                <a class="btn btn-warning" href="<?php echo $link->link('freelancers', frontend); ?>"><i class="fa fa-times"></i> <?php echo $lang['cancel']; ?></a>
                                <button class="btn btn-success" type="submit" name="submit_freelancer"><i class="fa fa-save"></i> <?php echo $lang['submit']; ?></button>

                            </div>
                        </form>
                    </div>
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

<script>
    $(document).ready(function() {
        var companies = <?php echo json_encode($company); ?>;

        $('.freelancer_company_select').chosen();
        $('#freelancer_type').change(function() {
            var freelancer_type = $(this).val();
            if (freelancer_type == 1) {
                $('.freelancer_company_container').hide();
            } else {
                $('.freelancer_company_container').show();
            }
        });

        $('.freelancer_assign_company').click(function() {
            var html = '';
            html += '<div class="form-group row">';
            html += '<div class="col-md-5">';
            html += '<select class="form-control selectpicker freelancer_company_select" name="freelancer_assigned_company[]" required>';

            var selected_companies = [];
            $('.freelancer_company_select').each(function() {
                if ($(this).val() != '') {
                    selected_companies.push($(this).val());
                }
            });
            companies.forEach(function(company) {
                if (!selected_companies.includes(company.id)) {
                    html += '<option value="' + company.id + '">' + company.company_name + '</option>';
                }
            });

            html += '</select>';
            html += '</div>';

            html += '<div class="col-md-3">';
            html += '<input class="form-control freelancer_wh" type="text" placeholder="<?php echo $lang['working_hours']; ?>" name="freelancer_working_hours[]" required>';
            html += '</div>';

            html += '<div class="col-md-3">';
            html += '<input class="form-control freelancer_ht" type="text" placeholder="<?php echo $lang['hour_rate']; ?>" name="freelancer_hourly_rate[]" required>';
            html += '</div>';

            html += '<div class="col-md-1">';
            html += '<button type="button" class="btn btn-danger freelancer_delete_row"><i class="fa fa-trash"></i></button>';
            html += '</div>';

            html += '</div>';

            $('.freelancer_cw_container').append(html);
            $('.freelancer_company_select').chosen();

        });

        $(document).on('click', '.freelancer_delete_row', function() {
            $(this).parent().parent().remove();
        });

        $('#select_city').chosen();

        $("#dob").hijriDatePicker({
            showTodayButton: true,
            showClear: true,
            hijri: true,
            format: 'YYYY-MM-DD'
        });
    });
</script>