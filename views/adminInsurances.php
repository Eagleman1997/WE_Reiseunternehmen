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

<body style="background-size: cover;background-repeat: no-repeat;background-position: center;background-color: rgb(241,247,252);">
    <h1 style="font-family: Capriola, sans-serif;padding: 20px;background-position: top;margin-bottom: 0px;">Administration of insurances</h1>
    <section>
        <div id="wrapper">
            <div id="sidebar-wrapper" style="font-family: Capriola, sans-serif;">
                <ul class="sidebar-nav">
                    <li class="sidebar-brand"> <a href="AdminMain.html"><strong>Administration main</strong></a></li>
                    <li> <a href="AdminTripTemplates.html">Trip templates</a></li>
                    <li> </li>
                    <li> <a href="AdminUsers.html">Users</a></li>
                    <li> <a href="AdminHotels.html">Hotels</a></li>
                    <li> <a href="AdminBuses.html">Buses</a></li>
                    <li> <a href="AdminInsurances.html" style="background-color: rgba(255,255,255,0.2);">Insurances</a></li>
                </ul>
            </div>
            <div class="page-content-wrapper">
                <div class="container-fluid" style="background-image: url(&quot;assets/img/europe%20skyline%20uncut.png&quot;);background-position: center;background-size: cover;background-repeat: no-repeat;padding-bottom: 26px;min-height: 800px;"><a class="btn btn-link" role="button" href="#menu-toggle" id="menu-toggle"><i class="fa fa-bars"></i></a>
                    <h2 class="text-center" style="font-family: Capriola, sans-serif;color: #000000;"><strong>Add a new insurance.</strong></h2>
                    <form class="form-inline pulse animated" action="index.php" method="post" id="insuranceForm" style="background-color: rgba(255,255,255,0.77);margin: 20px;padding: 20px;font-family: Capriola, sans-serif;">
                        <div class="form-group" style="width: 400px;margin: 10px;margin-right: 10px;"><label class="labelsFormTripTemplates">Insurance name</label><textarea class="form-control" name="name" required="" minlength="3" style="width: 400px;"></textarea></div>
                        <div class="form-group" style="margin: 10px;"><label class="labelsFormTripTemplates">Description</label><textarea class="form-control" name="description" required="" minlength="3" style="width: 400px;margin-right: 0px;"></textarea></div>
                        <div class="form-group" style="margin: 10px;width: 200px;margin-right: 50px;"><label class="labelsFormTripTemplates">Price per person</label><input class="form-control" type="number" name="price" required="" min="1"></div>
                        <div class="form-group mt-auto" style="margin-top: 0px;padding-top: 20px;"><button class="btn btn-primary btn-block" type="submit" style="width: 100px;margin: 10px;margin-top: 10px;margin-left: 10px;">Save</button></div>
                    </form>
                    <div style="font-family: Capriola, sans-serif;margin-bottom: 40px;padding-bottom: 20px;margin-top: 65px;min-width: 705px;background-color: rgba(255,255,255,0.77);margin-right: 0px;">
                        <h2 class="text-center" style="margin-bottom: 16px;padding: 0px;padding-top: 23px;"><strong>Overview of added insurances.</strong></h2><!DOCTYPE html>
<html lang="en">
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container" style="font-family: Capriola, sans-serif;">

  <input class="form-control" id="insuranceInput" type="text" placeholder="Search insurance...">
  <br>
  <table id="insuranceOverviewTable" class="tableStyle">
    <thead>
      <tr>
        <th>Insurance name</th>
        <th>Description</th>
        <th>Price per person</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody id="insuranceTableBody">
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
function addInsurancesFromDBtoTable() {

    var table = document.getElementById("insuranceOverviewTable");

    // Input data --> use a list from DB
    var insuranceId = [10, 12, 15];
    var insuranceName = ["Mathys Versicherung", "Gehrig Verunsicherung", "Cajochen Versicherung"];
    var insuranceDescription = ["Video bietet eine leistungsstarke Möglichkeit zur Unterstützung Ihres Standpunkts. Wenn Sie auf Onlinevideo klicken.", "können Sie den Einbettungscode für das Video einfügen, das hinzugefügt werden soll. Sie können auch ein Stichwort eingeben, um online nach dem Videoclip", "Klicken Sie auf Einfügen, und wählen Sie dann die gewünschten Elemente aus den verschiedenen Katalogen aus"];
    var pricePerPerson = ["200", "120", "240"];

    // Add all insurances to the table
    for (var i = 0; i < insuranceId.length; i++) {

        // Create an empty <tr> element and add it at the end
        var indexOfNewRow = table.rows.length;
        var row = table.insertRow(indexOfNewRow);

        // Insert new cells (<td> elements)
        var cellinsuranceName = row.insertCell(0);
        var cellinsuranceDescription = row.insertCell(1);
        var cellpricePerPerson = row.insertCell(2);
        var cellDelete = row.insertCell(3);

        // Fill contents in cells
        cellinsuranceName.innerHTML = insuranceName[i];
        cellinsuranceDescription.innerHTML = insuranceDescription[i];
        cellpricePerPerson.innerHTML = pricePerPerson[i];
        cellDelete.innerHTML = '<img src="assets/img/Recycle_Bin.png" alt="Remove" border=3 height=20 width=20>';
    }
}

addInsurancesFromDBtoTable();

// Remove insurances from the database
table = document.getElementById("insuranceOverviewTable");
            for(var i = 1; i < table.rows.length; i++)
            {
                table.rows[i].cells[3].onclick = function(){
                    var c = confirm("Do you want to delete this insurance?");
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
  $("#insuranceInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#insuranceTableBody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

</script>

</body>
</html>
</div>
                </div>
            </div>
        </div>
    </section>
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