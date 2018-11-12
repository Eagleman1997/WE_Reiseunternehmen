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

<body>
    <div class="register-photo" style="padding: 40px;font-family: Capriola, sans-serif;padding-bottom: 60px;">
        <div class="form-container">
            <div class="image-holder" style="background-image: url(&quot;assets/img/Hiking.jpg&quot;);"></div><form name="registrationForm" action="index.php" method="post" onsubmit="return validateForm()" style="font-family: Capriola, sans-serif;">
    <h2 class="text-center"><strong>Create</strong> an account.</h2>
    <div class="form-group">
        <label>Name</label>    
        <select class="form-control" name="gender" required><optgroup label="Select gender"><option value="male" selected>Mr.</option><option value="female">Mrs.</option></optgroup></select>
        
        <input class="form-control" type="text" name="firstName" required placeholder="First name" maxlength="40" minlength="2" /><input class="form-control" type="text" name="lastName" required placeholder="Last name" maxlength="40"
            minlength="2" /></div>
    <div class="form-group"><label>Address</label><input class="form-control" type="text" name="street" required placeholder="Street" maxlength="40" minlength="2" />
        <input class="form-control" type="number" name="zipCode" required placeholder="ZIP code" min="0"
        /><input class="form-control" type="text" name="location" required placeholder="City or village" maxlength="40" minlength="2" /></div>
    <div class="form-group"><label>Email</label><input class="form-control" type="email" name="email" required placeholder="Email" /></div>
    <div class="form-group"><label>Birth date</label><input class="form-control" type="date" name="birthDate" required /></div>
    <div class="form-group"><label>Password</label><input class="form-control" type="password" name="password" required placeholder="Password" maxlength="40" minlength="5" /><input type="password" name="password-repeat" required placeholder="Password (repeat)"
            class="form-control" /></div>
    <div class="form-group"><button class="btn btn-primary btn-block" type="submit" style="background-color: #f77f00;">Sign Up</button></div>
</form>

<script>
function validateForm(){ 
    if (document.registrationForm.password.value != document.registrationForm.password-repeat.value)  {
       alert("Please repeat the password");
       return false; 
    }
}

</script></div>
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