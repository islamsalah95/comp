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



    <div id="page-content">
        <div class="panel">
            <?php echo $display_msg ?? '' ?>
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo $lang['contracts']; ?>
                    <?php if (in_array($_SESSION['department'], array(5))) { ?>
                        <span class="pull-right">
                            <!-- <a class="btn btn-primary" href="<?php echo $link->link('add_contract', frontend, '&employee_id=' . $employee_id); ?>"><i class="fa fa-plus"></i> <?php echo $lang['add_contract']; ?></a> -->
                        </span>
                        <!-- add button -->
                        <div class="pull-right">
                            <a href="<?php echo $link->link("contract_list", frontend); ?>" class="btn btn-primary" title="MRN integrated contracts">Contract list</a>
                        </div>
                    <?php } ?>
                </h3>

            </div>
            <div class="panel-body">
                <table id="contract_table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="min-tablet" width="10%"><?php echo $lang['start_date']; ?></th>
                            <th class="min-tablet" width="10%"><?php echo $lang['end_date']; ?></th>
                            <th class="min-tablet" width="5%"> <?php echo $lang['company']; ?></th>
                            <th class="min-tablet" width="20%"> <?php echo $lang['job_title']; ?></th>
                            <th class="min-tablet" width="20%"> <?php echo $lang['employee_name']; ?></th>
                            <th class="min-tablet" width="20%"> <?php echo $lang['employee_national_number']; ?></th>
                            <th class="min-tablet" width="10%"> <?php echo $lang['hour_rate']; ?></th>
                            <th class="min-tablet" width="20%"> <?php echo $lang['approved_hours']; ?> </th>
                            <th class="text-right"> <?php echo $lang['compute_wages']; ?> </th>

                            <!-- add contract status -->
                            <!--<th class="min-tablet" width="10%"> <?php echo $lang['contract_status']; ?></th>-->
                            <th width="8%"> <?php echo $lang['action']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (is_array($contracts) && count($contracts) > 0) {
                            foreach ($contracts as $contract) { ?>
                                <tr>
                                    <td><?php echo $contract['start_date']; ?></td>
                                    <td><?php echo $contract['end_date']; ?></td>
                                    <td><?php echo $contract['company_name']; ?></td>
                                    <td><?php echo $contract['job_title']; ?></td>
                                    <td><?php echo $contract['employee_name']; ?></td>
                                    <td><?php echo $contract['employee_national_number']; ?></td>
                                    <td class="text-right"><?php echo $contract['hourly_rate']; ?></td>
                                    <td class="text-right"><?php echo sec2hms_new($contract['approved_time']); ?></td>
                                    <td class="text-right">
                                        <?php
                                        $contract['hourly_rate'] = $contract['hourly_rate'] ?? 0;
                                        $compute_wages = 0;
                                        if ($contract['hourly_rate'] != '' && $contract['hourly_rate'] > 0) {
                                            $compute_wages =  $contract['approved_time'] * ($contract['hourly_rate'] / 3600);
                                        }
                                        echo number_format((float)$compute_wages, 2) . "SR";
                                        ?>
                                    </td>
                                    <!--<td><?php echo $contract['state']; ?></td>-->
                                    <!-- contract actions -->
                                    <td>
                                        <!-- <a href="<?php echo $link->link("view_contract", frontend, '&contract_id=' . $contract['id']); ?>" class="btn btn-success fa fa-eye" title="View add contract status"></a> -->

                                        <form method="post" action="<?= $link->link('view_contract', frontend) ?>">
                                            <input type="hidden" name="contract_id" value="<?= $contract['id'] ?>">
                                            <button type="submit" class="btn btn-success fa fa-eye"></button>
                                        </form>


                                    </td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#contract_table').DataTable({
            "oLanguage": {
                'sUrl': '//cdn.datatables.net/plug-ins/1.10.19/i18n/<?php echo $_SESSION['site_lang']; ?>.json'
            }
        });
    });
</script>