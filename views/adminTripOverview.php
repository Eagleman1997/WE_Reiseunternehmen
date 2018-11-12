<?php

/**
 * @author Adrian Mathys
 */
use views\TemplateView;

isset($this->trips) ? $trips = $this->trips : $trips = array();
isset($this->invoices) ? $invoices = $this->invoices : $invoices = array();
isset($this->trips->getTripTemplate->getDayprograms) ? $dayprograms = $this->$dayprograms : $$dayprograms = array();


dayprograms
?>

<body>
    <div class="border rounded-0 register-photo" style="font-family: Capriola, sans-serif;background-size: auto;min-height: 900px;padding-top: 0px;">
        <div style="padding-bottom: 52px;">
            <div class="container" style="margin-top: 81px;">
                <h2 class="text-center" style="margin-bottom: 16px;"><strong>Administer the selected trip.</strong></h2><!DOCTYPE html>
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
                                        <th>Price</th>
                                        <th>Bus</th>
                                    </tr>
                                </thead>
                                <tbody id="tripTableBody">
                                    <?php foreach ($this->trips as $trips): ?>
                                        <tr>
                                            <td><?php echo TemplateView::noHTML($trips->getTripTemplate()->getPicturePath()); ?></td>
                                            <td><?php echo TemplateView::noHTML($trips->getTripTemplate()->getName()); ?> </td>
                                            <td><?php echo TemplateView::noHTML($trips->getTripTemplate()->getDescription()); ?> </td>
                                            <td><?php echo TemplateView::noHTML($trips->getDepartureDate()); ?> </td>
                                            <td><?php echo TemplateView::noHTML($trips->getTripTemplate()->getPrice()); ?> </td>
                                            <td><?php echo TemplateView::noHTML($trips->getTripTemplate()->getBus()->getPicturePath()); ?> </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                    </body>
                </html>
            </div>
            <div class="container-fluid text-center" style="margin-top: 50px;">
                <h4 class="text-center" style="margin-bottom: 16px;"><strong>Already added day programs of the selected trip.</strong><br></h4>
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
                                            <?php foreach ($this->dayprograms as $dayprogram): ?>
                                                <tr>
                                                    <td><?php echo TemplateView::noHTML($dayprogram->getDayNumber()); ?></td>
                                                    <td><?php echo TemplateView::noHTML($dayprogram->getPicturePath()); ?> </td>
                                                    <td><?php echo TemplateView::noHTML($dayprogram->getName()); ?> </td>
                                                    <td><?php echo TemplateView::noHTML($dayprogram->getDescription()); ?> </td>
                                                    <td><?php echo TemplateView::noHTML($dayprogram->getHotel()->getName()); ?> </td>
                                                    <td><?php echo TemplateView::noHTML($dayprogram->getHotel()->getPicturePath()); ?> </td>
                                                    <td><?php echo TemplateView::noHTML($dayprogram->getHotel()->getDescription()); ?> </td>
                                                    <td><?php echo TemplateView::noHTML($dayprogram->getHotel()->getPricePerPerson()); ?> </td>
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
        <div role="tablist" id="accordionTripAdmin" style="margin-left: 0px;">
            <div class="card">
                <div class="card-header" role="tab">
                    <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false" aria-controls="accordionTripAdmin .item-1" href="div#accordionTripAdmin .item-1">Administration of day programs</a></h5>
                </div>
                <div class="collapse item-1" role="tabpanel" data-parent="#accordionTripAdmin">
                    <div class="card-body">
                        <div class="border rounded-0 border-primary shadow form-container" style="min-width: 400px;max-width: 632px;margin-top: 30px;">
                            <h4 class="text-center" style="margin-bottom: 16px;margin-top: 18px;min-width: 400px;"><strong>Add a new day program to the trip.</strong><br></h4>
                            <div style="margin-bottom: 15px;margin-left: 15px;">
                                <form class="form-inline" action="packageoverview/package" method="post" enctype="multipart/form-data" id="dayProgramForm" style="background-color: rgba(147,198,224,0.36);font-family: Capriola, sans-serif;padding-right: 0px;padding-bottom: 30px;padding-top: 0px;padding-left: 30px;min-width: 600px;">
                                    <div class="form-group" style="margin: 10px;"><label class="labelsFormDayProgram">For which day of the trip would you like to add a day program?</label><input class="form-control" type="number" name="dayNumber" value="1" required="" min="1" max="7" step="1" id="dayNumber"></div>
                                    <div
                                        class="form-group" style="margin: 10px;"><label class="labelsFormDayProgram">Name of day program</label><textarea class="form-control" name="name" required="" minlength="3" id="name" style="width: 400px;margin-right: 0px;min-height: 80px;"></textarea></div>
                                    <div
                                        class="form-group" style="margin: 10px;margin-right: 50px;"><label class="labelsFormDayProgram">Description of day program</label><textarea class="form-control" name="description" required="" minlength="3" id="description" style="width: 400px;margin-right: 0px;min-height: 120px;"></textarea></div>
                                    <div
                                        class="form-group mt-auto" style="margin-right: 100px;padding: 10px;padding-right: 50px;margin-bottom: 20px;padding-bottom: 0px;"><label class="labelsFormDayProgram">Picture of day program</label><input type="file" name="picturePath" required="" id="image" style="width: 400px;font-family: Capriola, sans-serif;background-color: #ffffff;margin-right: 0;"></div>
                                    <div
                                        class="form-group" style="margin: 10px;width: 200px;margin-right: 50px;"><label class="labelsFormDayProgram">Hotel (if applicable)</label><select class="form-control" name="hotel" id="hotel"><optgroup label="Add a hotel"><option value="" selected="">No hotel needed</option><option value="" selected="">Hotel 1</option><option value="">Hotel 2</option><option value="">Hotel 3</option></optgroup></select></div>
                                    <div
                                        class="form-group" style="margin: 10px;width: 200px;margin-right: 50px;"><label class="labelsFormDayProgram">Make trip bookable?</label>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" name="isTripBookable" id="isTripBookable" style="width: 29px;margin-right: 10px;padding: 0px;"><label class="form-check-label" for="formCheck-1" style="font-size: 16px;width: 206px;">Yes, the day programs of this trip are complete.</label></div>
                                    </div><button class="btn btn-primary btn-block" type="submit" style="width: 100px;margin: 10px;margin-top: 50px;margin-left: 10px;">Save</button></form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" role="tab">
                    <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false" aria-controls="accordionTripAdmin .item-2" href="div#accordionTripAdmin .item-2">Administration of trip invoices</a></h5>
                </div>
                <div class="collapse item-2" role="tabpanel" data-parent="#accordionTripAdmin">
                    <div class="card-body">
                        <div style="margin-bottom: 0px;padding-bottom: 0px;padding-top: 0px;"><a class="btn btn-secondary" data-toggle="collapse" aria-expanded="false" aria-controls="collapse-2" role="button" href="#collapse-2">Show/hide all uploaded invoices</a>
                            <div class="collapse" id="collapse-2" style="margin-top: 0px;">
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
                                                <?php foreach ($this->invoices as $invoice): ?>
                                                    <tr>
                                                        <td><?php echo TemplateView::noHTML($invoice->getType()); ?></td>
                                                        <td><?php echo TemplateView::noHTML($invoice->getDescription()); ?> </td>
                                                        <td><?php echo TemplateView::noHTML($invoice->getDate()); ?> </td>
                                                        <td><?php echo TemplateView::noHTML($invoice->getPrice()); ?> </td>
                                                        <td><a href="<?php $invoice->getPdfPath(); ?>" download="Invoice">
                                                                <img src="assets/img/paper-clip.png" alt="Your invoice" width="25px" height="25px">
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
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
                                    <div class="form-group"
                                         style="margin: 10px;width: 200px;margin-right: 50px;"><label class="labelsFormDayProgram">Prepare final invoice?</label>
                                        <div class="form-check"><input class="form-check-input" type="checkbox" name="areInvoicesComplete" id="areInvoicesComplete" style="width: 29px;margin-right: 10px;padding: 0px;"><label class="form-check-label" for="formCheck-1" style="font-size: 16px;width: 206px;">Yes, this is the last invoice to this trip.</label></div>
                                    </div><button class="btn btn-primary btn-block" type="submit" style="width: 100px;margin: 10px;margin-top: 50px;margin-left: 10px;">Save</button></form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>