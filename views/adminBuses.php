<?php

/**
 * @author Adrian Mathys
 */
use views\TemplateView;

isset($this->buses) ? $buses = $this->buses : $buses = array();

?>

<body style="background-size: cover;background-repeat: no-repeat;background-position: center;background-color: rgb(241,247,252);">
    <h1 style="font-family: Capriola, sans-serif;padding: 20px;background-position: top;margin-bottom: 0px;">Administration of buses</h1>
    <section>
        <div id="wrapper">
            <div id="sidebar-wrapper" style="font-family: Capriola, sans-serif;">
                <ul class="sidebar-nav">
                    <li class="sidebar-brand"> <a href="<?php echo $GLOBALS['ROOT_URL'] ?>/admin"><strong>Administration main</strong></a></li>
                    <li> <a href="<?php echo $GLOBALS['ROOT_URL'] ?>/admin/tripTemplates">Trip templates</a></li>
                    <li> </li>
                    <li> <a href="<?php echo $GLOBALS['ROOT_URL'] ?>/admin/users">Users</a></li>
                    <li> <a href="<?php echo $GLOBALS['ROOT_URL'] ?>/admin/hotels">Hotels</a></li>
                    <li> <a href="<?php echo $GLOBALS['ROOT_URL'] ?>/admin/buses" style="background-color: rgba(255,255,255,0.2);">Buses</a></li>
                    <li> <a href="<?php echo $GLOBALS['ROOT_URL'] ?>/admin/insurances">Insurances</a></li>
                </ul>
            </div>
            <div class="page-content-wrapper">
                <div class="container-fluid" style="background-image: url(&quot;assets/img/rome.jpg&quot;);background-position: center;background-size: cover;background-repeat: no-repeat;min-height: 900px;margin-bottom: 0px;padding-bottom: 40px;"><a class="btn btn-link bg-light" role="button" href="#menu-toggle" id="menu-toggle"><i class="fa fa-bars"></i></a>
                    <h2 class="text-center" style="font-family: Capriola, sans-serif;color: #000000;"><strong>Add a new bus.</strong></h2>
                    <form class="form-inline pulse animated" action="<?php echo $GLOBALS['ROOT_URL'] ?>/admin/buses" method="post" enctype="multipart/form-data" id="busForm" style="background-color: rgba(255,255,255,0.72);margin: 20px;padding: 20px;font-family: Capriola, sans-serif;">
                        <div class="form-group" style="width: 400px;margin: 10px;margin-right: 10px;"><label class="labelsFormTripTemplates">Bus name</label><textarea class="form-control" name="name" required="" minlength="3" style="width: 400px;"></textarea></div>
                        <div class="form-group" style="margin: 10px;"><label class="labelsFormTripTemplates">Description</label><textarea class="form-control" name="description" required="" minlength="3" style="margin-right: 0px;width: 400px;"></textarea></div>
                        <div class="form-group" style="margin: 10px;width: 150px;"><label class="labelsFormTripTemplates" style="padding: 0x;">Number of seats</label><input class="form-control" type="number" name="seats" value="12" required="" min="12" step="1" style="width: 100px;margin-right: 0px;"></div>
                        <div
                            class="form-group" style="margin: 10px;width: 200px;margin-right: 50px;"><label class="labelsFormTripTemplates">Price per day</label><input class="form-control" type="number" name="pricePerDay" step="0.05" required="" min="1"></div>
                        <div class="form-group mt-auto" style="margin-right: 100px;padding: 10px;padding-right: 50px;margin-bottom: 20px;padding-bottom: 0px;"><label class="labelsFormTripTemplates" style="padding: 0;">Picture</label><input type="file" name="img" required="" style="font-family: Capriola, sans-serif;background-color: #ffffff;margin-right: 0;width: 400px;"></div>
                        <div class="form-group mt-auto"
                             style="margin-top: 0px;padding-top: 20px;"><button class="btn btn-primary btn-block" type="submit" style="width: 100px;margin: 10px;margin-top: 10px;margin-left: 10px;">Save</button></div>
                    </form>
                    <div style="font-family: Capriola, sans-serif;margin-bottom: 40px;padding-bottom: 20px;margin-top: 65px;min-width: 705px;background-color: rgba(255,255,255,0.72);">
                        <h2 class="text-center" style="margin-bottom: 16px;padding: 0px;padding-top: 23px;"><strong>Overview of added buses.</strong></h2><!DOCTYPE html>
                        <html lang="en">
                            <head>
                                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
                            </head>
                            <body>

                                <div class="container" style="font-family: Capriola, sans-serif;">

                                    <input class="form-control" id="busInput" type="text" placeholder="Search bus...">
                                    <br>
                                    <table id="busOverviewTable" class="tableStyle">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Bus name</th>
                                                <th>Description</th>
                                                <th>Number of seats</th>
                                                <th>Price per day</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="busTableBody">
                                            <?php foreach ($this->buses as $bus): ?>
                                                <tr>
                                                    <td><img src="<?php echo TemplateView::noHTML($bus->getPicturePath()); ?>" alt="Not available" border=3 width=200></td>
                                                    <td><?php echo TemplateView::noHTML($bus->getName()); ?> </td>
                                                    <td><?php echo TemplateView::noHTML($bus->getDescription()); ?> </td>
                                                    <td><?php echo TemplateView::noHTML($bus->getSeats()); ?> </td>
                                                    <td><?php echo TemplateView::noHTML($bus->getPricePerDay()); ?> </td>
                                                    <td><img data-href="user/delete?id=<?php echo $bus->getId(); ?>" src="assets/img/Recycle_Bin.png" alt="Remove" border=3 height=20 width=20></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <script>

                                    // Remove buses from the database
                                    table = document.getElementById("busOverviewTable");
                                    for (var i = 1; i < table.rows.length; i++)
                                    {
                                        table.rows[i].cells[5].onclick = function () {
                                            var c = confirm("Do you want to delete this bus?");
                                            if (c == true)
                                            {
                                                index = this.parentElement.rowIndex;
                                                table.deleteRow(index);
                                                // send index to database in order to delete the bus
                                            }
                                        }
                                    }

                                    //Make the table searchable
                                    $(document).ready(function () {
                                        $("#busInput").on("keyup", function () {
                                            var value = $(this).val().toLowerCase();
                                            $("#busTableBody tr").filter(function () {
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