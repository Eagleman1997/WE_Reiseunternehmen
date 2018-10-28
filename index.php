<?php

use router\Router;
use http\HTTPException;
use http\HTTPHeader;
use http\HTTPStatusCode;

//just for testing
use helpers\database\DBConnection;
use entities\User;
use entities\Trip;
use entities\Dayprogram;


session_start();
require_once '.\helpers\Autoloader.php';


//just for testing purpose
$db = DBConnection::getDBConnection();

/*
Test of getting a Trip object with the according Dayprograms by the given TripId
$trip = $db->getTripById(12);
$trip->addDayprograms();
echo "Tripname: ".$trip->getName();
$dayprograms = $trip->getDayprograms();
foreach($dayprograms as $value){
    echo "</br>Dayprogramname: ".$value->getName();
}
*/
/*
Adds a new trip with some data to db (tested)
$trip = new Trip();
$trip->setDepartureDate("2018-10-25");
$trip->setDescription("some random description about germany");
$trip->setDurationInDays(7);
$trip->setName("Trip in Austria");
$trip->setPicturePath("austria.jpg");
$trip->setPrice(2345.55);
$trip->setMaxStaffing(12);
$trip->storeTrip($trip);

$names = ["firstTrip", "secondTrip", "thirdTrip", "fourthTrip", "fifthTrip"];
$picturePaths = ["path1.jpg", "path2.jpg", "path3.jpg", "path4.jpg", "path5.jpg"];
$dates = ["2018-11-05", "2018-11-06", "2018-11-07", "2018-11-08", "2018-11-09"];
$descriptions = ["description1", "description2", "description3", "description4", "description5"];
$hotelNames = ["hotelName1", "hotelName2", "hotelName3", "hotelName4", "hotelName5"];

for($i=0;$i<5;$i++){
    $dayprogram = new Dayprogram();
    $dayprogram->setName($names[$i]);
    $dayprogram->setPicturePath($picturePaths[$i]);
    $dayprogram->setDate($dates[$i]);
    $dayprogram->setDescription($descriptions[$i]);
    $dayprogram->setHotelName($hotelNames[$i]);
    $dayprogram->setFkTripId($_SESSION['tripId']);
    $dayprogram->storeDayprogram($dayprogram);
}
*/



