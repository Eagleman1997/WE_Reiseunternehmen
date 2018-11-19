<?php

/**
 * @author Adrian Mathys
 */
use views\TemplateView;
use entities\Trip;
use entities\TripTemplate;
use entities\User;


isset($this->trip) ? $trip = $this->trip : $trip = new Trip();
if(isset($this->trip) and $trip){
    $tripTemplate = $trip->getTripTemplate();
}else{
    $tripTemplate = new TripTemplate();
}
if($tripTemplate->getDayprograms()){
    $dayprograms = $tripTemplate->getDayprograms();
}else{
    $dayprograms = array();
}
if(isset($this->trip) and $trip){
    $participants = $trip->getParticipants();
}else{
    $participants = array();
}
if(isset($this->trip) and $trip){
    $user = $trip->getUser();
}else{
    $user = new User();
}

?>


<body>
    <div class="border rounded-0 register-photo" style="font-family: Capriola, sans-serif;background-size: auto;min-height: 900px;padding-top: 0px;">
        <div style="padding-bottom: 52px;">
            <div class="container-fluid" style="margin-top: 81px;">
                <h2 class="text-center" style="margin-bottom: 16px;"><strong>Administer the selected trip.</strong></h2>
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
                <h4 class="text-center" style="margin-bottom: 16px;"><strong>User and participants</strong> of the selected trip.<br></h4>
                <div><a class="btn btn-secondary" data-toggle="collapse" aria-expanded="false" aria-controls="collapseParticipants" role="button" href="#collapseParticipants" style="margin-bottom: 10px;">Show/hide participants</a>
                    <div class="collapse" id="collapseParticipants">
                        <div>
                            <fieldset style="margin-bottom: 20px;margin-top: 10px;"><label>User</label><input type="text" name="userName" value="<?php echo TemplateView::noHTML($user->getFirstName()); ?>" disabled="" readonly="" style="margin-left: 10px;min-width: 263px;"></fieldset>
                        </div>
                        <div class="text-left">
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
                                                <?php foreach ($participants as $participant): ?>
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
                <h4 class="text-center" style="margin-bottom: 16px;"><strong>Day programs</strong> of the selected trip.<br></h4>
                <div><a class="btn btn-secondary" data-toggle="collapse" aria-expanded="false" aria-controls="collapseDayPrograms" role="button" href="#collapseDayPrograms" style="margin-bottom: 10px;">Show/hide day programs</a>
                    <div class="collapse" id="collapseDayPrograms">
                        <div class="text-left d-xl-flex justify-content-xl-center"><!DOCTYPE html>
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
                                                <?php foreach ($dayprograms as $dayprogram): ?>
                                                    <tr>
                                                        <td><?php echo TemplateView::noHTML($dayprogram->getDayNumber()); ?></td>
                                                        <td><img src="<?php echo TemplateView::noHTML($dayprogram->getPicturePath()); ?>" alt="Not available" border=3 width=150></td>
                                                        <td><?php echo TemplateView::noHTML($dayprogram->getName()); ?> </td>
                                                        <td><?php echo TemplateView::noHTML($dayprogram->getDescription()); ?> </td>
                                                        <td><?php if($dayprogram->getHotel()){echo TemplateView::noHTML($dayprogram->getHotel()->getName());} ?> </td>
                                                        <td><?php if($dayprogram->getHotel()): ?><img src="<?php echo TemplateView::noHTML($dayprogram->getHotel()->getPicturePath()); ?>" alt="Not available" border=3 width=150><?php endif; ?></td>
                                                        <td><?php if($dayprogram->getHotel()){echo TemplateView::noHTML($dayprogram->getHotel()->getDescription());} ?> </td>
                                                        <td><?php if($dayprogram->getHotel()){echo TemplateView::noHTML($dayprogram->getHotel()->getPricePerPerson());} ?> </td>
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
        </div>
        <div role="tablist" id="accordionTripAdmin" style="margin-left: 0px;">
            <div class="card">
                <div class="card-header" role="tab">
                    <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false" aria-controls="accordionTripAdmin .item-1" href="div#accordionTripAdmin .item-1">Administration of trip invoices</a></h5>
                </div>
                <div class="collapse item-1" role="tabpanel" data-parent="#accordionTripAdmin">
                    <div class="card-body">
                        <div class="text-center border rounded border-info shadow d-flex d-sm-flex d-md-flex d-lg-flex justify-content-center justify-content-sm-center justify-content-md-center justify-content-lg-center"><form action="<?php echo $GLOBALS['ROOT_URL'] ?>/admin/bookedTrips/detail/<?php echo $bookedTrip->getId(); ?>" method="get" class="d-md-flex justify-content-md-center" style="padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;">
                                <div class="text-center" >
                                    <p style="margin-bottom: 15px;margin-top: 15px;color: #000000;">Are there no more invoices to this trip?</p>
                                    <button class="btn btn-info" type="submit" id="btnInvoicesComplete" style="margin-top: 0px;margin-bottom: 11px;">Prepare final invoice</button></div>
                            </form></div>
                        <div id="collapseInvoices" style="margin-bottom: 0px;padding-bottom: 0px;padding-top: 0px;"><a class="btn btn-secondary" data-toggle="collapse" aria-expanded="false" aria-controls="collapse-2" role="button" href="#collapse-2" style="margin-top: 30px;">Show/hide all uploaded invoices</a>
                            <div class="collapse" id="collapse-2"
                                 style="margin-top: 0px;">
                                <div class="border rounded-0 border-dark" style="max-width: 800px;padding-left: 15px;padding-top: 0px;padding-bottom: 0px;padding-right: 15px;background-color: rgba(255,255,255,0.61);">
                                    <h4 class="text-left" style="margin-bottom: 16px;margin-top: 18px;min-width: 400px;"><strong>Already uploaded invoices.</strong><br></h4>
                                    <div class="table-responsive" id="tableUploadedInvoices">
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
                                                    <td>Hotel</td>
                                                    <td>Hotel Sternen</td>
                                                    <td>21.10.2018</td>
                                                    <td>120.00</td>
                                                    <td><a href="assets/img/Beach.jpg" download="Name of file">
                                                            <img src="assets/img/paper-clip.png" alt="Download" width="25px" height="25px">
                                                        </a>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Bus</td>
                                                    <td>Hotel Gehrig</td>
                                                    <td>05.09.2018</td>
                                                    <td>75.00</td>
                                                    <td><a href="assets/img/Bus%20travel.jpg" download="Name of file">
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
                        <div class="border rounded-0 border-primary shadow form-container" style="min-width: 400px;max-width: 632px;margin-top: 30px;">
                            <h4 class="text-center" style="margin-bottom: 16px;margin-top: 18px;min-width: 400px;"><strong>Add a new invoice to the trip.</strong><br></h4>
                            <div style="margin-bottom: 15px;margin-left: 15px;">
                                <form class="form-inline" action="index.php" method="post" enctype="multipart/form-data" id="invoiceForm" style="background-color: rgba(176,224,147,0.36);font-family: Capriola, sans-serif;padding-right: 0px;padding-bottom: 30px;padding-top: 0px;padding-left: 30px;min-width: 600px;">
                                    <div class="form-group" style="margin: 10px;width: 200px;margin-right: 50px;"><label class="labelsFormDayProgram">Type of invoice</label><select class="form-control" name="type" required="" id="type"><optgroup label="Select an invoice type"><option value="hotel" selected="">Hotel</option><option value="insurance">Insurance</option><option value="bus">Bus</option><option value="other">Other</option></optgroup></select></div>
                                    <div
                                        class="form-group" style="margin: 10px;margin-right: 50px;"><label class="labelsFormDayProgram">Description of invoice</label><textarea class="form-control" name="description" required="" minlength="3" id="description" style="width: 400px;margin-right: 0px;min-height: 80px;"></textarea></div>
                                    <div
                                        class="form-group" style="margin: 10px;"><label class="labelsFormDayProgram">Date of invoice</label><input class="form-control" type="date" name="date" required="" id="date"></div>
                                    <div class="form-group" style="margin: 10px;"><label class="labelsFormDayProgram">Amount of invoice</label><input class="form-control" type="number" name="price" required="" min="0" id="price"></div>
                                    <div class="form-group mt-auto" style="margin-right: 100px;padding: 10px;padding-right: 50px;margin-bottom: 20px;padding-bottom: 0px;"><label class="labelsFormDayProgram">PDF of invoice</label><input type="file" name="picturePath" required="" id="pdfPath" style="width: 400px;font-family: Capriola, sans-serif;background-color: #ffffff;margin-right: 0;"></div>
                                    <button
                                        class="btn btn-primary btn-block" type="submit" style="width: 100px;margin: 10px;margin-top: 50px;margin-left: 10px;">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="assets/js/Sidebar-Menu.js"></script>