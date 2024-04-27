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
        <h3><i class="fa fa-home"></i><?php echo $lang['contract'] . ' ' . $lang['status']; ?></h3>
        <div class="breadcrumb-wrapper">
            <span class="label"><?php echo $lang['you_are_here']; ?>:</span>
            <ol class="breadcrumb">
                <li> <a href="<?php echo $link->link('home', frontend); ?>"> <?php echo $lang['dashboard']; ?> </a> </li>
                <li> <a href="<?php echo $link->link('contracts', frontend); ?>"><?php echo $lang['contracts']; ?> </a> </li>
                <li class="active"><?php echo $lang['contract'] . ' ' . $lang['status']; ?></li>
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
                        <h3 class="panel-title"><?php echo $lang['contract'] . ' ' . $lang['status']; ?></h3>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <?php
                            if (isset($contract_status) && !empty($contract_status)) {
                                foreach ($contract_status as $key => $value) {
                                    if (is_array($value) && !empty($value)) {
                                        foreach ($value as $sub_key => $sub_value) {
                                            if (is_array($value) && !empty($value)) {
                                                ?>
                                                <b><div class="col-md-12 border-top border-bottom"><?php echo $sub_key; ?></div></b>
                                                <?php
                                                foreach ($sub_value as $k => $v) {
                                                ?>
                                                    <div class="col-md-4"><?php echo $k; ?> : </div>
                                                    <div class="col-md-8"><?php echo $v; ?></div>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <b><div class="col-md-12 border-top border-bottom"><?php echo $key; ?></div></b>
                                                <div class="col-md-4"><?php echo $sub_key; ?> : </div>
                                                <div class="col-md-8"><?php echo $sub_value; ?></div>
                                        <?php
                                            }
                                        }
                                    } else {
                                        ?>
                                        <div class="col-md-4"><?php echo $key; ?> : </div>
                                        <div class="col-md-8"><?php echo $value; ?></div>
                                        <br>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>