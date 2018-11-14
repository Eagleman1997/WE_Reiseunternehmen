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
                <h2 class="text-center" style="margin-bottom: 16px;"><strong>Administer the selected trip template.</strong></h2>
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
                                            <th>Min. travelers</th>
                                            <th>Max. travelers</th>
                                            <th>Bus</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tripTableBody">
                                        <tr>
                                            <td><img src="<?php echo $tripTemplate->getPicturePath(); ?>" alt="Not available" border=3 width=150></td>
                                            <td><?php echo TemplateView::noHTML($tripTemplate->getName()); ?></td>
                                            <td><?php echo TemplateView::noHTML($tripTemplate->getDescription()); ?></td>
                                            <td><?php echo TemplateView::noHTML($tripTemplate->getMinAllocation()); ?></td>
                                            <td><?php echo TemplateView::noHTML($tripTemplate->getMaxAllocation()); ?></td>
                                            <td><?php echo TemplateView::noHTML($tripTemplate->getBus()->getName()) . " (seats: " . TemplateView::noHTML($tripTemplate->getBus()->getSeats()) . ")"; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </body>
                    </html>
                </div>
            </div>
            <div class="container-fluid text-center border rounded-0 border-dark" id="containerDayPrograms" style="margin-top: 50px;padding-top: 15px;padding-bottom: 15px;">
                <h4 class="text-center" style="margin-bottom: 16px;">Already added <strong>day programs</strong> of the selected trip.<br></h4>
                <div><a class="btn btn-secondary" data-toggle="collapse" aria-expanded="true" aria-controls="collapseDayPrograms" role="button" href="#collapseDayPrograms" style="margin-bottom: 10px;">Show/hide day programs</a>
                    <div class="collapse show" id="collapseDayPrograms">
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
                                                    <th>Delete</th>
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
                                                        <td><img src="assets/img/Recycle_Bin.png" alt="Remove" border=3 height=20 width=20></td>
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
                    <h5 class="mb-0"><a data-toggle="collapse" aria-expanded="false" aria-controls="accordionTripAdmin .item-1" href="div#accordionTripAdmin .item-1">Administration of day programs</a></h5>
                </div>
                <div class="collapse item-1" role="tabpanel" data-parent="#accordionTripAdmin">
                    <div class="card-body">
                        <div class="text-center border rounded border-info shadow d-flex d-sm-flex d-md-flex d-lg-flex justify-content-center justify-content-sm-center justify-content-md-center justify-content-lg-center"><form action="<?php echo $GLOBALS['ROOT_URL'] ?>/admin/tripTemplates/package/<?php echo $tripTemlate->getId(); ?>" method="put" class="d-md-flex justify-content-md-center" style="padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;">
                                <div class="text-center" >
                                    <p style="margin-bottom: 15px;margin-top: 15px;color: #000000;">Have you assigned all day programs to the trip?</p>
                                    <button class="btn btn-info" type="submit" id="btnDayProgramsComplete" style="margin-top: 0px;margin-bottom: 11px;">Make this trip bookable</button></div>
                            </form></div>
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