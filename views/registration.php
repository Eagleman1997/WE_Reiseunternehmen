<?php

/**
 * @author Adrian Mathys
 */
use views\TemplateView;
?>



<div class="register-photo" style="padding: 40px;font-family: Capriola, sans-serif;padding-bottom: 60px;">
    <div class="form-container">
        <div class="image-holder" style="background-image: url(&quot;assets/img/Hiking.jpg&quot;);"></div>
        <form name="registrationForm" action="<?php echo $GLOBALS['ROOT_URL']."/registration" ?>" method="post" onsubmit="return validateForm()" style="font-family: Capriola, sans-serif;">
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
            function validateForm() {
                if (document.registrationForm.password.value != document.registrationForm.password - repeat.value) {
                    alert("Please repeat the password");
                    return false;
                }
            }

        </script></div>
</div>

