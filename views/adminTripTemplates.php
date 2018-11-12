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
    <h1 style="font-family: Capriola, sans-serif;padding: 20px;background-position: top;margin-bottom: 0px;">Administration of trip templates</h1>
    <section>
        <div id="wrapper">
            <div id="sidebar-wrapper" style="font-family: Capriola, sans-serif;">
                <ul class="sidebar-nav">
                    <li class="sidebar-brand"> <a href="AdminMain.html"><strong>Administration main</strong></a></li>
                    <li> <a href="AdminTripTemplates.html" style="background-color: rgba(255,255,255,0.2);">Trip templates</a></li>
                    <li> </li>
                    <li> <a href="AdminUsers.html">Users</a></li>
                    <li> <a href="AdminHotels.html">Hotels</a></li>
                    <li> <a href="AdminBuses.html">Buses</a></li>
                    <li> <a href="AdminInsurances.html">Insurances</a></li>
                </ul>
            </div>
            <div class="page-content-wrapper">
                <div class="container-fluid" style="background-image: url(&quot;assets/img/Mountains.jpg&quot;);background-position: center;background-size: cover;background-repeat: no-repeat;padding-bottom: 33px;"><a class="btn btn-link bg-light" role="button" href="#menu-toggle" id="menu-toggle"><i class="fa fa-bars"></i></a>
                    <h2 class="text-center" style="font-family: Capriola, sans-serif;color: #000000;"><strong>Create a new trip template.</strong></h2>
                    <form class="form-inline pulse animated" action="index.php" method="post" enctype="multipart/form-data" id="tripTemplateForm" style="background-color: rgba(255,255,255,0.6);margin: 20px;padding: 20px;font-family: Capriola, sans-serif;">
                        <div class="form-group" style="margin: 10px;margin-right: 10px;width: 400px;"><label class="labelsFormTripTemplates">Trip name</label><textarea class="form-control" name="name" required="" minlength="3" style="width: 400px;"></textarea></div>
                        <div class="form-group" style="margin: 10px;"><label class="labelsFormTripTemplates">Description</label><textarea class="form-control" name="description" required="" minlength="3" style="width: 400px;margin-right: 0px;"></textarea></div>
                        <div class="form-group" style="margin: 10px;"><label class="labelsFormTripTemplates" style="padding: 0x;">Minimal number of participants</label><input class="form-control" type="number" name="minAllocation" value="12" required="" min="12" max="20" step="1" style="width: 100px;margin-right: 0px;"></div>
                        <div
                            class="form-group" style="margin: 10px;"><label class="labelsFormTripTemplates">Maximal number of participants</label><input class="form-control" type="number" name="maxAllocation" value="20" required="" min="12" max="20" step="1" style="width: 100px;margin-right: 0px;"></div>
                <div
                    class="form-group" style="margin: 10px;">
                    <div><label class="labelsFormTripTemplates" style="width: 30px;">Bus</label><select class="form-control" name="bus" required="" id="busDropdownForTripTemplate" style="background-color: #ffffff;margin-right: 0px;"><optgroup label="Select bus"><option value="12" selected="">This is item 1</option><option value="13">This is item 2</option><option value="14">This is item 3</option></optgroup></select></div>
            </div>
            <div class="form-group mt-auto" style="margin-right: 100px;padding: 10px;padding-right: 50px;margin-bottom: 20px;padding-bottom: 0px;"><label class="labelsFormTripTemplates" style="padding: 0;">Picture</label><input type="file" name="picture_path" required="" style="width: 400px;font-family: Capriola, sans-serif;background-color: #ffffff;margin-right: 0;"></div>
            <div class="form-group mt-auto"
                style="margin-top: 0px;padding-top: 20px;"><button class="btn btn-primary" type="submit" style="width: 100px;margin: 10px;margin-top: 10px;margin-left: 10px;">Save</button></div>
            </form>
            <div style="background-color: rgba(255,255,255,0.53);padding-top: 0px;margin-top: 65px;padding-bottom: 20px;">
                <h2 class="text-center" style="margin-bottom: 40px;padding: 0px;padding-top: 23px;font-family: Capriola, sans-serif;"><strong>Overview of added trip templates.</strong></h2><!DOCTYPE html>
