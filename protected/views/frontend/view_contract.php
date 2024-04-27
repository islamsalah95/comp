<style>
    #contract_form .chosen-container {
        margin-bottom: 0px;
    }
</style>
<link href="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-hijridate/css/bootstrap-datetimepicker.min.css'; ?>" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
<script src="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-hijridate/js/bootstrap-hijri-datetimepicker.min.js'; ?>"></script>
<div id="content-container">
    <div class="pageheader hidden-xs">
        <h3><i class="fa fa-home"></i><?php echo $lang['view_contract']; ?></h3>
        <div class="breadcrumb-wrapper">
            <span class="label"><?php echo $lang['you_are_here']; ?>:</span>
            <ol class="breadcrumb">
                <li> <a href="<?php echo $link->link('home', frontend); ?>"> <?php echo $lang['dashboard']; ?> </a> </li>
                <li> <a href="<?php echo $link->link('contracts', frontend); ?>"><?php echo $lang['contracts']; ?> </a> </li>
                <li class="active"><?php echo $lang['view_contract']; ?></li>
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
                        <h3 class="panel-title"><?php echo $lang['view_contract']; ?></h3>
                    </div>
                    <!-- <form method="post" action="<?php echo $link->link("view_contract", frontend, '&contract_id=' . $contract_id); ?>" id="contract_form"> -->
                    <form method="post" action="<?php echo $link->link("view_contract", frontend); ?>" id="contract_form">
                    <input type="hidden" name="contract_id" value="<?= $contract_id ?>">  
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_date"><?= $lang['start_date'] ?> : </label>
                                        <span class="form-control"><?= $contract['start_date']; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="end_date"><?= $lang['end_date'] ?> : </label>
                                        <span class="form-control"><?= $contract['end_date']; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="job_title"><?= $lang['job_title'] ?> : </label>
                                        <span class="form-control"><?= $contract['job_title']; ?></span>
                                    </div>

                                    <div class="form-group">
                                        <div class="text-left">
                                            <label class="text-muted"><?php echo $lang['EstLaborOfficeId']; ?></label>
                                            <input class="form-control" type="text" placeholder="<?php echo $lang['enter_your_EstLaborOfficId']; ?> *" name="EstLaborOfficeId" value="<?php echo $contract['EstLaborOfficeId']; ?>" required="required">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="text-left">
                                            <label class="text-muted"><?php echo $lang['EstSequenceNumber']; ?></label>
                                            <input class="form-control" type="text" placeholder="<?php echo $lang['enter_your_EstSequenceNumber']; ?> *" name="EstSequenceNumber" value="<?php echo $contract['EstSequenceNumber']; ?>" required="required">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="status"><?= $lang['status'] ?> : </label>
                                        <span class="form-control">
                                            <?php
                                            if ($contract['status'] != 0) {
                                                echo $lang['integrated'] . ' - ' . $contract['reference_number'];
                                            } else {
                                                echo $lang['not_integrated'] . '  ' . $contract['message'];
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hourly_rate"><?= $lang['hour_rate'] ?> : <span class="text-xs">(<?= $lang['hour_rate_limit']; ?>)</span></label>
                                        <span class="form-control"><?= $contract['hourly_rate']; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="working_hours_per_day"><?= $lang['work_hr_day'] ?>: <span class="text-xs">(<?= $lang['work_hr_day_limit']; ?>)</span></label>
                                        <span class="form-control"><?= $contract['working_hours_per_day']; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="working_hours_per_week"><?= $lang['work_hr_week'] ?>: <span class="text-xs">(<?= $lang['work_hr_week_limit']; ?>)</span></label>
                                        <span class="form-control"><?= $contract['working_hours_per_week']; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="working_hours"><?= $lang['work_hr_total'] ?>: <span class="text-xs">(<?= $lang['work_hr_total_limit']; ?>)</span></label>
                                        <span class="form-control"><?= $contract['working_hours']; ?></span>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label"><?php echo $lang['is_mol_TWC']; ?></label>
                                        <select class="form-control " name="is_molTWC">
                                            <option value="0" <?php if ($contract['is_molTWC'] == 0) echo "selected"; ?>><?php echo $lang['no']; ?></option>
                                            <option value="1" <?php if ($contract['is_molTWC'] == 1) echo "selected"; ?>><?php echo $lang['yes']; ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="hidden">
                            <input type="hidden" name="cid" value="<?= $contract_id; ?>">
                        </div>

                        <div class="panel-footer text-center">
                            <!-- <a class="btn btn-warning" href="<?php echo $link->link('contracts', frontend, '&employee_id=' . $contract['employee_id']); ?>"><i class="fa fa-times"></i> <?php echo $lang['go_back']; ?></a> -->

                            <button class="btn btn-warning" onclick="goBack()"><i class="fa fa-times"> </i><?php echo $lang['go_back']; ?></button>



                            <?php
                            if ($contract['reference_number'] == '') {
                            ?>
                                <button class="btn btn-success" type="submit" name="integrate_contract"><i class="fa fa-save"></i> <?php echo $lang['integrate']; ?></button>
                            <?php
                            } else { ?>
                                <!-- <a class="btn btn-primary" href="<?php echo $link->link('status_contract', frontend, '&ref_num=' . $contract['reference_number'] . '&contract_id=' . $contract_id); ?>"><i class="fa fa-eye"></i> <?php echo $lang['status']; ?></a> -->

                                <!-- <button class="btn btn-primary" onclick="<?php echo $link->link('status_contract', frontend, '&ref_num=' . $contract['reference_number'] . '&contract_id=' . $contract_id); ?>"><i class="fa fa-eye"></i> <?php echo $lang['status']; ?></button> -->
                               
                                <form method="get" action="<?php echo $link->link('status_contract', frontend); ?>">
                                    <input type="hidden" name="ref_num" value="<?php echo $contract['reference_number']; ?>">
                                    <input type="hidden" name="contract_id" value="<?php echo $contract_id; ?>">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-eye"></i> <?php echo $lang['status']; ?>
                                    </button>
                                </form>

                            <?php
                            }
                            ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {});
</script>