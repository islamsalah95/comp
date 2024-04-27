<div id="content-container">
    <div class="pageheader hidden-xs">
        <h3><i class="fa fa-home"></i><?php echo $lang['cancel_contract']; ?></h3>
        <div class="breadcrumb-wrapper">
            <span class="label"><?php echo $lang['you_are_here']; ?>:</span>
            <ol class="breadcrumb">
                <li> <a href="<?php echo $link->link('home', frontend); ?>"> <?php echo $lang['dashboard']; ?> </a> </li>
                <li> <a href="<?php echo $link->link('contracts', frontend); ?>"><?php echo $lang['contracts']; ?> </a> </li>
                <li class="active"><?php echo $lang['cancel_contract']; ?></li>
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
                        <h3 class="panel-title"><?php echo $lang['cancel_contract']; ?></h3>
                    </div>
                    <form method="post" action="<?php echo $link->link("cancel_contract", frontend, '&number=' . $number); ?>" id="contract_form">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cancellation_reason_id"><?= $lang['cancellation_reason'] ?> : </label>
                                        <select name="cancellation_reason_id" class="form-control select_cancel_reasons cancellation_reason_id" required>
                                            <option value=""><?= $lang['select_option'] ?></option>
                                            <?php
                                            foreach ($cancel_reasons as $cancel_reasonsID => $cancel_reasons) {
                                            ?>
                                                <option value="<?= $cancel_reasonsID; ?>"><?= $cancel_reasons[$_SESSION['site_lang'] . '_name']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div class="text-left">
                                            <label class="text-muted"><?php echo $lang['comment']; ?></label>
                                            <input class="form-control" type="text" placeholder="<?php echo $lang['comment']; ?>" name="comment" value="<?php echo $contract['comment']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="text-left">
                                            <label class="text-muted"><?php echo $lang['actual_worked_hours_at_cancellation']; ?></label>
                                            <input class="form-control actual_worked_hours_at_cancellation" type="number" placeholder="<?php echo $lang['actual_worked_hours_at_cancellation']; ?> *" name="actual_worked_hours_at_cancellation" value="<?php echo $contract['actual_worked_hours_at_cancellation']; ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-footer text-center">
                            <a class="btn btn-warning" href="<?php echo $link->link('show_contract', frontend, '&number=' . $number); ?>"><i class="fa fa-times"></i> <?php echo $lang['go_back']; ?></a>
                            <button class="btn btn-success cancel_contract" type="submit" name="cancel_contract"><i></i> <?php echo $lang['cancel_contract']; ?></button>
                        </div>        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
// echo "<pre>"; print_r($contracts); exit();
?>
<script>
    $(document).ready(function() {
        $('.select_cancel_reasons').chosen();
        $('#contract_form').submit(function(e) {
            // e.preventDefault();
            var cancellation_reason_id = $(".cancellation_reason_id").val();
            var actual_worked_hours_at_cancellation = $(".actual_worked_hours_at_cancellation").val();
            if (cancellation_reason_id == '' || actual_worked_hours_at_cancellation == '' ) {
                alert("Please fill all details");
                return false;
            }
        });
    });
</script>