<html lang="en">
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container" style="font-family: Capriola, sans-serif;">

  <input class="form-control" id="tripTemplateInput" type="text" placeholder="Search trip template...">
  <br>
  <table id="tripTemplateOverviewTable" class="tableStyle">
    <thead>
      <tr>
        <th>Image</th>
        <th>Trip name</th>
        <th>Description</th>
        <th>Min. travelers</th>
        <th>Max. travelers</th>
        <th>Bus</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody id="tripTemplateTableBody">
        <tr>
        <td></td>
        <td></td>
        <td></td>
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
function addTripTemplatesFromDBtoTable() {

    var table = document.getElementById("tripTemplateOverviewTable");

    // Input data --> use a list from DB
    var tripId = [10, 12, 15];
    var tripImage = ['<img src="assets/img/tower%20bridge.jpg" alt="Remove" border=3 width=200>', '<img src="assets/img/tower%20bridge.jpg" alt="Remove" border=3 width=200>', '<img src="assets/img/tower%20bridge.jpg" alt="Remove" border=3 width=200>'];
    var tripName = ["Badeferien in Spanien", "Badeferien in Frankreich", "Badeferien in Deutschland"];
    var tripDescription = ["Video bietet eine leistungsstarke Möglichkeit zur Unterstützung Ihres Standpunkts. Wenn Sie auf Onlinevideo klicken.", "können Sie den Einbettungscode für das Video einfügen, das hinzugefügt werden soll. Sie können auch ein Stichwort eingeben, um online nach dem Videoclip", "Klicken Sie auf Einfügen, und wählen Sie dann die gewünschten Elemente aus den verschiedenen Katalogen aus"];
    var minTravelers = [13, 15, 20];
    var maxTravelers = [20, 18, 20];
    var tripBus = ['<img src="assets/img/Bus%20travel.jpg" alt="Remove" border=3 width=200>', '<img src="assets/img/Bus%20travel.jpg" alt="Remove" border=3 width=200>', '<img src="assets/img/Bus%20travel.jpg" alt="Remove" border=3 width=200>'];


    // Add all trip templates to the table
    for (var i = 0; i < tripId.length; i++) {

        // Create an empty <tr> element and add it at the end
        var indexOfNewRow = table.rows.length;
        var row = table.insertRow(indexOfNewRow);

        // Insert new cells (<td> elements)
        var cellTripImage = row.insertCell(0);
        var cellTripName = row.insertCell(1);
        var cellTripDescription = row.insertCell(2);
        var cellMinTravelers = row.insertCell(3);
        var cellMaxTravelers = row.insertCell(4);
        var cellTripBus = row.insertCell(5);
        var cellDelete = row.insertCell(6);

        // Fill contents in cells
        cellTripImage.innerHTML = tripImage[i];
        cellTripName.innerHTML = tripName[i];
        cellTripDescription.innerHTML = tripDescription[i];
        cellMinTravelers.innerHTML = minTravelers[i];
        cellMaxTravelers.innerHTML = maxTravelers[i];
        cellTripBus.innerHTML = tripBus[i];
        cellDelete.innerHTML = '<img src="assets/img/Recycle_Bin.png" alt="Remove" border=3 height=20 width=20>';
    }
}

addTripTemplatesFromDBtoTable();

// Remove trip templates from the database
table = document.getElementById("tripTemplateOverviewTable");
            for(var i = 1; i < table.rows.length; i++)
            {
                table.rows[i].cells[6].onclick = function(){
                    var c = confirm("Do you want to delete this trip template?");
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
  $("#tripTemplateInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#tripTemplateTableBody tr").filter(function() {
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