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
    <div class="register-photo" style="font-family: Capriola, sans-serif;background-size: auto;min-height: 800px;">
        <div class="form-container">
            <div class="image-holder" style="background-image: url(&quot;assets/img/travelGroup.jpg&quot;);background-position: center;background-size: cover;background-repeat: no-repeat;"></div>
            <form action="index.php" method="post">
                <h2 class="text-center"><strong>Add travelers </strong>to your profile.</h2>
                <div class="form-group"><label style="margin-bottom: 0px;">First name</label><input class="form-control" type="text" name="firstName" required="" minlength="3"></div>
                <div class="form-group"><label style="margin-bottom: 0px;">Last name</label><input class="form-control" type="text" name="lastName" required="" minlength="3"></div>
                <div class="form-group"><label style="margin-bottom: 0px;">Birth date</label><input class="form-control" type="date" name="birthDate" required=""></div>
                <div class="form-group"><button class="btn btn-primary btn-block" type="submit">Add person</button></div>
            </form>
        </div>
        <div class="container" style="margin-top: 81px;">
            <h2 class="text-center" style="margin-bottom: 16px;"><strong>Overview of your added travelers.</strong></h2><!DOCTYPE html>
<html lang="en">
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container" style="font-family: Capriola, sans-serif;">

  <input class="form-control" id="participantInput" type="text" placeholder="Search travelers...">
  <br>
  <table id="participantOverviewTable" class="tableStyle">
    <thead>
      <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Birth date</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody id="participantTableBody">
        <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </tbody>
  </table>
</div>

<script>

// This function must be fed with a list from the DB
function addTravelersFromDBtoTable() {

    var table = document.getElementById("participantOverviewTable");

    // Input data --> use a list from DB
    var userId = [10, 12, 15];
    var firstname = ["Adrian", "Lukas", "Vanessa"];
    var lastname = ["Mathys", "Gehrig", "Cajochen"];
    var birthDate = ["1967-10-10", "1967-10-10", "1967-10-10"];


    // Add all travelers to the table
    for (var i = 0; i < userId.length; i++) {

        // Create an empty <tr> element and add it at the end
        var indexOfNewRow = table.rows.length;
        var row = table.insertRow(indexOfNewRow);

        // Insert new cells (<td> elements)
        var cellFirstname = row.insertCell(0);
        var cellLastname = row.insertCell(1);
        var cellBirthDate = row.insertCell(2);
        var cellDelete = row.insertCell(3);

        // Fill contents in cells
        cellFirstname.innerHTML = firstname[i];
        cellLastname.innerHTML = lastname[i];
        cellBirthDate.innerHTML = birthDate[i];
        cellDelete.innerHTML = '<img src="assets/img/Recycle_Bin.png" alt="Remove" border=3 height=20 width=20>';
    }
}

addTravelersFromDBtoTable();

// Remove travelers from the database
table = document.getElementById("participantOverviewTable");
            for(var i = 1; i < table.rows.length; i++)
            {
                table.rows[i].cells[3].onclick = function(){
                    var c = confirm("Do you want to delete this user?");
                    if(c == true)
                    {
                        index = this.parentElement.rowIndex;
                        table.deleteRow(index);
                        // send index to database in order to delete the user
                    }
                }
            }
    
//Make the table searchable
$(document).ready(function(){
  $("#participantInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#participantTableBody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

</script>

</body>
</html>
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