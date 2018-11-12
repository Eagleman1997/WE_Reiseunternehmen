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
    <div class="border rounded-0 register-photo" style="font-family: Capriola, sans-serif;background-size: auto;min-height: 800px;padding-top: 1px;">
        <div style="padding-bottom: 52px;">
            <div class="container" style="margin-top: 81px;">
                <h2 class="text-center" style="margin-bottom: 16px;"><strong>Overview of your selected trip.</strong></h2><!DOCTYPE html>
<html lang="en">
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container" style="font-family: Capriola, sans-serif;">

  <table id="tripOverviewTable" class="tableStyle">
    <thead>
      <tr>
        <th>Image</th>
        <th>Trip name</th>
        <th>Description</th>
        <th>Min. travelers</th>
        <th>Max. travelers</th>
        <th>Bus</th>
      </tr>
    </thead>
    <tbody id="tripTableBody">
        <tr>
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
function addTripFromDBtoTable() {

    var table = document.getElementById("tripOverviewTable");

    // Input data --> use a list from DB
    var tripId = 1;
    var tripImage = '<img src="assets/img/paris.jpg" alt="Remove" border=3 width=300>';
    var tripName = "Badeferien in Spanien";
    var tripDescription = "Video bietet eine leistungsstarke Möglichkeit zur Unterstützung Ihres Standpunkts. Wenn Sie auf Onlinevideo klicken.";
    var minTravelers = "12";
    var maxTravelers = "20";
    var tripBus = '<img src="assets/img/Bus%20travel.jpg" alt="Remove" border=3 width=300>';


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

    // Fill contents in cells
    cellTripImage.innerHTML = tripImage;
    cellTripName.innerHTML = tripName;
    cellTripDescription.innerHTML = tripDescription;
    cellMinTravelers.innerHTML = minTravelers;
    cellMaxTravelers.innerHTML = maxTravelers;
    cellTripBus.innerHTML = tripBus;        
    }

addTripFromDBtoTable();

</script>

</body>
</html>
</div>
            <div class="container-fluid text-center" style="margin-top: 50px;">
                <h4 class="text-center" style="margin-bottom: 16px;"><strong>Day programs of the selected trip.</strong><br></h4>
                <div><a class="btn btn-secondary" data-toggle="collapse" aria-expanded="false" aria-controls="collapse-1" role="button" href="#collapse-1" style="margin-bottom: 10px;">Show/hide day programs</a>
                    <div class="collapse" id="collapse-1"><!DOCTYPE html>
<html lang="en">
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container" style="font-family: Capriola, sans-serif;">

  <table id="dayProgramsOverviewTable" class="tableStyle">
    <thead>
      <tr>
        <th>Day</th>
        <th>Image</th>
        <th>Name</th>
        <th>Description</th>
        <th>Hotel name</th>
        <th>Hotel image</th>
        <th>Hotel description</th>
        <th>Hotel price</th>
      </tr>
    </thead>
    <tbody id="dayProgramsTableBody">
        <tr>
        <td></td>
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
function addDayProgramsFromDBtoTable() {

    var table = document.getElementById("dayProgramsOverviewTable");

    // Input data --> use a list from DB
    var dayProgramId = ["1", "2", "3"];
    var dayProgramDay = ["1", "2", "3"];
    var dayProgramImage = ['<img src="assets/img/paris.jpg" alt="Remove" border=3 width=300>', '<img src="assets/img/paris.jpg" alt="Remove" border=3 width=300>', '<img src="assets/img/paris.jpg" alt="Remove" border=3 width=300>'];
    var dayProgramName = ["Baden in Madrid", "Baden in Barcelona", "Baden in Valencia"];
    var dayProgramDescription = ["Video bietet eine leistungsstarke Möglichkeit zur Unterstützung", "Video bietet eine leistungsstarke Möglichkeit zur Unterstützung", "Video bietet eine leistungsstarke Möglichkeit zur Unterstützung"];
    var hotelName = ["Hotel Gehrig", "Hotel Vanessa", "Hotel Adrian"];
    var hotelImage = ['<img src="assets/img/Bus%20travel.jpg" alt="Remove" border=3 width=300>', '<img src="assets/img/Bus%20travel.jpg" alt="Remove" border=3 width=300>', '<img src="assets/img/Bus%20travel.jpg" alt="Remove" border=3 width=300>'];
    var hotelDescription = ["Video bietet eine leistungsstarke Möglichkeit zur Unterstützung", "Video bietet eine leistungsstarke Möglichkeit zur Unterstützung", "Video bietet eine leistungsstarke Möglichkeit zur Unterstützung"];
    var hotelPrice = ["100", "200", "300"];

    // Add all insurances to the table
    for (var i = 0; i < dayProgramId.length; i++) {

      // Create an empty <tr> element and add it at the end
      var indexOfNewRow = table.rows.length;
      var row = table.insertRow(indexOfNewRow);

      // Insert new cells (<td> elements)
      var celldayProgramDay = row.insertCell(0);
      var celldayProgramImage = row.insertCell(1);
      var celldayProgramName = row.insertCell(2);
      var celldayProgramDescription = row.insertCell(3);
      var cellhotelName = row.insertCell(4);
      var cellhotelImage = row.insertCell(5);
      var cellhotelDescription = row.insertCell(6);
      var cellhotelPrice = row.insertCell(7);

      // Fill contents in cells
      celldayProgramDay.innerHTML = dayProgramDay[i];
      celldayProgramImage.innerHTML = dayProgramImage[i];
      celldayProgramName.innerHTML = dayProgramName[i];
      celldayProgramDescription.innerHTML = dayProgramDescription[i];
      cellhotelName.innerHTML = hotelName[i];
      cellhotelImage.innerHTML = hotelImage[i];
      cellhotelDescription.innerHTML = hotelDescription[i];
      cellhotelPrice.innerHTML = hotelPrice[i];
    }
  }

