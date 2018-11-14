<?php

/**
 * @author Adrian Mathys
 */
use views\TemplateView;

?>

<body>
    <div class="border rounded-0 register-photo" style="font-family: Capriola, sans-serif;background-size: auto;min-height: 900px;padding-top: 0px;">
        <div style="padding-bottom: 52px;">
            <div class="container-fluid" style="margin-top: 81px;">
                <h2 class="text-center" style="margin-bottom: 16px;"><strong>Overview of your booked trip.</strong><br></h2>
                <div class="scrollableDiv"><!DOCTYPE html>
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
                                            <th>Departure date</th>
                                            <th>Insurance</th>
                                            <th>Bus</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tripTableBody">
                                        <tr>
                                            <td><img src="<?php echo $tripTemplate->getPicturePath(); ?>" alt="Not available" border=3 width=150></td>
                                            <td><?php echo TemplateView::noHTML($tripTemplate->getName()); ?></td>
                                            <td><?php echo TemplateView::noHTML($tripTemplate->getDescription()); ?></td>
                                            <td><?php echo TemplateView::noHTML($trip->getDepartureDate()); ?></td>
                                            <td><?php echo TemplateView::noHTML($trip->getInsurance()->getName()); ?></td>
                                            <td><?php echo TemplateView::noHTML($tripTemplate->getBus()->getName()) . " (seats: " . TemplateView::noHTML($tripTemplate->getBus()->getSeats()) . ")"; ?></td>
                                            <td><?php echo TemplateView::noHTML($trip->getPrice()); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </body>
                    </html>
                </div>
            </div>
            <div class="container-fluid text-center border rounded-0 border-dark" id="containerTripParticipants" style="margin-top: 50px;padding-top: 15px;padding-bottom: 15px;">
                <h4 class="text-center" style="margin-bottom: 16px;"><strong>Participants</strong> of the trip.<br></h4>
                <div><a class="btn btn-secondary" data-toggle="collapse" aria-expanded="false" aria-controls="collapseParticipants" role="button" href="#collapseParticipants" style="margin-bottom: 10px;">Show/hide participants</a>
                    <div class="collapse" id="collapseParticipants">
                        <div>
                            <fieldset style="margin-bottom: 20px;margin-top: 10px;"><label>User</label><input type="text" name="userName" value="<?php echo TemplateView::noHTML($user->getFirstName()); ?>" disabled="" readonly="" style="margin-left: 10px;min-width: 263px;"></fieldset>
                        </div>
                        <div class="text-left scrollableDiv">
                            <!DOCTYPE html>
                            <html lang="en">
                                <head>
                                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
                                </head>
                                <body>

                                    <div class="container" style="font-family: Capriola, sans-serif;">

                                        <input class="form-control" id="tripParticipantInput" type="text" placeholder="Search participants...">
                                        <br>
                                        <table id="tripParticipantTable" class="tableStyle">
                                            <thead>
                                                <tr>
                                                    <th>First name</th>
                                                    <th>Last name</th>
                                                    <th>Birth date</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tripParticipantTableBody">
                                                <?php foreach ($this->participants as $participant): ?>
                                                    <tr>
                                                        <td><?php echo TemplateView::noHTML($participant->getFirstName()); ?></td>
                                                        <td><?php echo TemplateView::noHTML($participant->getLastName()); ?> </td>
                                                        <td><?php echo TemplateView::noHTML($participant->getBirthDate()); ?> </td>
                                                    <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <script>

                                        //Make the table searchable
                                        $(document).ready(function () {
                                            $("#tripParticipantInput").on("keyup", function () {
                                                var value = $(this).val().toLowerCase();
                                                $("#tripParticipantTableBody tr").filter(function () {
                                                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                                                });
                                            });
                                        });

                                    </script>

                                </body>
                            </html></div>
                    </div>
                </div>
            </div>
            <div class="container-fluid text-center border rounded-0 border-dark" id="containerDayPrograms" style="margin-top: 50px;padding-top: 15px;padding-bottom: 15px;">
                <h4 class="text-center" style="margin-bottom: 16px;"><strong>Day programs</strong> of the trip.<br></h4>
                <div><a class="btn btn-secondary" data-toggle="collapse" aria-expanded="false" aria-controls="collapseDayPrograms" role="button" href="#collapseDayPrograms" style="margin-bottom: 10px;">Show/hide day programs</a>
                    <div class="collapse" id="collapseDayPrograms">
                        <div class="text-left d-xl-flex justify-content-xl-center scrollableDiv"><!DOCTYPE html>
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
                                                <?php foreach ($this->trips as $trips): ?>
                                                    <tr>
                                                        <td><?php echo TemplateView::noHTML($trips->getTripTemplate()->getDayprograms()->getDayNumber()); ?></td>
                                                        <td><?php echo TemplateView::noHTML($trips->getTripTemplate()->getDayprograms()->getPicturePath()); ?> </td>
                                                        <td><?php echo TemplateView::noHTML($trips->getTripTemplate()->getDayprograms()->getName()); ?> </td>
                                                        <td><?php echo TemplateView::noHTML($trips->getTripTemplate()->getDayprograms()->getDescription()); ?> </td>
                                                        <td><?php echo TemplateView::noHTML($trips->getTripTemplate()->getDayprograms()->getHotel()->getName()); ?> </td>
                                                        <td><?php echo TemplateView::noHTML($trips->getTripTemplate()->getDayprograms()->getHotel()->getPicturePath()); ?> </td>
                                                        <td><?php echo TemplateView::noHTML($trips->getTripTemplate()->getDayprograms()->getHotel()->getDescription()); ?> </td>
                                                        <td><?php echo TemplateView::noHTML($trips->getTripTemplate()->getDayprograms()->getHotel()->getPrice()); ?> </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </body>
                            </html>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid text-center" id="containerInvoice" style="margin-top: 50px;">
                <h4 class="text-center" style="margin-bottom: 16px;"><strong>Invoice </strong>for the trip.<br></h4>
                <div class="border rounded-0 border-dark scrollableDiv" style="padding-left: 15px;padding-top: 0px;padding-bottom: 0px;padding-right: 15px;background-color: rgba(255,255,255,0.61);">
                    <h4 class="text-left" style="margin-bottom: 16px;margin-top: 18px;min-width: 400px;"><strong>Your invoice.</strong><br></h4>
                    <div class="table-responsive text-left" id="tableFinalInvoice">
                        <table class="table table-striped table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Download PDF</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
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
    </div>

    <script src="assets/js/Sidebar-Menu.js"></script>
