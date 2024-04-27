<div id="content-container">
  <div class="pageheader">
    <h3><i class="fa fa-tags"></i><?php echo $lang['company']; ?></h3>
    <div class="breadcrumb-wrapper">
      <span class="label"><?php echo $lang['you_are_here']; ?>:</span>
      <ol class="breadcrumb">
        <li class="active"><?php echo $lang['company']; ?></li>
      </ol>
    </div>
  </div>



  <div id="page-content">
    <div class="panel">
      <?php echo $display_msg ?? ''; ?>
      <div class="panel-heading">
        <h3 class="panel-title"><?php echo $lang['list_all_company']; ?>

          <span class="pull-right">
            <!-- <a class="btn btn-primary" href="<?php echo $link->link('add_company', frontend); ?>"><i class="fa fa-plus"></i> <?php echo $lang['add_company']; ?></a> -->
          </span>
        </h3>

      </div>
      <div class="panel-body">
        <table id="demo-dt-basic1" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th><?php echo $lang['company_name']; ?></th>
              <th><?php echo $lang['email']; ?></th>
              <th><?php echo $lang['company_website']; ?></th>
              <th><?php echo $lang['address']; ?></th>
              <th><?php echo $lang['company_phone']; ?></th>
              <th><?php echo $lang['country']; ?></th>
              <th><?php echo $lang['timezone']; ?></th>
              <th><?php echo $lang['created_at']; ?></th>

              <th width="20%"> <?php echo $lang['action']; ?></th>
            </tr>
          </thead>
          <tbody>
            <?php if (is_array($company)) {
              foreach ($company as $company_ls) { ?>
                <tr>
                  <td><?php echo $company_ls['company_name']; ?></td>
                  <td><?php echo $company_ls['company_email']; ?></td>
                  <td><?php echo $company_ls['company_website']; ?></td>
                  <td><?php echo $company_ls['company_address']; ?></td>
                  <td><?php echo $company_ls['telephone1']; ?></td>
                  <td><?php echo $company_ls['country']; ?></td>
                  <td><?php echo $company_ls['timezone']; ?></td>
                  <td><?php echo $company_ls['create_date']; ?></td>
                  <td>
                    <!-- <a href="<?php echo $link->link("edit_company", frontend, '&edit_id=' . $company_ls['id']); ?>" class="btn btn-success fa fa-edit"></a> -->
                
                    <form method="post" action="<?= $link->link("edit_company", frontend) ?>">
                      <input type="hidden" name="edit_id" value="<?= $company_ls['id'] ?>">
                      <button type="submit" class="btn btn-success fa fa-edit"></button>
                    </form>

                
                
                
                <?php
                    if ($company_ls['id'] != 1 && $company_ls['id'] != $_SESSION['company_id']) { ?>
                      <!-- <a href="<?php echo $link->link("registered_company", frontend, '&del_id=' . $company_ls['id']); ?>" class="btn btn-danger fa fa-trash"></a> -->
                      <form method="post" action="<?= $link->link("registered_company", frontend) ?>">
                        <input type="hidden" name="del_id" value="<?= $company_ls['id'] ?>">
                        <button type="submit" class="btn btn-danger fa fa-trash" style="margin: 3px;"></button>
                      </form>

                  
              <!-- <a href="<?php echo $link->link("registered_company", frontend, '&activate_id=' . $company_ls['id']); ?>" class="btn btn-warning"><?php echo $lang['activate']; ?></a> -->
                  <?php
                      if ($company_ls['is_valid'] == 0) { ?>
                        <form method="post" action="<?= $link->link("registered_company", frontend) ?>">
                          <input type="hidden" name="activate_id" value="<?= $company_ls['id'] ?>">
                          <button type="submit" class="btn btn-warning" style="background-color:#203b47;border-color:#203b47; margin: 3px; padding-top: 3px;padding-bottom: 3px;"><?= $lang['activate'] ?></button>
                        </form>

                    <?php } 
                      ?>
                    <?php } ?>
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
    $('#demo-dt-basic1').DataTable({
      "dom": "<'row'<'col-md-4'l><'col-md-8'Bf>>" + "<'row'<'col-md-6'><'col-md-6'>>" + "<'row'<'col-md-12't>><'row'<'col-md-6'i><'col-md-6'p>>",
      buttons: [{
          extend: 'csv',
          exportOptions: {
            columns: [0]
          }
        },
        {
          extend: 'excel',
          exportOptions: {
            columns: [0]
          }
        },
        {
          extend: 'print',
          exportOptions: {
            columns: [0]
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
      "oLanguage": {
        'sUrl': '//cdn.datatables.net/plug-ins/1.10.19/i18n/<?php echo $_SESSION['site_lang']; ?>.json'
      }
    });
  });
</script>