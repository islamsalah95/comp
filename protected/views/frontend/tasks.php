<?php
$sql = "
SELECT
    to_do_list.task_name,
    projects.project_name,
    employee.emp_name,
    to_do_list.task_id
FROM
    to_do_list
LEFT JOIN projects ON to_do_list.project_id = projects.project_id
LEFT JOIN employee ON to_do_list.employee_id = employee.employee_id
WHERE
    to_do_list.company_id = :company_id
";

// Prepare the statement
$stmt = $db->prepare($sql);

// Bind the company ID parameter
$stmt->bindParam(':company_id', $_SESSION['company_id']);

// Execute the statement
$stmt->execute();

// Fetch the tasks
$tasks = $stmt->fetchAll();



$load = $_REQUEST['del_id'] ?? '';

if (isset($_REQUEST['del_id'])) {
    $display_msg = '<form method="POST" action="">
<div class="alert alert-success" >
' . $lang["user_delete_confirmation"] . '
<input type="hidden" name="del_id" value="' . $load . '" >
<button name="yes" type="submit" class="btn btn-success btn-xs"  aria-hidden="true"><i class="fa fa-check-square-o"></i></button>
<button name="no" type="submit" class="btn btn-danger btn-xs" aria-hidden="true"><i class="fa fa-remove"></i></button>
</div>
</form>';
}
if (isset($_POST['yes'])) {
  $emp_details = $db->get_row('to_do_list', array('task_id' => $load));
  $delete = $db->delete("to_do_list", array('task_id' => $load));
  if ($delete) {
    $session->redirect('tasks', frontend);
  }
} elseif (isset($_POST['no'])) {
    $session->redirect('tasks', frontend);
}

?>
<div id="content-container">
  <div class="pageheader">
    <h3><i><img src="<?php echo SITE_URL . '/uploads/logo/company_icons/icons_flex-09.png'; ?>" style="width:40px;height:40px;margin:0 10px;" alt="Tasks Picture"></i><?php echo $lang['tasks']; ?></h3>
    <div class="breadcrumb-wrapper">
      <span class="label"><?php echo $lang['you_are_here']; ?>:</span>
      <ol class="breadcrumb">
        <li class="active"><?php echo $lang['tasks']; ?></li>
      </ol>
    </div>
  </div>



  <div id="page-content">
    <div class="panel">
      <?php echo $display_msg  ?? ''; ?>
      <div class="panel-heading">
        <h3 class="panel-title"><?php echo $lang['list_all_tasks']; ?>
          <span class="pull-right">
            <a class="btn btn-primary" href="<?php echo $link->link('add_task', frontend); ?>"><i class="fa fa-plus"></i> <?php echo $lang['add_task']; ?></a>
            <!--   <button class="btn btn-default" type="button"><i class="fa fa-edit"></i> Edit </button>
                                 <button class="btn btn-default" type="button"><i class="fa fa-trash"></i> Trash</button> -->
          </span>



        </h3>
      </div>
      <div class="panel-body">
        <table id="example1" class="cell-border example1 table table-striped table1 delSelTable">
          <thead>
            <tr>
              <th><?php echo $lang['task_title']; ?></th>
              <th><?php echo $lang['project_title']; ?></th>
              <th><?php echo $lang['created_by']; ?></th>
              <th width="20%"><?php echo $lang['action']; ?></th>
            </tr>
          </thead>
          <tbody>
            <?php if (is_array($tasks)) {
              foreach ($tasks as $task) { ?>
                <tr>
                  <td>
                    <?php echo $task["task_name"] ?>
                  </td>

                  <td>
                    <?php echo $task["project_name"] ?>
                  </td>

                  <td>
                    <?php echo $task["emp_name"] ?>
                  </td>

                  <td style="display: flex; justify-content: flex-start;align-items: center;">
                    <form method="post" action="<?= $link->link("edit_task", frontend) ?>">
                      <input type="hidden" name="edit_task_id" value="<?= $task['task_id'] ?>">
                      <button type="submit" class="btn btn-success fa fa-edit"  style="margin: 3px;"></button>
                    </form>


                    <form action="" method="post">
                      <input type="hidden" name="del_id" value="<?php echo $task['task_id']; ?>">
                      <button class="btn btn-danger fa fa-trash" type="submit" name="del"  style="margin: 3px;"></button>
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


<!-- <script type="text/javascript">
  $(document).ready(function() {
    var url = '<?php echo $link->link("get_tasks", frontend); ?>';
    var table = $('#example1').DataTable({
      // dom: 'lfBrtip',
      // buttons: [
      //   'copy', 'excel', 'pdf', 'print'
      // ],
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
      // "responsive": true,
      "language": {
        "paginate": {
          "previous": '<i class="fa fa-angle-left"></i>',
          "next": '<i class="fa fa-angle-right"></i>'
        }
      },
      "processing": true,
      "serverSide": true,
      "ajax": url,
      "iDisplayLength": 10,
      "oLanguage": {
        'sUrl': '//cdn.datatables.net/plug-ins/1.10.19/i18n/<?php echo $_SESSION['site_lang']; ?>.json'
      }
    });
    /*var department = "<?php echo $_SESSION['department']; ?>"; 
    if(department == 5){
      $('#example1_filter').append('<div id="extra_filter"><select id="company" class="form-control input-sm"><option value="">All Company</option><?php if (isset($company)) {
                                                                                                                                                      foreach ($company as $res) { ?><option value="<?php echo $res['id']; ?>"><?php echo $res['company_name']; ?></option><?php }
                                                                                                                                                                                                                                                                        } ?></select></div><div style="clear:both;"></div>');
      $('#company').on('change',function(){
          table.columns(2).search(this.value).draw();
      });
    }*/
  });
</script> -->

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