<div id="content-container">
    <div class="pageheader">
        <h3><i><img src="uploads/logo/company_icons/jobs_icon-01.png" style="width:40px;height:40px;margin:0 10px;"></i><?php echo $lang['list_previous_jobs']; ?></h3>
        <div class="breadcrumb-wrapper">
            <span class="label"><?php echo $lang['you_are_here']; ?>:</span>
            <ol class="breadcrumb">
                <li class="active"><?php echo $lang['list_previous_jobs']; ?></li>
            </ol>
        </div>
    </div>






    <div id="page-content">
        <div class="panel">
            <?php echo $display_msg ?? ''; ?>
            <div class="panel-body">

                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center">Jobs Evaluation</h3>
                    </div>
                    <?php
                      if (isset($previous_jobsArray) && count($previous_jobsArray) > 0) {
                        foreach ($previous_jobsArray as $job) {
                    ?>
                            <div class="col-md-4">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <b><?= $lang['project'] ?></b>: <?= $job['project_name']; ?>
                                            </div>
                                            <div class="col-md-12">
                                                <b><?= $lang['tasks'] ?></b>:
                                                <?php
                                                if ($job['task_name'] !== null) {
                                                    echo str_replace(',', '<br>', $job['task_name']);
                                                } else {
                                                    echo "No task name available";
                                                }
                                                ?>
                                            </div>
                                            <div class="col-md-6">
                                                <b><?= $lang['job_title'] ?></b>: <?= $job['title']; ?>
                                            </div>
                                            <div class="col-md-6">
                                                <b><?= $lang['working_hours'] ?></b>: <?php if ($job['working_hours'] != '') echo gmdate("H:i:s", $job['working_hours']); ?>
                                            </div>
                                            <div class="col-md-12">
                                                <b><?= $lang['company_name'] ?></b>: <?= $job['company_name']; ?>
                                            </div>
                                            <div class="col-md-12">
                                                <b>Evaluation</b>:
                                                <?php
                                                for ($i = 1; $i <= 5; $i++) {
                                                    $star_color = '#d5d5d5d';
                                                    $start_class = 'fa fa-star-o fa-lg';
                                                    if ($job['rating'] != '' && $job['rating'] >= $i) {
                                                        $star_color = '#ff7501';
                                                        $start_class = 'fa fa-star fa-lg ' . $i;
                                                    }
                                                ?>
                                                    <i class="<?= $start_class; ?>" style="color: <?= $star_color; ?>;"></i>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } ?>
                </div>




                <?php if (in_array($_SESSION['department'], array(1, 4, 5))) { ?>
                    <div class="row">
                        <div id="page-content">
                            <div class="panel">
                                <?php echo $display_msg ?? ''; ?>
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo $lang['list_previous_jobs']; ?>
                                    </h3>

                                </div>
                                <div class="panel-body">
                                    <table id="contract_table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="min-tablet" width="5%"> انشاء </th>
                                                <th class="min-tablet" width="5%"> ناريخ البداية</th>
                                                <th class="min-tablet" width="5%"> ناريخ النهاية</th>
                                                <th class="min-tablet" width="20%"> <?php echo $lang['job_title']; ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($contracts)) {

                                                if (is_array($contracts) && count($contracts) > 0) {
                                                    foreach ($contracts as $contract) { ?>
                                                        <tr>
                                                            <td><?php echo $contract['start_date']; ?></td>
                                                            <td><?php echo $contract['end_date']; ?></td>
                                                            <td><?php echo $contract['created_on']; ?></td>
                                                            <td><?php echo $contract['job_title']; ?></td>
                                                            <td>

                                                                <form method="post" action="<?= $link->link('view_contract', frontend) ?>">
                                                                    <input type="hidden" name="contract_id" value="<?= $contract['id'] ?>">
                                                                    <button type="submit" class="btn btn-success fa fa-eye"></button>
                                                                </form>

                                                            </td>

                                                        </tr>
                                            <?php }
                                                }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>


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