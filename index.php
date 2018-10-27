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


//just for testing
$db = DBConnection::getDBConnection();



/*
 * this code just works with a manually setting of the $_SESSION['tripId'] in the DBConnector
$trip = new Trip();
$trip->setDepartureDate("2018-11-05");
$trip->setDescription("some random description about germany");
$trip->setDurationInDays(7);
$trip->setName("Trip in Germany");
$trip->setPicturePath("germany.jpg");
$trip->setPrice(2345.55);
$db->storeTrip($trip);

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
    $db->storeDayprogram($dayprogram);
}
 */



