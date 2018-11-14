<?php

/**
 * @author Adrian Mathys
 */
use views\TemplateView;

isset($this->buses) ? $buses = $this->buses : $buses = array();
isset($this->tripTemplates) ? $tripTemplates = $this->tripTemplates : $tripTemplates = array();
?>

<body style="background-size: cover;background-repeat: no-repeat;background-position: center;background-color: rgb(241,247,252);">
    <h1 style="font-family: Capriola, sans-serif;padding: 20px;background-position: top;margin-bottom: 0px;">Administration of trip templates</h1>
    <section>
        <div id="wrapper">
            <div id="sidebar-wrapper" style="font-family: Capriola, sans-serif;">
                <ul class="sidebar-nav">
                    <li class="sidebar-brand"> <a href="<?php echo $GLOBALS['ROOT_URL'] ?>/admin"><strong>Administration main</strong></a></li>
                    <li> <a href="<?php echo $GLOBALS['ROOT_URL'] ?>/admin/tripTemplates" style="background-color: rgba(255,255,255,0.2);">Trip templates</a></li>
                    <li> </li>
                    <li> <a href="<?php echo $GLOBALS['ROOT_URL'] ?>/admin/users">Users</a></li>
                    <li> <a href="<?php echo $GLOBALS['ROOT_URL'] ?>/admin/hotels" >Hotels</a></li>
                    <li> <a href="<?php echo $GLOBALS['ROOT_URL'] ?>/admin/buses" >Buses</a></li>
                    <li> <a href="<?php echo $GLOBALS['ROOT_URL'] ?>/admin/insurances">Insurances</a></li>
                </ul>
            </div>
            <div class="page-content-wrapper">
                <div class="container-fluid" style="background-image: url(&quot;assets/img/Mountains.jpg&quot;);background-position: center;background-size: cover;background-repeat: no-repeat;padding-bottom: 33px;"><a class="btn btn-link bg-light" role="button" href="#menu-toggle" id="menu-toggle"><i class="fa fa-bars"></i></a>
                    <h2 class="text-center" style="font-family: Capriola, sans-serif;color: #000000;"><strong>Create a new trip template.</strong></h2>
                    <form class="form-inline pulse animated" action="<?php echo $GLOBALS['ROOT_URL'] ?>/admin/tripTemplates" method="post" enctype="multipart/form-data" id="tripTemplateForm" style="background-color: rgba(255,255,255,0.6);margin: 20px;padding: 20px;font-family: Capriola, sans-serif;">
                        <div class="form-group" style="margin: 10px;margin-right: 10px;width: 400px;"><label class="labelsFormTripTemplates">Trip name</label><textarea class="form-control" name="name" required="" minlength="3" style="width: 400px;"></textarea></div>
                        <div class="form-group" style="margin: 10px;"><label class="labelsFormTripTemplates">Description</label><textarea class="form-control" name="description" required="" minlength="3" style="width: 400px;margin-right: 0px;"></textarea></div>
                        <div class="form-group" style="margin: 10px;"><label class="labelsFormTripTemplates" style="padding: 0x;">Minimal number of participants</label><input class="form-control" type="number" name="minAllocation" value="12" required="" min="12" max="20" step="1" style="width: 100px;margin-right: 0px;"></div>
                        <div
                            class="form-group" style="margin: 10px;"><label class="labelsFormTripTemplates">Maximal number of participants</label><input class="form-control" type="number" name="maxAllocation" value="20" required="" min="12" max="20" step="1" style="width: 100px;margin-right: 0px;"></div>
                        <div
                            class="form-group" style="margin: 10px;">
                            <div><label class="labelsFormTripTemplates" style="width: 30px;">Bus</label><select class="form-control" name="busId" required="" id="busDropdownForTripTemplate" style="background-color: #ffffff;margin-right: 0px;"><optgroup label="Select bus">
                                        <?php foreach ($buses as $bus) :  ?>
                                        <option value="<?php echo $bus->getId();  ?>" selected=""><?php echo TemplateView::noHTML($bus->getName())." (seats: ".TemplateView::noHTML($bus->getSeats()).")"; ?></option>
                                        <?php endforeach;  ?>
                                    </optgroup></select></div>
                        </div>
                        <div class="form-group mt-auto" style="margin-right: 100px;padding: 10px;padding-right: 50px;margin-bottom: 20px;padding-bottom: 0px;"><label class="labelsFormTripTemplates" style="padding: 0;">Picture</label><input type="file" name="img" required="" style="width: 400px;font-family: Capriola, sans-serif;background-color: #ffffff;margin-right: 0;"></div>
                        <div class="form-group mt-auto"
                             style="margin-top: 0px;padding-top: 20px;"><button class="btn btn-primary" type="submit" style="width: 100px;margin: 10px;margin-top: 10px;margin-left: 10px;">Save</button></div>
                    </form>
                    <div style="background-color: rgba(255,255,255,0.53);padding-top: 0px;margin-top: 65px;margin-bottom: 65px;padding-bottom: 20px;">
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
                                                <th>From CHF</th>
                                                <th>Bus</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tripTemplateTableBody">
                                            <?php foreach ($tripTemplates as $tripTemplate) :  ?>
                                            <tr>
                                                <td><img src="<?php echo TemplateView::noHTML($tripTemplate->getPicturePath()); ?>" alt="Not available" border=3 width=150></td>
                                                <td><?php echo TemplateView::noHTML($tripTemplate->getName()); ?></td>
                                                <td><?php echo TemplateView::noHTML($tripTemplate->getDescription()); ?></td>
                                                <td><?php echo TemplateView::noHTML($tripTemplate->getMinAllocation()); ?></td>
                                                <td><?php echo TemplateView::noHTML($tripTemplate->getMaxAllocation()); ?></td>
                                                <td><?php echo TemplateView::noHTML($tripTemplate->getPrice()); ?></td>
                                                <td><?php echo TemplateView::noHTML($tripTemplate->getBus()->getName())."</br>(seats: ".TemplateView::noHTML($tripTemplate->getBus()->getSeats()).")"; ?></td>
                                                <td><a href="<?php echo $GLOBALS['ROOT_URL'] ?>/admin/tripTemplates/package/<?php echo $tripTemplate->getId(); ?>"><img src="assets/img/edit.png" alt="Edit" border=3 height=20 width=20></a></td>
                                                <td><form id="deleteTripTemplate<?php echo $tripTemplate->getId(); ?>" action="<?php echo $GLOBALS['ROOT_URL'] ?>/admin/tripTemplates/<?php echo $tripTemplate->getId(); ?>" method="post">
                                                        <input type="hidden" name="_method" value="DELETE"><img src="assets/img/Recycle_Bin.png" alt="Remove"  border=3 height=20 width=20 onclick="deleteHandler(<?php echo $tripTemplate->getId(); ?>)"></form></td>
                                            </tr>
                                            <?php endforeach;  ?>
                                        </tbody>
                                    </table>
                                </div>

                                <script>

                                    //Remove tripTemplate
                                    function deleteHandler(templateId){
                                        var c = confirm("Do you want to delete this trip template?");
                                        if(c){
                                            $( "#deleteTripTemplate"+templateId).submit();
                                        }
                                    }

                                    //Make the table searchable
                                    $(document).ready(function () {
                                        $("#tripTemplateInput").on("keyup", function () {
                                            var value = $(this).val().toLowerCase();
                                            $("#tripTemplateTableBody tr").filter(function () {
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
    <script src="assets/js/Sidebar-Menu.js"></script>