<style>
    #contract_form .chosen-container {
        margin-bottom: 0px;
    }
</style>
<!-- <link href="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-hijridate/css/bootstrap-datetimepicker.min.css'; ?>" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
<script src="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-hijridate/js/bootstrap-hijri-datetimepicker.min.js'; ?>"></script> -->
<div id="content-container">
    <div class="pageheader hidden-xs">
        <h3><i class="fa fa-home"></i><?php echo $lang['add_contract']; ?></h3>
        <div class="breadcrumb-wrapper">
            <span class="label"><?php echo $lang['you_are_here']; ?>:</span>
            <ol class="breadcrumb">
                <li> <a href="<?php echo $link->link('home', frontend); ?>"> <?php echo $lang['dashboard']; ?> </a> </li>
                <li> <a href="<?php echo $link->link('contracts', frontend); ?>"><?php echo $lang['contracts']; ?> </a> </li>
                <li class="active"><?php echo $lang['add_contract']; ?></li>
            </ol>
        </div>
    </div>
    <div id="page-content">
        <div class="row">
            <?php echo $display_msg ?? ''; ?>
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="panel-control">
                            <button class="btn btn-default" onclick="goBack()"><i class="fa fa-arrow-circle-left"></i> <?php echo $lang['go_back']; ?></button>
                        </div>
                        <h3 class="panel-title"><?php echo $lang['add_contract']; ?></h3>
                    </div>


                    <form method="post" action="<?php echo $link->link("add_contract", frontend); ?>" id="contract_form">
                    <input type="hidden" name="employee_id" value="<?= $eid ?>">

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_date"><?= $lang['start_date'] ?> : </label>
                                        <input type="text" name="start_date" class="datepicker2 form-control" id="start_date" required placeholder="yyyy-mm-dd">
                                    </div>
                                    <div class="form-group">
                                        <label for="end_date"><?= $lang['end_date'] ?> : </label>
                                        <input type="text" name="end_date" class="datepicker2 form-control" id="end_date" required placeholder="yyyy-mm-dd">
                                    </div>
                                    <div class="form-group">
                                        <label for="job_title"><?= $lang['job_title'] ?> : </label>
                                        <select name="job_title" class="form-control select_job" required>
                                            <option value=""><?= $lang['select_option'] ?></option>
                                            <?php
                                            foreach ($specialities as $specialityID => $speciality) {
                                            ?>
                                                <option value="<?= $specialityID; ?>"><?= $speciality[$_SESSION['site_lang'] . '_Title']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label for="city_id"><?= $lang['city'] ?> : </label>
                                        <select name="city_id" class="form-control select_city" required>
                                            <option value=""><?= $lang['select_option'] ?></option>
                                            <?php
                                            foreach ($cities as $city_id => $city) {
                                            ?>
                                                <option value="<?= $city_id; ?>"><?= $city['Arabic_Name']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div> -->

                                    <div class="form-group">
                                        <div class="text-left">
                                            <label class="text-muted"><?php echo $lang['EstLaborOfficeId']; ?></label>
                                            <input class="form-control" type="text" placeholder="<?php echo $lang['enter_your_EstLaborOfficId']; ?> *" name="EstLaborOfficeId" required="required">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="text-left">
                                            <label class="text-muted"><?php echo $lang['EstSequenceNumber']; ?></label>
                                            <input class="form-control" type="text" placeholder="<?php echo $lang['enter_your_EstSequenceNumber']; ?> *" name="EstSequenceNumber" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hourly_rate"><?= $lang['hour_rate'] ?> : <span class="text-xs">(<?= $lang['hour_rate_limit']; ?>)</span></label>
                                        <input type="text" name="hourly_rate" class="form-control hourly_rate" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="working_hours_per_day"><?= $lang['work_hr_day'] ?>: <span class="text-xs">(<?= $lang['work_hr_day_limit']; ?>)</span></label>
                                        <input type="text" name="working_hours_per_day" class="form-control working_hours_per_day">
                                    </div>
                                    <div class="form-group">
                                        <label for="working_hours_per_week"><?= $lang['work_hr_week'] ?>: <span class="text-xs">(<?= $lang['work_hr_week_limit']; ?>)</span></label>
                                        <input type="text" name="working_hours_per_week" class="form-control working_hours_per_week" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="working_hours"><?= $lang['work_hr_total'] ?>: <span class="text-xs">(<?= $lang['work_hr_total_limit']; ?>)</span></label>
                                        <input type="text" name="working_hours" class="form-control working_hours" required>
                                    </div>

                                    <div class="form-group">
                                        <div><label class="text-muted"><?php echo 'يتبع العمل مرن'; ?> </label></div>
                                        <ul class="list-inline">
                                            <li class="mar-btm">
                                                <select name="is_molTWC" class="form-control " id="allowed">
                                                    <option value="0"><?php echo $lang['no']; ?></option>
                                                    <option value="1"><?php echo $lang['yes']; ?></option>
                                                </select>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="hidden">
                            <input type="hidden" name="eid" value="<?= $eid; ?>">
                        </div>

                        <div class="panel-footer text-center">
                            <a class="btn btn-warning" href="<?php echo $link->link('contracts', frontend, '&employee_id=' . $eid); ?>"><i class="fa fa-times"></i> <?php echo $lang['cancel']; ?></a>
                            <button class="btn btn-success submit_contract" type="submit" name="submit_contract"><i class="fa fa-save"></i> <?php echo $lang['submit']; ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select_job').chosen();
        $('.select_city').chosen();
        $('#contract_form').submit(function(e) {
            // e.preventDefault();
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();
            var hourly_rate = $(".hourly_rate").val();
            var working_hours_per_week = $(".working_hours_per_week").val();
            var working_hours = $(".working_hours").val();
            var working_hours_per_day = $(".working_hours_per_day").val();
            if (start_date == '' || end_date == '' || hourly_rate == '' || working_hours_per_week == '' || working_hours == '') {
                alert("Please fill all details");
                return false;
            }

            if (hourly_rate < 25) {
                alert("Hourly rate minimum value is 25");
                return false;
            }

            if (working_hours_per_day > 12) {
                alert("Working hours per day maximum value is 12");
                return false;
            }

            if (working_hours_per_week > 24) {
                alert("Working hours per week maximum value is 24");
                return false;
            }

            // var start = moment(start_date, "YYYY-MM-DD");
            // var end = moment(end_date, "YYYY-MM-DD");
            // var daysBetween = moment.duration(end.diff(start)).asDays();
            // var weeksBetween = moment.duration(end.diff(start)).asWeeks();
            // var daysBetween = end.diff(start, 'days') + 1;

            var dayDiff = Math.floor((Date.parse(end_date) - Date.parse(start_date)) / 86400000) + 1;
            // var weekDiff = Math.floor((Date.parse(end_date) - Date.parse(start_date) + 1) / (1000 * 60 * 60 * 24) / 7) + 1;
            var weekDiff = Math.floor((Date.parse(end_date) - Date.parse(start_date)) / (1000 * 60 * 60 * 24) / 7);
            var monthDiff = Math.floor((Date.parse(end_date) - Date.parse(start_date)) / (1000 * 60 * 60 * 24) / (7 * 4));
            var monthCount = (weekDiff) % 4;
            var max_working_hours = 0;
            var min_working_hours = 0;

            if (dayDiff == '' || dayDiff == NaN || dayDiff <= 0) {
                alert("Working hours not valid");
                return false;
            }

            if (dayDiff == 1) {
                max_working_hours = 12;
                min_working_hours = (working_hours_per_week) * 1;
            }
            if (dayDiff == 2) {
                max_working_hours = 24;
                min_working_hours = (working_hours_per_week) * 1;
            } else if (dayDiff > 2 && weekDiff < 4) {
                max_working_hours = (weekDiff + 1) * 24;
                min_working_hours = (weekDiff + 1) * working_hours_per_week;
            } else if (weekDiff >= 4 && monthCount != 0) {
                max_working_hours = weekDiff * 24;
                min_working_hours = weekDiff * working_hours_per_week;
            } else if (weekDiff >= 4 && monthCount == 0) {
                max_working_hours = monthDiff * 95;
                min_working_hours = weekDiff * working_hours_per_week;
            }

            if (working_hours < min_working_hours || working_hours > max_working_hours) {
                alert("Working hours should be between " + min_working_hours + " & " + max_working_hours);
                return false;
            }

            // $('#contract_form').submit();
            return true;

        });

        // $("#start_date").hijriDatePicker({
        //     showTodayButton: true,
        //     showClear: true,
        //     hijri: true,
        //     format: 'YYYY-MM-DD'
        // });
        // $("#end_date").hijriDatePicker({
        //     showTodayButton: true,
        //     showClear: true,
        //     hijri: true,
        //     format: 'YYYY-MM-DD'
        // });
    });
</script>