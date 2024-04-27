<style>
    .ui-autocomplete {
        list-style: none;
        background: #fff;
        padding: 0px;
        max-width: 100ch !important;
        max-height: 300px !important;
        overflow-y: scroll;
    }

    .ui-menu-item {
        padding: 10px;
        cursor: pointer;
        background-color: #fff;
        border-bottom: 1px solid #d4d4d4;
    }

    .ui-menu-item:hover {
        background-color: #e9e9e9;
    }
</style>
<div id="content-container">
    <div class="pageheader">
        <h3><i><img src="<?php echo SITE_URL . '/uploads/logo/company_icons/icons_flex-05.png'; ?>" style="width:40px;height:40px;margin:0 10px;" alt="Search Picture"></i><?php echo $lang['search_freelancer']; ?></h3>
        <div class="breadcrumb-wrapper">
            <span class="label"><?php echo $lang['you_are_here']; ?>:</span>
            <ol class="breadcrumb">
                <li class="active"><?php echo $lang['search_freelancer']; ?></li>
            </ol>
        </div>
    </div>



    <div id="page-content">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10 text-center">
                <!-- <form action="<?php $link->link("edit_freelancer", frontend); ?>" id="freelancer_search_form" method="post">
                   
                <div class="col-md-12">
        <div class="form-group">
            <label for="job_title"><?= $lang['job_title'] ?> </label>
            <select name="job_title" class="form-control select_job" required>
                <option value=""><?= $lang['select_option'] ?></option>
                <?php
                foreach ($specialities2 as $specialityID => $speciality) {
                ?>
                    <option value="<?= $speciality[$_SESSION['site_lang'] . '_Title']; ?>"><?= $speciality[$_SESSION['site_lang'] . '_Title']; ?></option>
                <?php
                }
                ?>
            </select>
        </div>
        </div>
    
                
                <div class="input-group input-group-lg">
                        <span class="input-group-btn">
                            <span class="btn btn-default">
                                <i class="fa fa-search"></i>
                            </span>
                        </span>
                        <input type="text" id="search_box" name="search_speciality" class="form-control" placeholder="<?= $lang['search_freelancer'] ?? '' ?>" value="<?= $_POST['search_speciality'] ?? ''; ?>" required>
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-filter"></i>
                                &nbsp;&nbsp;<?= $lang['filter']; ?>&nbsp;
                                <span class="caret"></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="pad-5">




                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="search_price"><?= $lang['price'] ?></label>
                                            <input type="text" class="form-control" id="search_price" name="search_price" value="<?= $_POST['search_price'] ?? ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12 pad-btm border-bottom">
                                        <div class="form-group">
                                            <label for="search_work_exp"><?= $lang['year_exp'] ?></label>
                                            <input type="text" class="form-control" id="search_work_exp" name="search_work_exp" value="<?= $_POST['search_work_exp'] ?? ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12 pad-top">
                                        <div class="form-group">
                                            <button class="btn btn-success filter_data" type="submit"><?= $lang['done']; ?></button>
                                            <button class="btn btn-default filter_clear" type="button"><?= $lang['cancel']; ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form> -->


                <div>
                    <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" id="freelancer_search_form">

                        <div class="form-group">
                            <label for="job_title"><?= $lang['job_title'] ?> </label>
                            <select name="job_title" class="form-control select_job" required>
                                <option value=""><?= $lang['select_option'] ?></option>
                                <?php
                                foreach ($specialities as $specialityID => $value) {
                                ?>
                                    <option value="<?= $value[$_SESSION['site_lang'] . '_Title']; ?>"><?= $value[$_SESSION['site_lang'] . '_Title']; ?></option> <?php
                                                                                                                                                                }
                                                                                                                                                                    ?>
                            </select>
                        </div>

                        <button class="btn btn-success register_button" type="submit" name="submit_freelancer"><i class="fa fa-save"></i> Search</button>
                    </form>
                </div>


            </div>
            <div class="col-md-1"></div>
        </div>
        <br />
        <?php
        if ($is_search) {
        ?>
            <div class="row">
                <table id="example1" class="cell-border example1 table table-striped table1 delSelTable">
                    <thead>
                        <tr>
                            <th><?php echo $lang['id']; ?></th>
                            <th><?php echo $lang['name']; ?></th>
                            <th><?php echo $lang['email']; ?></th>

                            <th><?php echo isset($lang['gender']) ? $lang['gender'] : 'النوع'; ?></th>
                            <th><?php echo isset($lang['nationality']) ? $lang['nationality'] : 'الجنسية'; ?></th>
                            <th><?php echo isset($lang['job_title']) ? $lang['job_title'] : 'تخصص'; ?></th>
                            <th><?php echo isset($lang['working_type']) ? $lang['working_type'] : 'نوع العمل'; ?></th>
                            <th><?php echo isset($lang['account_type']) ? $lang['account_type'] : 'نوع الحساب'; ?></th>
                            <th><?php echo isset($lang['experience_years']) ? $lang['experience_years'] : 'الخبرات'; ?></th>
                            <th><?php echo isset($lang['experiences']) ? $lang['experiences'] : 'سنوات الخبرة'; ?></th>


                            <th width="20%"><?php echo $lang['action']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (is_array($freelancers)) {
                            foreach ($freelancers as $freelancer) { ?>
                                <tr>
                                    <td>
                                        <?php echo $freelancer['employee_id']; ?>
                                    </td>
                                    <td>
                                        <?php echo $freelancer['emp_name'] . " " . $freelancer['emp_surname']; ?>
                                    </td>
                                    <td>
                                        <?php echo $freelancer['email']; ?>
                                    </td>
                                    <td>
                                        <?php echo $freelancer['gender'] == 'm' ?
                                            'ذكر'
                                            : 'انثى '; ?>
                                    </td>
                                    <td>
                                        <?php echo $freelancer['nationality']; ?>
                                    </td>
                                    <td>
                                        <?php echo $freelancer['job_title']; ?>
                                    </td>
                                    <td>
                                        <?php echo $freelancer['working_type'] == 'a' ?
                                            'حضور'
                                            : 'عن بعد'; ?>
                                    </td>
                                    <td>
                                        <?php echo $freelancer['account_type'] == 'r' ? 'طالب خدمة' :
                                            'مقدم خدمة'; ?>

                                    </td>
                                    <td>
                                        <?php
                                        if ($freelancer['experience_years'] == 'b') {
                                            echo 'مبتدا';
                                        } else if ($freelancer['experience_years'] == 'i') {
                                            echo 'متمرس';
                                        } else {
                                            echo 'متمكن';
                                        }; ?>

                                    </td>
                                    <td>
                                        <?php echo $freelancer['experiences']; ?>
                                    </td>
                                    <td style="display: flex; justify-content: flex-start;align-items: center;">
                                        <!-- <a href="<?php echo $link->link("edit_freelancer", frontend, '&edit=' . $freelancer['employee_id']); ?>" class="btn btn-success fa fa-edit"></a> -->

                                        <form method="post" action="<?= $link->link("edit_freelancer", frontend) ?>">
                                            <input type="hidden" name="edit" value="<?= $freelancer['employee_id'] ?>">
                                            <button type="submit" class="btn btn-success fa fa-edit" style="margin: 3px;"></button>
                                        </form>


                                        <form action="" method="post">
                                            <input type="hidden" name="del_id" value="<?php echo $freelancer['employee_id']; ?>">
                                            <button class="btn btn-danger fa fa-trash" style="margin: 3px;" type="submit" name="del"></button>
                                        </form>


                                        <!-- <a title="<?php echo $lang['add_contract']; ?>" href="<?php echo $link->link('add_contract', frontend, '&employee_id=' . $freelancer['employee_id']); ?>" class="btn btn-primary fa fa-plus"></a> -->

                                        <form method="post" action="<?= $link->link('add_contract', frontend) ?>">
                                            <input type="hidden" name="employee_id" value="<?= $freelancer['employee_id'] ?>">
                                            <button type="submit" class="btn btn-primary fa fa-plus" style="margin: 3px;"></button>
                                        </form>


                                        <?php
                                        if ($freelancer['status'] != 0) { ?>
                                            <form action="" method="post">
                                                <input type="hidden" name="activate_id" value="<?php echo $freelancer['employee_id']; ?>">
                                                <button class="btn btn-warning " type="submit" name="activateid" style="margin: 3px; padding-top: 3px;padding-bottom: 3px;"><?php echo $lang['activate']; ?></button>
                                            </form>

                                        <?php } else { ?>

                                            <form action="" method="post">
                                                <input type="hidden" name="deactivate_id" value="<?php echo $freelancer['employee_id']; ?>">
                                                <button class="btn btn-warning" type="submit" name="deactivateid" style="margin: 3px; padding-top: 3px;padding-bottom: 3px;"><?php echo $lang['deactivate']; ?></button>
                                            </form>


                                        <?php }
                                        ?>



                                    </td>

                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        <?php
        }
        ?>
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