addDayProgramsFromDBtoTable();

</script>

</body>
</html>
</div>
                </div>
            </div>
            <div class="container-fluid text-center" id="containerFinalInvoice" style="margin-top: 50px;">
                <h4 class="text-center" style="margin-bottom: 16px;"><strong>Final invoice for the selected trip.</strong><br></h4>
                <div class="border rounded-0 border-dark" style="padding-left: 15px;padding-top: 0px;padding-bottom: 0px;padding-right: 15px;background-color: rgba(255,255,255,0.61);">
                    <h4 class="text-left" style="margin-bottom: 16px;margin-top: 18px;min-width: 400px;"><strong>Your final invoice.</strong><br></h4>
                    <div class="table-responsive text-left" id="tableFinalInvoice">
                        <table class="table table-striped table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>Invoice type</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Download PDF</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Final</td>
                                    <td>Final invoice for trip "Badeferien in Spanien"</td>
                                    <td>21.10.2018</td>
                                    <td>1200.00</td>
                                    <td><a href="assets/img/Beach.jpg" download="Name of file">
  <img src="assets/img/paper-clip.png" alt="Download" width="25px" height="25px">
</a>
</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="border rounded-0 border-primary shadow form-container" id="divBookingForm" style="min-width: 400px;max-width: 632px;">
            <h2 class="text-center" style="margin-bottom: 16px;margin-top: 18px;min-width: 400px;"><strong>Book your trip.</strong><br></h2>
            <div style="margin-bottom: 15px;margin-left: 15px;">
                <form class="border-dark" action="index.php" method="post" id="tripBookingForm" style="background-color: rgba(96,175,221,0.21);padding-right: 25px;padding-left: 25px;min-width: 600px;background-image: url(&quot;assets/img/spanish%20beach.png&quot;);background-position: center;background-size: cover;background-repeat: no-repeat;">
                    <div class="form-group"><label style="color: #222222;"><strong>Departure date</strong></label><input class="form-control" type="date" name="departureDate" required=""></div>
                    <div class="form-group"><label style="margin-top: 13px;color: #222222;"><strong>Insurance (optional)</strong></label><select class="form-control" name="insurance" required="" id="insuranceDropdown"><optgroup label="Select insurance"><option value="" selected="">This is item 1</option><option value="">This is item 2</option><option value="" selected="">No insurance</option></optgroup></select></div>
                    <div
                        class="form-group"><label style="margin-top: 13px;color: #222222;"><strong>Participants (min. 11, max. 19)</strong></label><select class="form-control" name="participants" required="" multiple="" id="selectedParticipants" style="min-height: 200px;min-width: 180px;background-color: #f7f9fc;max-width: 500px;"><optgroup label="Select multiple with CTRL"><option value="nameParticipant1" selected="">Participant 1</option><option value="nameParticipant2">Participant 2</option><option value="nameParticipant3">Participant 3</option><option value="nameParticpant4">Participant 4</option></optgroup></select>
                        <div><label style="margin-left: 0px;margin-top: 25px;color: #222222;" for="tripPrice"><strong>Price</strong></label><input class="form-control" type="text" name="price" readonly="" id="price"></div>
            </div><button class="btn btn-primary" type="submit" style="margin-top: 21px;">Book your trip now</button></form>
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