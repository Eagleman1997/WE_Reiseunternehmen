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
    <title>Reiseunternehmen extracted header &amp; footer</title>
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
</head>

<body style="background-color: rgb(241,247,252);font-family: Capriola, sans-serif;padding-bottom: 0px;">
    <div style="min-height: 850px;">
        <ul class="nav nav-tabs" style="margin-top: 15px;margin-bottom: 15px;">
            <li class="nav-item"><a class="nav-link active" role="tab" data-toggle="tab" href="#tab-1">All trips</a></li>
            <?php if(isset($_SESSION['role']) and $_SESSION['role'] != "admin") : ?>
            <li class="nav-item"><a class="nav-link" role="tab" data-toggle="tab" href="#tab-2">My booked trips</a></li>
            <?php endif; ?>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" role="tabpanel" id="tab-1">
                <div class="container" style="font-family: Capriola, sans-serif;padding-top: 25px;padding-bottom: 0px;margin-top: 0px;margin-bottom: 120px;">
                    <div class="heading">
                        <h2 style="margin-bottom: 19px;">All available trips.</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0"><a href="#"><img src="assets/img/Beach.jpg" alt="Card Image" class="card-img-top scale-on-hover"></a>
                                <div class="card-body">
                                    <h6><a href="#">Lorem Ipsum</a></h6>
                                    <p class="text-muted card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna.</p><strong class="d-lg-flex justify-content-lg-end align-items-lg-end priceTag">CHF 1'200.00</strong></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0"><a href="#"><img src="assets/img/paris.jpg" alt="Card Image" class="card-img-top scale-on-hover"></a>
                                <div class="card-body">
                                    <h6><a href="#">Lorem Ipsum</a></h6>
                                    <p class="text-muted card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna.</p><strong class="d-lg-flex justify-content-lg-end align-items-lg-end priceTag">CHF 1'200.00</strong></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0"><a href="#"><img src="assets/img/Hiking.jpg" alt="Card Image" class="card-img-top scale-on-hover"></a>
                                <div class="card-body">
                                    <h6><a href="#">Lorem Ipsum</a></h6>
                                    <p class="text-muted card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna.</p><strong class="d-lg-flex justify-content-lg-end align-items-lg-end priceTag">CHF 1'200.00</strong></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0"><a href="#"><img src="assets/img/spanish%20beach.png" alt="Card Image" class="card-img-top scale-on-hover"></a>
                                <div class="card-body">
                                    <h6><a href="#">Lorem Ipsum</a></h6>
                                    <p class="text-muted card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna.</p><strong class="d-lg-flex justify-content-lg-end align-items-lg-end priceTag">CHF 1'200.00</strong></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0"><a href="#"><img src="assets/img/rome.jpg" alt="Card Image" class="card-img-top scale-on-hover"></a>
                                <div class="card-body">
                                    <h6><a href="#">Lorem Ipsum</a></h6>
                                    <p class="text-muted card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna.</p><strong class="d-lg-flex justify-content-lg-end align-items-lg-end priceTag">CHF 1'200.00</strong></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0"><a href="#"><img src="assets/img/tower%20bridge.jpg" alt="Card Image" class="card-img-top scale-on-hover"></a>
                                <div class="card-body">
                                    <h6><a href="#">Lorem Ipsum</a></h6>
                                    <p class="text-muted card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna.</p><strong class="d-lg-flex justify-content-lg-end align-items-lg-end priceTag">CHF 1'200.00</strong></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" role="tabpanel" id="tab-2">
                <div class="container" style="font-family: Capriola, sans-serif;padding-top: 25px;padding-bottom: 0px;margin-top: 0px;margin-bottom: 40px;">
                    <div class="heading">
                        <h2 style="margin-bottom: 19px;">All trips you have booked.</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0"><a href="#"><img src="assets/img/Beach.jpg" alt="Card Image" class="card-img-top scale-on-hover"></a>
                                <div class="card-body">
                                    <h6><a href="#">Lorem Ipsum</a></h6>
                                    <p class="text-muted card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna.</p><strong class="d-lg-flex justify-content-lg-end align-items-lg-end priceTag">CHF 1'200.00</strong></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0"><a href="#"><img src="assets/img/paris.jpg" alt="Card Image" class="card-img-top scale-on-hover"></a>
                                <div class="card-body">
                                    <h6><a href="#">Lorem Ipsum</a></h6>
                                    <p class="text-muted card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna.</p><strong class="d-lg-flex justify-content-lg-end align-items-lg-end priceTag">CHF 1'200.00</strong></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0"><a href="#"><img src="assets/img/Hiking.jpg" alt="Card Image" class="card-img-top scale-on-hover"></a>
                                <div class="card-body">
                                    <h6><a href="#">Lorem Ipsum</a></h6>
                                    <p class="text-muted card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna.</p><strong class="d-lg-flex justify-content-lg-end align-items-lg-end priceTag">CHF 1'200.00</strong></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
</body>

</html>