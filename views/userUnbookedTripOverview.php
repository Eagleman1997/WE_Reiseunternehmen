<?php

/**
 * @author Adrian Mathys
 */
use views\TemplateView;
use entities\User;
use entities\TripTemplate;

isset($this->tripTemplate) ? $tripTemplate = $this->tripTemplate : $tripTemplate = new TripTemplate();
isset($this->insurances) ? $insurances = $this->insurances : $insurances = array();
isset($this->user) ? $user = $this->user : $user = new User();
if(isset($this->user) and $this->user and $user->getParticipants()){
    $participants = $user->getParticipants(); 
}else{
    $participants = array();
} 
if(isset($this->tripTemplate) and $this->tripTemplate and $tripTemplate->getDayprograms()){
    $dayprograms = $tripTemplate->getDayprograms(); 
}else{
    $dayprograms = array();
}   
?>

<body>
    <div class="border rounded-0 register-photo" style="font-family: Capriola, sans-serif;background-size: auto;min-height: 900px;padding-top: 0px;">
        <div style="padding-bottom: 52px;">
            <div class="container-fluid" style="margin-top: 81px;">
                <h2 class="text-center" style="margin-bottom: 16px;"><strong>Overview of the selected trip.</strong><br></h2>
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
                                            <th>From CHF</th>
                                            <th>Min. CHF per person</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tripTableBody">
                                        <tr>
                                            <td><img src="<?php echo $tripTemplate->getPicturePath(); ?>" alt="Not available" border=3 width=150></td>
                                            <td><?php echo TemplateView::noHTML($tripTemplate->getName()); ?></td>
                                            <td><?php echo TemplateView::noHTML($tripTemplate->getDescription()); ?></td>
                                            <td><?php echo TemplateView::noHTML($tripTemplate->getMinAllocation()); ?></td>
                                            <td><?php echo TemplateView::noHTML($tripTemplate->getMaxAllocation()); ?></td>
                                            <td><img src="<?php if($tripTemplate->getBus()){echo TemplateView::noHTML($tripTemplate->getBus()->getPicturePath());} ?>" alt="Not available" border=3 width=200></td>
                                            <td><?php echo TemplateView::noHTML($tripTemplate->getCustomerPrice()); ?></td>
                                            <td><?php echo TemplateView::noHTML(round(($tripTemplate->getCustomerPrice()/$tripTemplate->getMinAllocation()) * 20, 0) / 20); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </body>
                    </html>
                </div>
            </div>
            <div class="container-fluid text-center border rounded-0 border-dark" id="containerDayPrograms" style="margin-top: 50px;padding-top: 15px;padding-bottom: 15px;">
                <h4 class="text-center" style="margin-bottom: 16px;"><strong>Day programs</strong> of the selected trip.<br></h4>
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
        <?php if(isset($_SESSION['login'])): ?>
        <div class="border rounded-0 border-primary shadow form-container" id="divBookingForm" style="min-width: 400px;max-width: 632px;">
            <h2 class="text-center" style="margin-bottom: 16px;margin-top: 18px;min-width: 400px;"><strong>Book your trip.</strong><br></h2>
            <div style="margin-bottom: 15px;margin-left: 15px;">
                <form class="border-dark" action="index.php" method="post" id="tripBookingForm" style="background-color: rgba(96,175,221,0.21);padding-right: 25px;padding-left: 25px;min-width: 600px;background-image: url(&quot;assets/img/spanish%20beach.png&quot;);background-position: center;background-size: cover;background-repeat: no-repeat;">
                    <div class="form-group"><label style="color: #222222;"><strong>Departure date</strong></label><input class="form-control" type="date" name="departureDate" required=""></div>
                    <div class="form-group"><label style="margin-top: 13px;color: #222222;"><strong>Insurance (optional)</strong></label><select class="form-control" name="insurance" required="" id="insuranceDropdown"><optgroup label="Select insurance">
                                <?php foreach ($insurances as $insurance) :  ?>
                                <option value="<?php echo "insurance".$insurance->getId();  ?>"><?php echo TemplateView::noHTML($insurance->getName())." (price per person: CHF ".$insurance->getCustomerPricePerPerson().")"; ?></option>
                                <?php endforeach;  ?><option value="0" selected="">No insurance</option>
                            </optgroup></select></div>
                    <div
                        class="form-group"><label style="margin-top: 13px;color: #222222;"><strong>Participants (min. 11, max. 19)</strong></label><select class="form-control" name="participants" required="" multiple="" id="selectedParticipants" style="min-height: 200px;min-width: 180px;background-color: #f7f9fc;max-width: 500px;"><optgroup label="Select multiple with CTRL">
                                <?php foreach ($participants as $participant) :  ?>
                                <option value="<?php echo "participant".$participant->getId();  ?>"><?php echo TemplateView::noHTML($participant->getFirstName()." ".$participant->getLastName()); ?></option>
                                <?php endforeach;  ?>
                            </optgroup></select>
                        <div><label style="margin-left: 0px;margin-top: 25px;color: #222222;" for="tripPrice"><strong>Price</strong></label><input class="form-control" value="<?php //echo $tripTemplate->getCustomerPrice(); ?>" type="text" name="price" readonly="" id="price"></div>
                    </div><button class="btn btn-primary" type="submit" style="margin-top: 21px;">Book your trip now</button></form>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                <?php 
                $insuranceCustomerPrices = array();
                foreach($insurances as $insurance){
                    array_push($insuranceCustomerPrices, $insurance->getCustomerPricePerPerson());
                }
                $js_array = json_encode($insuranceCustomerPrices);
                echo "var insurancePrices = ".$js_array.";\n";
                echo "var busPrice = ".$tripTemplate->getCustomerBusPrice().";\n";
                echo "var hotelPricePerPerson = ".$tripTemplate->getCustomerHotelPricePerPerson().";\n";
                echo "var minPrice = ".$tripTemplate->getCustomerPrice().";\n";
                ?>
                var insuranceDropdown = document.getElementById('insuranceDropdown');
                var participantsChoice = document.getElementById('selectedParticipants');
                document.getElementById("price").value = minPrice;
                
                function actualPriceCalculator(){
                    actualPrice = 0;
                    var index = insuranceDropdown.selectedIndex;
                    var count = $('#selectedParticipants option:selected').length;
                    
                    //ensures that the no insurance choice does not add any number or an invalid number to the actualPrice
                    if(!(index >= insurancePrices.length)){
                        actualPrice += insurancePrices[index]*(count+1);//+ the user
                    }
                    
                    //Ensures that the shown price never falls to a lower price than the price with the minAllocation
                    actualPrice = Math.max(actualPrice, minPrice);
                    
                    // Add that data to the input
                    document.getElementById("price").value = actualPrice;
                }    

                // When a new <option> is selected
                insuranceDropdown.addEventListener('change', function(){
                    actualPriceCalculator();
                })
                participantsChoice.addEventListener('change', function(){
                    actualPriceCalculator();
                })
            });
        </script>
        <?php endif; ?>
    </div>

    <script src="assets/js/Sidebar-Menu.js"></script>