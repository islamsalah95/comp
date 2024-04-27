<div id="content-container">
    <div class="pageheader">
        <h3><i class="fa fa-tags"></i><?php echo $lang['contracts']; ?></h3>
        <div class="breadcrumb-wrapper">
            <span class="label"><?php echo $lang['you_are_here']; ?>:</span>
            <ol class="breadcrumb">
                <li class="active"><?php echo $lang['contracts']; ?></li>
            </ol>
        </div>
    </div>
      
 <!-- start MRN integrated show contract   -->
 <div id="page-content">
    <div class="panel">
        <?php echo $display_msg ?? ''; ?>
        <div class="panel-heading">
            <div class="panel-control">
                <button class="btn btn-default" onclick="goBack()"><i class="fa fa-arrow-circle-left"></i> <?php echo $lang['go_back']; ?></button>
                <!-- contract actions -->
                 <?php
                //  view contract if there is ref_num
                if ($contract['cancel_reference_number'] !== '' && $contract['cancel_reference_number'] > 0) {
                ?>
                    <a href="<?php echo $link->link("view_cancel_contract", frontend, '&ref_num=' . $contract['cancel_reference_number'].'&number=' . $number); ?>" class="btn btn-primary fa fa-eye" title="View cancel contract status"></a> 
                <?php
                // delete contract otherwise
                } elseif ($contract['cancel_reference_number'] == '') { 
                    ?>
                    <a href="<?php echo $link->link("cancel_contract", frontend, '&number=' . $number); ?>" class="btn btn-danger fa fa-trash" title="Cancel contract status"></a> 
                <?php
                }
                ?>
            </div>
            <h3 class="panel-title">MRN integrated show contract
                <?php if (in_array($_SESSION['department'], array(5))) { ?>
                    <span class="pull-right">
                    </span>
                <?php } ?>
            </h3>
        </div>
        <div class="panel-body">
            <table id="contract_table" class="table table-striped table-bordered">
            <?php
                if (isset($contract_show_api) && !empty($contract_show_api)) {
                    foreach ($contract_show_api as $key => $value) {
                        if (is_array($value) && !empty($value)) {
                            foreach ($value as $sub_key => $sub_value) {
                                if (is_array($value) && !empty($value)) {
                                    if ($sub_key == "number"){
                                        $number = $sub_key;
                                    }
                                    ?>
                                    <?php
                                    if  ($_SESSION['site_lang'] == 'Arabic' && $sub_key == "ar_name") {
                                    ?>
                                        <div class="col-md-8"><?php echo $sub_key; ?></div>
                                        <div class="col-md-4"><?php echo $sub_value; ?> : </div>

                                    <?php
                                    }elseif ($_SESSION['site_lang'] == 'English' && $sub_key == "en_name"){
                                        ?>
                                        <div class="col-md-8"><?php echo $sub_key; ?></div>
                                        <div class="col-md-4"><?php echo $sub_value; ?> : </div>
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
                </tbody>
            </table>
            </div>
        </div>
    </div>
    <!-- end MRN integrated show contract  -->
</div>