<div id="content-container">
    <div class="pageheader">
        <h3><i class="fa fa-user-circle-o"></i><?php echo $lang['freelancers']; ?></h3>
        <div class="breadcrumb-wrapper">
            <span class="label"><?php echo $lang['you_are_here']; ?>:</span>
            <ol class="breadcrumb">
                <li> <a href="<?php echo $link->link('home', frontend); ?>"> <?php echo $lang['dashboard']; ?> </a> </li>
                <li class="active"><?php echo $lang['freelancers']; ?></li>
            </ol>
        </div>
    </div>

    <div id="page-content">
        <div class="panel-heading">
            <span class="pull-right">
                <a class="btn btn-primary" href="<?php echo $link->link('add_freelancer', frontend); ?>"><i class="fa fa-plus"></i> <?php echo $lang['add_freelancer']; ?></a>
            </span>
        </div>


        <?php echo $display_msg ?? ''; ?>

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
                                  <?php echo $freelancer['gender']=='m' ? 
                                    'ذكر'
                                    :'انثى ' ; ?>
                                </td>
                                                                <td>
                                    <?php echo $freelancer['nationality']; ?>
                                </td>
                                                                <td>
                                    <?php echo $freelancer['job_title']; ?>
                                </td>
                                                                <td>
                                    <?php echo $freelancer['working_type']=='a' ? 
                                    'حضور'
                                    :'عن بعد' ; ?>
                                </td>
                                                                <td>
                                <?php echo $freelancer['account_type']=='r' ? 'طالب خدمة':
                                'مقدم خدمة' ; ?>

                                </td>
                                                                <td>
                                <?php 
                                if($freelancer['experience_years']=='b'){ echo 'مبتدا';} 
                                else if($freelancer['experience_years']=='i'){ echo 'متمرس';} 
                                 else{
                                    echo 'متمكن';
                                }
                                
                                ; ?>

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
                                        <button class="btn btn-danger fa fa-trash"style="margin: 3px;" type="submit" name="del"></button>
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
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#example1').DataTable({
            // dom: 'lfBrtip',
            "dom": "<'row'<'col-md-4'l><'col-md-8'Bf>>" + "<'row'<'col-md-6'><'col-md-6'>>" + "<'row'<'col-md-12't>><'row'<'col-md-6'i><'col-md-6'p>>",
            buttons: [{
                    extend: 'csv',
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                }
            ],
            "responsive": true,
            "language": {
                "paginate": {
                    "previous": '<i class="fa fa-angle-left"></i>',
                    "next": '<i class="fa fa-angle-right"></i>'
                }
            },
            "iDisplayLength": 10,
            "oLanguage": {
                'sUrl': '//cdn.datatables.net/plug-ins/1.10.19/i18n/<?php echo $_SESSION['site_lang']; ?>.json'
            }
        });
    });
</script>