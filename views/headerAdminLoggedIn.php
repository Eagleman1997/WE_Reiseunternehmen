<?php

/**
 * @author Adrian Mathys
 */
use views\TemplateView;
?>


<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Reiseunternehmen</title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Aclonica">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Capriola">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css">
        <link rel="stylesheet" href="assets/css/Basic-fancyBox-Gallery.css">
        <link rel="stylesheet" href="assets/css/Footer-Basic.css">
        <link rel="stylesheet" href="assets/css/Good-login-dropdown-menu-1.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/css/pikaday.min.css">
        <link rel="stylesheet" href="https://unpkg.com/@bootstrapstudio/bootstrap-better-nav/dist/bootstrap-better-nav.min.css">
        <link rel="stylesheet" href="assets/css/Navigation-with-Button.css">
        <link rel="stylesheet" href="assets/css/Navigation-with-Search.css">
        <link rel="stylesheet" href="assets/css/Projects-Clean.css">
        <link rel="stylesheet" href="assets/css/Registration-Form-with-Photo-1.css">
        <link rel="stylesheet" href="assets/css/Registration-Form-with-Photo.css">
        <link rel="stylesheet" href="assets/css/RegistrationForm.css">
        <link rel="stylesheet" href="assets/css/Sidebar-Menu-1.css">
        <link rel="stylesheet" href="assets/css/Sidebar-Menu.css">
        <link rel="stylesheet" href="assets/css/styles.css">
        <link rel="stylesheet" href="assets/css/topnavLogin.css">
        <link rel="stylesheet" href="assets/css/userAdminTable.css">
        <link rel="apple-touch-icon" sizes="57x57" href="assets/img/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="assets/img/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="assets/img/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="assets/img/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="assets/img/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="assets/img/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="assets/img/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="assets/img/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicon-16x16.png">
        <link rel="manifest" href="assets/img/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="assets/img/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
    </head>

    <body style="background-size: cover;background-repeat: no-repeat;background-position: center;background-color: rgb(241,247,252);">
        <div>
            <nav class="navbar navbar-light navbar-expand-md navigation-clean-button">
                <div class="container-fluid"><a class="navbar-brand" href="<?php echo $GLOBALS['ROOT_URL'] ?>/admin" data-bs-hover-animate="tada"></a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                    <div
                        class="collapse navbar-collapse float-right" id="navcol-1">
                        <ul class="nav navbar-nav" style="font-family: Capriola">
                            <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo $GLOBALS['ROOT_URL'] ?>/admin/packageOverview" style="color: #000000;">Trip overview</a></li>
                            <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo $GLOBALS['ROOT_URL'] ?>/admin" style="color: #000000;">Administration</a></li>
                        </ul><span class="ml-auto navbar-text actions" style="background-position: right;color: #000000;"> <a class="float-right" href="<?php echo $GLOBALS['ROOT_URL'] ?>/logout" style="background-position: right; font-family:Capriola">Sign out</a></span></div>
                </div>
            </nav>
        </div>
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.pack.js"></script>
        <script src="assets/js/Basic-fancyBox-Gallery.js"></script>
        <script src="assets/js/bs-animation.js"></script>
        <script src="assets/js/formCheck.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/pikaday.min.js"></script>
        <script src="https://unpkg.com/@bootstrapstudio/bootstrap-better-nav/dist/bootstrap-better-nav.min.js"></script>
        <script src="assets/js/Sidebar-Menu.js"></script>
        <noscript>Yes, we remembered the noscript tag. Please activate JavaScript to use the full potential of this website. </noscript>
    </body>

</html>
