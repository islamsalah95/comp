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

  <!-- website logo -->
  <link href="<?php echo SITE_URL . '/uploads/logo/company_icons/background_techsup_flex-02.png'; ?>" rel="shortcut icon" type="image/x-icon">
  <!-- style -->
  <link href="<?php echo SITE_URL . '/assets/main_frontend/web/assets/mobirise-icons/mobirise-icons.css'; ?>" rel="stylesheet">
  <link href="<?php echo SITE_URL . '/assets/main_frontend/plugins/bootstrap/css/bootstrap.min.css'; ?>" rel="stylesheet">
  <link href="<?php echo SITE_URL . '/assets/main_frontend/dropdown/css/style.css'; ?>" rel="stylesheet">
  <link href="<?php echo SITE_URL . '/assets/main_frontend/fonts/style.css'; ?>" rel="stylesheet">
  <link href="<?php echo SITE_URL . '/assets/main_frontend/css/style.css'; ?>" rel="preload" as="style"><link href="<?php echo SITE_URL . '/assets/main_frontend/css/style.css'; ?>" rel="stylesheet" type="text/css">
  <link href="<?php echo SITE_URL . '/assets/main_frontend/css/custom.css'; ?>" rel="stylesheet">
  <link href="<?php echo SITE_URL . '/assets/main_frontend/css/socicon/css/style.css'; ?>" rel="stylesheet">

  <!-- JQ script -->
  <script src="<?php echo SITE_URL . '/assets/main_frontend/web/assets/jquery/jquery.min.js'; ?>"></script>  
  
</head>
<body>
  
<section class="menu menu2 cid-szJuMu20E3" once="menu" id="menu2-2h">
<nav class="navbar navbar-dropdown navbar-fixed-top navbar-expand-lg">
    <div class="container">
        <div class="navbar-brand">
            <span class="navbar-logo">
                <img src="<?php echo SITE_URL . '/assets/main_frontend/images/logo-1-removebg-preview-294x122.png'; ?>" alt="techsup" style="height: 3.6rem;">
            </span>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav nav-dropdown" data-app-modern-menu="true">
                <li class="nav-item"><a class="nav-link link text-primary display-4" href="#contact_us"><?php echo $lang["service_request"]; ?></a></li>
                <li class="nav-item"><a class="nav-link link text-primary display-4" href="#target_jobs"><?php echo $lang["target_jobs"]; ?></a></li>
                <li class="nav-item"><a class="nav-link link text-primary display-4" href="#about_us"><?php echo $lang["about_us"]; ?></a></li>
                <li class="nav-item"><a class="nav-link link text-primary display-4" href="#home"><?php echo $lang["home"]; ?></a></li>
            </ul>
            <div class="navbar-buttons mbr-section-btn">
                <a class="btn btn-primary display-4" href="<?php echo $link->link('signup', frontend); ?>" target="_blank"><?php echo $lang['sign_in']; ?></a>
                    <?php
                    if (isset($_GET['lang']) && $_GET['lang'] == 'en') {
                    ?>
                      <a class="change_lang btn btn-success display-4" data-lang="Arabic" href="<?php echo $link->link('main_page', frontend); ?>" >Arabic</a>
                    <?php
                    } else {
                    ?>
                        <a class="change_lang btn btn-success display-4" data-lang="English" href="<?php echo $link->link('main_page&lang=en', frontend); ?>" >English</a>
                    <?php
                    }
                    ?>
            </div>
        </div>
    </div>
</nav>
</section>

<div>
    <?php
    if (isset($_GET['lang']) && $_GET['lang'] == 'en') { 
         require_once(SERVER_ROOT . '/protected/views/frontend/main_page_en.php');
    } else {
         require_once(SERVER_ROOT . '/protected/views/frontend/main_page_ar.php');
    }
    ?>
</div>

<script src="<?php echo SITE_URL . '/assets/main_frontend/plugins/bootstrap/js/bootstrap.min.js'; ?>"></script>  
<script src="<?php echo SITE_URL . '/assets/main_frontend/dropdown/js/nav-dropdown.js'; ?>"></script>  
<script src="<?php echo SITE_URL . '/assets/main_frontend/dropdown/js/navbar-dropdown.js'; ?>"></script>  
<script src="<?php echo SITE_URL . '/assets/main_frontend/js/jquery.touch-swipe.min.js'; ?>"></script>  
<script src="<?php echo SITE_URL . '/assets/main_frontend/plugins/bootstrapcarouselswipe/bootstrap-carousel-swipe.js'; ?>"></script>  
<script src="<?php echo SITE_URL . '/assets/main_frontend/js/mbr-testimonials-slider.js'; ?>"></script>  

<script type="text/javascript">
    $('.change_lang').click(function() {
        var current_lang = '<?php echo $_SESSION["site_lang"] ; ?>';
        var change_lang = $(this).attr('data-lang');
        if (current_lang != change_lang) {
            var url = '<?php echo $link->link("change_lang", frontend);  ?>';
            $.post(url, {
                'site_lang': change_lang
            }).done(function() {
                $_SESSION["site_lang"] == current_lang;
                window.location.reload();
            });
        }
    });
</script>

</body>
</html>