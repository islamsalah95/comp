<div id="content-container">
    <div class="pageheader hidden-xs">
        <h3><i class="fa fa-home"></i><?php echo $lang['view_cancel_contract']; ?></h3>
        <div class="breadcrumb-wrapper">
            <span class="label"><?php echo $lang['you_are_here']; ?>:</span>
            <ol class="breadcrumb">
                <li> <a href="<?php echo $link->link('home', frontend); ?>"> <?php echo $lang['dashboard']; ?> </a> </li>
                <li> <a href="<?php echo $link->link('contracts', frontend); ?>"><?php echo $lang['contracts']; ?> </a> </li>
                <li class="active"><?php echo $lang['view_cancel_contract']; ?></li>
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
                        <h3 class="panel-title"><?php echo $lang['view_cancel_contract']; ?></h3>
                    </div>
                    <form method="post" action="<?php echo $link->link("view_cancel_contract", frontend, '&number=' . $number); ?>" id="contract_form">
                   
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cancellation_reason"><?= $lang['cancellation_reason'] ?> : </label>
                                        <span class="form-control"><?= $contract['cancellation_reason']; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="comment"><?= $lang['comment'] ?> : </label>
                                        <span class="form-control"><?= $contract['comment']; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="actual_worked_hours_at_cancellation"><?= $lang['actual_worked_hours_at_cancellation'] ?> : </label>
                                        <span class="form-control"><?= $contract['actual_worked_hours_at_cancellation']; ?></span>
                                    </div>
                                    <!--  integration status -->
                                    <div class="form-group">
                                        <label for="cancel_status"><?= $lang['status'] ?> : </label>
                                        <span class="form-control">
                                            <?php
                                            if ($contract['cancel_status'] != 0) {
                                                echo $lang['integrated'] ." , ". $lang['reference_number'] .": ". $contract['cancel_reference_number'];
                                            } else {
                                                echo $lang['not_integrated'];
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-footer text-center">
                             <a class="btn btn-warning" href="<?php echo $link->link('show_contract', frontend, '&number=' . $number); ?>"><i class="fa fa-times"></i> <?php echo $lang['go_back']; ?></a>
                            <?php
                            if ($contract['cancel_reference_number'] == '') {
                            ?>
                                <button class="btn btn-success" type="submit" name="integrate_contract"><i class="fa fa-save"></i> <?php echo $lang['integrate']; ?></button>
                            <?php
                            } else { ?>
                                <a class="btn btn-primary" href="<?php echo $link->link('status_contract', frontend, '&ref_num=' . $contract['cancel_reference_number']); ?>"><i class="fa fa-eye"></i> <?php echo $lang['status']; ?></a>
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