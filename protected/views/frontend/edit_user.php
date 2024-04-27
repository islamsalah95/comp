<div id="content-container">
   <div class="pageheader">
      <h3><i></i><?php echo $lang['edit_user']; ?></h3>
      <div class="breadcrumb-wrapper">
         <span class="label"><?php echo $lang['you_are_here']; ?>:</span>
         <ol class="breadcrumb">
            <li> <a href="<?php echo $link->link('home', frontend); ?>"> <?php echo $lang['dashboard']; ?> </a> </li>
            <li> <a href="<?php echo $link->link('users', frontend); ?>"><?php echo $lang['users']; ?> </a> </li>
            <li class="active"><?php echo $lang['edit_user']; ?></li>
         </ol>
      </div>
   </div>
   <div id="page-content">
      <div class="row">
         <?php echo $display_msg ?? ''; ?>
         <div class="">
            <div class="panel">
               <div class="panel-heading">
                  <div class="panel-control">
                     <button class="btn btn-default" onclick="goBack()"><i class="fa fa-arrow-circle-left"></i> <?php echo $lang['go_back']; ?></button>
                  </div>
               </div>
               <div class="panel-body pad-no12">
                  <div class="tab-base">
                     <ul class="nav nav-tabs">
                        <li class="<?php if ($current_tab == 'tab1' || $current_tab == '') {
                                       echo "active";
                                    } ?>"><a data-toggle="tab" href="#tab1"><?php echo $lang['personal_information']; ?></a> </li>
                        <li class="<?php if ($current_tab == 'tab2') {
                                       echo "active";
                                    } ?>"> <a data-toggle="tab" href="#tab2"><?php echo $lang['login_credential']; ?></a> </li>
                        <li class="<?php if ($current_tab == 'tab3') {
                                       echo "active";
                                    } ?>"> <a data-toggle="tab" href="#tab3"><?php echo $lang['profile_image']; ?></a> </li>
                     </ul>
                     <div class="tab-content">
                        <div id="tab1" class="tab-pane fade  <?php if ($current_tab == 'tab1'  || $current_tab == '') {
                                                                  echo "active in";
                                                               } ?>">
                           <form method="post" action="<?php $link->link("edit_user", frontend); ?>" enctype="multipart/form-data">
                              <input type="hidden" name="current_tab" value="tab1">
                              <input type="hidden" name="edit" value="<?= $load ?>">

                              <div class="panel-body">
                                 <div class="row">
                                    <div class="col-sm-7">
                                       <div class="form-group">
                                          <div class="text-left">
                                             <label class="text-muted"><?php echo $lang['IdNumber']; ?></label>
                                             <input class="form-control" type="text" placeholder="<?php echo $lang['enter_your_IdNumber']; ?> *" name="IdNumber" value="<?php echo $get_row['IdNumber']; ?>" required="required">
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <div class="text-left">
                                             <label class="text-muted"><?php echo $lang['EstLaborOfficeId']; ?></label>
                                             <input class="form-control" type="text" placeholder="<?php echo $lang['enter_your_EstLaborOfficId']; ?> *" name="EstLaborOfficeId" value="<?php echo $get_row['EstLaborOfficeId']; ?>" required="required">
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <div class="text-left">
                                             <label class="text-muted"><?php echo $lang['EstSequenceNumber']; ?></label>
                                             <input class="form-control" type="text" placeholder="<?php echo $lang['enter_your_EstSequenceNumber']; ?> *" name="EstSequenceNumber" value="<?php echo $get_row['EstSequenceNumber']; ?>" required="required">
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <div class="text-left">
                                             <label class="text-muted"><?php echo $lang['first_name']; ?></label>
                                             <input class="form-control" type="text" placeholder="<?php echo $lang['enter_your_name']; ?> *" name="emp_name" value="<?php echo $get_row['emp_name']; ?>">
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <div class="text-left">
                                             <label class="text-muted"><?php echo $lang['last_name']; ?></label>
                                             <input class="form-control" type="text" placeholder="<?php echo $lang['enter_your_surname']; ?>" name="emp_surname" value="<?php echo $get_row['emp_surname']; ?>">
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <div class="text-left">
                                             <label class="text-muted"><?php echo $lang['address']; ?></label>
                                             <textarea class="form-control" name="address" placeholder="<?php echo $lang['enter_your_address']; ?>"><?php echo $get_row['address']; ?></textarea>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <div class="text-left">
                                             <label class="text-muted"><?php echo $lang['phone_number']; ?></label>
                                             <input class="form-control" type="text" placeholder="<?php echo $lang['enter_your_phone_number']; ?>" name="contact1" value="<?php echo $get_row['contact1']; ?>">
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="control-label"><?php echo $lang['country']; ?> * &nbsp;&nbsp;&nbsp;<i class="fa fa-question-circle add-tooltip" data-placement="right" data-toggle="tooltip" data-original-title="Country will auto updated, according to your current location."></i></label>
                                          <select class="form-control " name="country" disabled>
                                             <?php $country = $feature->getcountry_list(); ?>
                                             <option value="0" label="None" selected="selected"><?php echo $lang['select_a_country']; ?></option>
                                             <?php if (is_array($country)) foreach ($country as $key => $value) { ?>
                                                <option value="<?php echo $key; ?>" <?php if ($key == $get_row['country']) echo "selected"; ?>><?php echo $value; ?></option>
                                             <?php } ?>
                                          </select>
                                       </div>
                                       <div class="form-group">
                                          <label class="control-label"><?php echo $lang['no_of_working_hour']; ?> </label>
                                          <input class="form-control" type="number" name="hour" value="<?php echo $get_row['hour']; ?>">
                                          <!-- <select class="form-control " name="hour">
                                             <?php for ($i = 0; $i <= 24; $i++) : ?>
                                                <option value="<?php echo $i; ?>" <?php if ($i == $get_row['hour']) echo "selected"; ?>><?php echo $i; ?></option>
                                             <?php endfor; ?>
                                          </select> -->
                                       </div>
                                       <div class="form-group">
                                          <label class="control-label"><?php echo $lang['is_mol_TWC']; ?></label>
                                          <select class="form-control " name="is_molTWC">
                                             <option value="0" <?php if ($get_row['is_molTWC'] == 0) echo "selected"; ?>><?php echo $lang['no']; ?></option>
                                             <option value="1" <?php if ($get_row['is_molTWC'] == 1) echo "selected"; ?>><?php echo $lang['yes']; ?></option>
                                          </select>
                                       </div>

                                       <?php if ($_SESSION['department'] == 1 || $_SESSION['department'] == 5) { ?>
                                          <div class="form-group">
                                             <label class="control-label"><?php echo $lang['role']; ?></label>
                                             <select class="form-control " name="department">
                                                <option value="2" <?php if ($get_row['department'] == 2) echo "selected"; ?>><?php echo $lang['user']; ?></option>
                                                <option value="4" <?php if ($get_row['department'] == 4) echo "selected"; ?>><?php echo $lang['manager']; ?></option>
                                                <?php
                                                if ($_SESSION['department'] == 5) {
                                                ?>
                                                   <option value="5" <?php if ($get_row['department'] == 5) echo "selected"; ?>>Super Admin</option>
                                                <?php
                                                }
                                                ?>
                                             </select>
                                          </div>
                                       <?php } ?>

                                    </div>
                                 </div>
                              </div>
                              <div class="panel-footer text-center">
                                 <button class="btn btn-success" type="submit" name="submit_user"><i class="fa fa-save"></i> <?php echo $lang['update']; ?></button>
                              </div>
                           </form>
                        </div>
                        <div id="tab2" class="tab-pane fade <?php if ($current_tab == 'tab2') {
                                                               echo "active in";
                                                            } ?>">
                           <form method="post" action="<?php $link->link("edit_user", frontend); ?>" enctype="multipart/form-data">
                              <input type="hidden" name="current_tab" value="tab2">
                              <input type="hidden" name="edit" value="<?= $load ?>">

                              <div class="panel-body">
                                 <div class="row">
                                    <div class="col-sm-7">
                                       <div class="form-group">
                                          <div class="text-left">
                                             <label class="text-muted"><?php echo $lang['email_id']; ?> *</label>
                                             <input class="form-control" type="text" placeholder="<?php echo $lang['enter_your_email_address']; ?> *" name="email" value="<?php echo $get_row['email']; ?>" disabled>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <div class="text-left">
                                             <label class="text-muted"><?php echo $lang['password']; ?></label>
                                             <input class="form-control" type="password" placeholder="<?php echo $lang['enter_password']; ?>" name="password">
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="panel-footer text-center">
                                 <button class="btn btn-success" type="submit" name="submit_login"><i class="fa fa-save"></i> <?php echo $lang['update']; ?></button>
                              </div>
                           </form>
                        </div>
                        <div id="tab3" class="tab-pane fade <?php if ($current_tab == 'tab3') {
                                                               echo "active in";
                                                            } ?>">
                           <form method="post" action="<?php $link->link("edit_user", frontend); ?>" enctype="multipart/form-data">
                              <input type="hidden" name="current_tab" value="tab3">
                              <input type="hidden" name="edit" value="<?= $load ?>">
                              <div class="panel-body">
                                 <div class="row">
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-8">
                                       <div class="form-group">
                                          <label class="control-label"><?php echo $lang['upload_pic']; ?></label>
                                          <div class="fileupload fileupload-new" data-provides="fileupload">
                                             <div class="fileupload-new img-thumbnail">
                                                <?php
                                                if (file_exists(SERVER_ROOT . '/uploads/profile/' . $get_row['emp_photo_file']) && (($get_row['emp_photo_file']) != '')) { ?>
                                                   <img src="<?php echo SITE_URL . '/uploads/profile/' . $get_row['emp_photo_file']; ?>" style="width:200px;">
                                                <?php } else { ?>
                                                   <img src="<?php echo SITE_URL . '/uploads/noimage.png'; ?>" style="width:200px;">
                                                <?php } ?>
                                             </div>
                                             <div>
                                                <br>
                                                <input type="file" name="profilepic">
                                                <br> <small>Only jpeg, png & jpeg (Max : <?php echo $upload_max_size; ?>)</small>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="panel-footer text-center">
                                 <button class="btn btn-success" type="submit" name="submit_image"><i class="fa fa-save"></i> <?php echo $lang['update']; ?></button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>