function checkForm(){ 
    if (document.registrationForm.password.value != document.registrationForm.password-repeat.value)  {
       alert("Please repeat the password");
       return false; 
    }
}