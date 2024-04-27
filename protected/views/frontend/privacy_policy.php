<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    if ($db->exists('company', array('id' => 1))) {
        $setting = $db->get_row('company', array('id' => 1));
    } else {
        $setting = $db->get_row('settings');
    }

    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php if ($db->exists('company', array('id' => 1))) { ?>
            <?php echo $setting['company_name']; ?>
        <?php } else { ?>
            <?php echo $setting['name']; ?>
        <?php } ?>
    </title>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400,700|Roboto:300,400,700" rel="stylesheet">
    <link href="<?php echo SITE_URL . '/assets/frontend/css/bootstrap.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo SITE_URL . '/assets/frontend/css/style.css'; ?>" rel="stylesheet">
    <link href="<?php echo SITE_URL . '/assets/frontend/plugins/font-awesome/css/font-awesome.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo SITE_URL . '/assets/frontend/plugins/chosen/chosen.min.css'; ?>" rel="stylesheet">
    <!-- custom css -->
    <link href="<?php echo SITE_URL . '/assets/frontend/css/custom.css'; ?>" rel="stylesheet">
    <link href="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-datepicker/bootstrap-datepicker.css'; ?>" rel="stylesheet">
</head>

<body>
    <div id="container">

        <div class="boxed">
            <div id="content-container" style="padding-top: 15px;">
                <div id="page-content">

                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <?php echo $display_msg ?? ''; ?>
                            <div class="eq-height">
                                <div class="col-sm-12 eq-box-sm">
                                    <div class="panel">
                                        <div>
                                            <div class="center" style="text-align:center;">
                                                <!-- <img src="<?php echo SITE_URL . '/uploads/logo/' . $setting['logo']; ?>" width="200px;"> -->
                                                <?php if ($db->exists('company', array('id' => 1))) {
                                                    if ($setting['logo'] == '') {
                                                ?>
                                                        <img src="<?php echo SITE_URL . '/uploads/noimage.png'; ?>" width="150px;">
                                                    <?php } else { ?>
                                                        <img src="<?php echo SITE_URL . '/uploads/logo/company_logo/' . $setting['logo']; ?>" width="200px;" />

                                                    <?php }
                                                } else { ?>
                                                    <!-- <img  src="<?php echo SITE_URL . '/uploads/logo/' . $setting['logo']; ?>" class="img-circle"/> -->
                                                    <img src="<?php echo SITE_URL . '/uploads/logo/' . $setting['logo']; ?>" width="200px;" />
                                                <?php } ?>
                                            </div>

                                            <div class="text-right" style="margin-right: 15px;">
                                                <?php
                                                if (isset($_GET['lang']) && $_GET['lang'] == 'ar') {
                                                ?>
                                                    <a href="<?php echo $link->link('privacy_policy', frontend); ?>"> <span class="text-primary"> English </span> </a>
                                                <?php
                                                } else {
                                                ?>
                                                    <a href="<?php echo $link->link('privacy_policy&lang=ar', frontend); ?>"> <span class="text-primary"> Arabic </span> </a>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <hr>
                                        </div>

                                        <div>
                                            <?php
                                            if (isset($_GET['lang']) && $_GET['lang'] == 'ar') {
                                                echo file_get_contents(SERVER_ROOT . '/protected/views/frontend/privacy_policy_template_ar.php');
                                            } else {
                                                echo file_get_contents(SERVER_ROOT . '/protected/views/frontend/privacy_policy_template_en.php');
                                            }
                                            ?>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="<?php echo SITE_URL . '/assets/frontend/js/jquery-2.1.1.min.js'; ?>"></script>
    <script src="<?php echo SITE_URL . '/assets/frontend/js/bootstrap.min.js'; ?>"></script>
    <script src="<?php echo SITE_URL . '/assets/frontend/plugins/chosen/chosen.jquery.min.js'; ?>"></script>
    <!-- jQuery-Vaildation -->
    <script src="<?php echo SITE_URL . '/assets/frontend/plugins/jquery-validation/jquery.validate.min.js'; ?>"></script>
    <script src="<?php echo SITE_URL . '/assets/frontend/plugins/jquery-validation/additional-methods.min.js'; ?>"></script>
    <script src="<?php echo SITE_URL . '/assets/frontend/js/form-validation.js'; ?>"></script>

    <script src="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-datepicker/bootstrap-datepicker.js'; ?>"></script>
    <script src="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-datepicker/moment.js'; ?>" type="text/javascript"></script>

</body>

</html>