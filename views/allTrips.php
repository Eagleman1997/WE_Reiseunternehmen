<?php
/**
 * @author Adrian Mathys
 */
use views\TemplateView;
use entities\TripTemplate;
use entities\Trip;

isset($this->tripTemplates) ? $tripTemplates = $this->tripTemplates : $tripTemplates = array();
isset($this->trips) ? $trips = $this->trips : $trips = array();

?>


<body style="background-color: rgb(241,247,252);font-family: Capriola, sans-serif;padding-bottom: 0px;">
    <div style="min-height: 850px;">
        <ul class="nav nav-tabs" style="margin-top: 15px;margin-bottom: 15px;">
            <li class="nav-item"><a class="nav-link active" role="tab" data-toggle="tab" href="#tab-1">All trips</a></li>
            <?php if(isset($_SESSION['login'])) : ?>
            <li class="nav-item"><a class="nav-link" role="tab" data-toggle="tab" href="#tab-2">Booked trips</a></li>
            <?php endif; ?>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" role="tabpanel" id="tab-1">
                <div class="container" style="font-family: Capriola, sans-serif;padding-top: 25px;padding-bottom: 0px;margin-top: 0px;margin-bottom: 120px;">
                    <div class="heading">
                        <h2 style="margin-bottom: 19px;">All available trips.</h2>
                    </div>
                    <div class="row">
                        <?php 
                        foreach ($tripTemplates as $tripTemplate) : ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0"><a href="<?php
                                    if(isset($_SESSION['role']) and $_SESSION['role'] == "admin"){
                                        $adminTemplatePath = $GLOBALS['ROOT_URL']."/admin/packageOverview/package/".$tripTemplate->getId();
                                        echo $adminTemplatePath;
                                    }else{
                                        $userTemplatePath = $GLOBALS['ROOT_URL']."/packageOverview/package/".$tripTemplate->getId();
                                        echo $userTemplatePath;
                                    }
                                    ?>"><img src="<?php echo TemplateView::noHTML($tripTemplate->getPicturePath()); ?>" alt="Card Image" class="card-img-top scale-on-hover"></a>
                                <div class="card-body">
                                    <h6><a href="<?php
                                    if(isset($_SESSION['role']) and $_SESSION['role'] == "admin"){
                                        echo $adminTemplatePath;
                                    }else{
                                        echo $userTemplatePath;
                                    }
                                    ?>"><?php echo TemplateView::noHTML($tripTemplate->getName()); ?></a></h6>
                                    <p class="text-muted card-text"><?php echo TemplateView::noHTML($tripTemplate->getDescription()); ?></p><strong class="d-lg-flex justify-content-lg-end align-items-lg-end priceTag">from CHF &nbsp &nbsp <?php echo TemplateView::noHTML($tripTemplate->getPrice()); ?></strong></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane" role="tabpanel" id="tab-2">
                <div class="container" style="font-family: Capriola, sans-serif;padding-top: 25px;padding-bottom: 0px;margin-top: 0px;margin-bottom: 40px;">
                    <div class="heading">
                        <h2 style="margin-bottom: 19px;"><?php 
                        if(isset($_SESSION['role']) and $_SESSION['role'] == "admin"){
                            echo "All booked trips.";
                        }else{
                            echo "All trips you have booked.";
                        }
                            ?></h2>
                    </div>
                    <div class="row">
                        <?php 
                        foreach ($trips as $trip) : ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0"><a href="<?php
                                    if(isset($_SESSION['role']) and $_SESSION['role'] == "admin"){
                                        $adminTripPath = $GLOBALS['ROOT_URL']."/admin/bookedtrips/detail/".$trip->getId();
                                        echo $adminTripPath;
                                    }else{
                                        $userTripPath = $GLOBALS['ROOT_URL']."/bookedtrips/detail/".$trip->getId();
                                        echo $userTripPath;
                                    }
                                    ?>"><img src="<?php echo TemplateView::noHTML($trip->getTripTemplate()->getPicturePath()); ?>" alt="Card Image" class="card-img-top scale-on-hover"></a>
                                <div class="card-body">
                                    <h6><a href="<?php
                                    if(isset($_SESSION['role']) and $_SESSION['role'] == "admin"){
                                        echo $adminTripPath;
                                    }else{
                                        echo $userTripPath;
                                    }
                                    ?>"><?php echo TemplateView::noHTML($trip->getTripTemplate()->getName()); ?></a></h6>
                                    <p class="text-muted card-text"><?php echo TemplateView::noHTML($trip->getTripTemplate()->getDescription()); ?></p><strong class="d-lg-flex justify-content-lg-end align-items-lg-end priceTag">CHF &nbsp &nbsp<?php echo TemplateView::noHTML($trip->getPrice()); ?></strong></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>