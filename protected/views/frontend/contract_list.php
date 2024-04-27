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
      
     <!-- start MRN integrated contract list  -->
     <div id="page-content">
        <div class="panel">
            <?php echo $display_msg ?? ''; ?>
            <div class="panel-heading">
                <h3 class="panel-title">MRN integrated contract list 
                    <?php if (in_array($_SESSION['department'], array(5))) { ?>
                        <span class="pull-right">
                        </span>
                    <?php } ?>
                </h3>

            </div>
            <div class="panel-body">
                <?php 
                if (isset($contract_list_api) && !empty($contract_list_api) && count($contract_list_api) > 0) { 
                    foreach ($contract_list_api as $key => $value) {
                        if($key !== 'meta'){ //pagination
                        if (is_array($value) && !empty($value)) {
                            foreach ($value as $sub_key => $sub_value) {
                                if (is_array($sub_value) && !empty($sub_value)) {  
                                    ?>
                                <table id="contract_table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="min-tablet" colspan="4" style="background: #f6f6f6;text-align:center;border-top: 1px solid #eeeeee;padding:2%;"><?php echo "Contract number: " .$sub_value['number']; ?>
                                            <div class="hidden">
                                                <input type="hidden" name="number" value="<?= $sub_value['number']; ?>">
                                            </div>
                                            <span style="float:right;"><a href="<?php echo $link->link("show_contract", frontend, '&number=' . $sub_value['number']); ?>" class="btn btn-primary">Show contract</a></span>
                                        <tr>
                                            <th class="min-tablet" colspan="1" style="text-align:center;padding:2%;"><?php echo "Employee info"; ?></th>
                                            <th class="min-tablet" colspan="2" style="text-align:center;padding:2%;"><?php echo "Contract info"; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><?php echo $lang['employee_name'] .": ". $sub_value['employee_name'];  ?></td>
                                        <td><?php echo $lang['contract_state'] .": ". $sub_value['state'];   ?></td>
                                        <td><?php echo $lang['created_at'] .": ". $sub_value['created_at'];  ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $lang['employee_national_number'] .": ". $sub_value['national_number'];   ?></td>
                                        <td><?php echo $lang['start_date'] .": ". $sub_value['start_date'];  ?></td>
                                        <td><?php echo $lang['end_date'] .": ". $sub_value['end_date'];   ?></td>
                                    </tr>
                                    <tr>
                                    <?php
                                        if ($_SESSION['site_lang'] == 'Arabic'){
                                            ?>
                                            <td><?php echo $lang['city'] .": ". $sub_value['location']['ar_name']; ?></td>
                                            <?php
                                        }else{
                                            ?>
                                            <td><?php echo $lang['city'] .": ". $sub_value['location']['en_name']; ?></td>
                                            <?php
                                        }
                                        ?>
                                        <td><?php echo $lang['hourly_rate'] .": ". $sub_value['hourly_rate'];  ?></td>
                                        <td><?php echo $lang['total_rate'] .": ". $sub_value['total_rate'];   ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><?php echo $lang['job_title'] .": ". $sub_value['job_title'];   ?></td>
                                        <?php
                                        if ($_SESSION['site_lang'] == 'Arabic'){
                                        ?>
                                        <td><?php echo $lang['gosi_job_title'] .": ". $sub_value['gosi_job_title']['ar_name'];   ?></td>
                                        <?php
                                        }else{
                                        ?>
                                        <td><?php echo $lang['gosi_job_title'] .": ". $sub_value['gosi_job_title']['en_name']; ?></td>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><?php echo $lang['employer_name'] .": ". $sub_value['employer_name'];   ?></td>
                                        <td><?php echo $lang['service_provider'] .": ". $sub_value['service_provider'];   ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="2"><?php echo $lang['total_working_hours'] .": ". $sub_value['total_working_hours'];?></td>
                                    </tr>
                                </tbody>
                            </table>
                                    <?php
                                }
                            }
                        }
                        }else{
                            foreach ($value as $sub_key => $sub_value) {
                                // echo $sub_key. ' ' .$sub_value;
                                if($sub_key == 'pagination'){
                                    foreach ($sub_value as $k => $v) {
                                        // echo '<pre>'.$sub_k. ' ' .$sub_v;
                                        ?>
                                        <!-- <div class="col-md-4"><?php echo $k; ?> : </div> -->
                                        <!-- <div class="col-md-8"><?php echo $v; ?></div> -->
                                    <?php
                                    }
                                }
                            }
                        }
                        ?>
                <?php
                    }
                } ?>
            </div>
        </div>
    </div>
    <!-- end MRN integrated contract list   -->
</div>