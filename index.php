<?php

use router\Router;
use http\HTTPException;
use http\HTTPHeader;
use http\HTTPStatusCode;

//just for testing
use helpers\database\DBConnection;
use entities\User;
use entities\Trip;


session_start();
require_once '.\helpers\Autoloader.php';


//just for testing
$db = DBConnection::getDBConnection();
$trip = new Trip();
$trip->setDepartureDate("2018-11-03");
$trip->setDescription("some random description");
$trip->setDurationInDays(5);
$trip->setName("Trip through Italy");
$trip->setPicturePath("somepath.jpg");
$trip->setPrice(1045.35);
$db->storeTrip($trip);




