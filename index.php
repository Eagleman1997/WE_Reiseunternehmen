<?php

use router\Router;
use http\HTTPException;
use http\HTTPHeader;
use http\HTTPStatusCode;

use controllers\AuthController;
use controllers\BusController;
use controllers\HotelController;
use controllers\InsuranceController;
use controllers\InvoiceController;
use controllers\TripController;
use controllers\UserController;

//just for testing purpose
use database\DBConnection;
use entities\User;
use entities\Trip;
use entities\Dayprogram;
use entities\Insurance;
use entities\Invoice;
use entities\Participant;
use database\UserDBC;
use database\HotelDBC;
use entities\Hotel;
use helpers\Validation;
use entities\Bus;
use database\BusDBC;
use entities\TripTemplate;
use database\TripDBC;
use database\InvoiceDBC;


session_start();
require_once '.\helpers\Autoloader.php';

//For testing purpose
/*
$trip = new Trip();
$trip->setId(3);
$newTrip = $trip->find();
echo "departureDate: ".$newTrip->getDepartureDate()."</br>";
echo "userFirstName: ".$newTrip->getUser()->getFirstName()."</br>";
echo "1 participant: ".$newTrip->getParticipants()[0]->getFirstName()."</br>";
echo "1 invoice: ".$newTrip->getInvoices()[0]->getDescription()."</br>";
echo "insurance: ".$newTrip->getInsurance()->getName()."</br>";
$tripTemplate = $newTrip->getTripTemplate();
echo "triptemplate: ".$tripTemplate->getName()."</br>";
echo "Bus: ".$tripTemplate->getBus()->getName()."</br>";
$dayprograms = $tripTemplate->getDayPrograms();
echo "dayprogram 1: ".$dayprograms[0]->getName()."</br>";
echo "Hotel: ".$dayprograms[0]->getHotel()->getName()."</br>";
 */
/*
$invoice = new Invoice();
$invoice->setDate("2231-03-05");
$invoice->setDescription("Insurance ZH-Versicherung");
$invoice->setFkTripId(2);
$invoice->setPdfPath("assets/pdfs/ramdomPdf.pdf");
$invoice->setPrice(8888.03);
$invoice->setType("Insurance");
$invoice->create();
 */
/*
$trip = new Trip();
$trip->setDepartureDate("2019-12-31");
$trip->setFkInsuranceId(2);
$trip->setFkTripTemplateId(7);
$trip->setFkUserId(3);
$trip->setNumOfParticipation(12);
$participantIds = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$trip->setParticipantIds($participantIds);
$trip->book();
 */
/*
$insurance = new Insurance();
$insurance->setName("Alices Insurance");
$insurance->setDescription("Only Alice can choose this kind of insurance");
$insurance->setPricePerPerson(23.20);
$insurance->create();
$insurance = new Insurance();
$insurance->setName("Common Insurance");
$insurance->setDescription("Everyone can choose this kind of insurance");
$insurance->setPricePerPerson(67.95);
$insurance->create();
$insurance = new Insurance();
$insurance->setName("Royal Insurance");
$insurance->setDescription("Only Royals are allowed to choose this");
$insurance->setPricePerPerson(150.00);
$insurance->create();
 */
/*
for($i = 0; $i < 5; $i++){
    $dayprogram = new Dayprogram();
    $dayprogram->setDayNumber($i+1);
    $dayprogram->setDescription("Test description".$i);
    $dayprogram->setFkHotelId(1);
    $dayprogram->setFkTripTemplateId(7);
    $dayprogram->setName("Test dayprogram".$i);
    $dayprogram->setPicturePath("assets/pictures/defaultDayprogram.jpg");
    $dayprogram->create();
}
 */
/*
$tripTemplate = new TripTemplate();
$tripTemplate->setName("Trip to Testland");
$tripTemplate->setDescription("Test description");
$tripTemplate->setDurationInDays(6);
$tripTemplate->setFk_bus_id(4);
$tripTemplate->setMinAllocation(8);
$tripTemplate->setMaxAllocation(22);
$tripTemplate->setPicturePath("assets/pictures/defaultTripTemplate.jpg");
$tripTemplate->create();
 */
/*
$bus = new Bus();
$bus->setName("testBus");
$bus->setDescription("Normal bus");
$bus->setPicturePath("assets/pictures/megaBus.jpg");
$bus->setPricePerDay(100.35);
$bus->setSeats(19);
$bus->create();
 */
/*
$hotel = new Hotel();
$hotel->setName("TestHotel");
$hotel->setDescription("Only schwoeschtere allowed!");
$hotel->setPricePerPerson(145.25);
$hotel->setPicturePath("someOtherPath.jpg");
$hotel->create();
 */
/*
for($i = 0; $i < 20; $i++){
$participant = new Participant();
$participant->setFirstName("Elise".$i);
$participant->setLastName("Merker".$i);
$participant->setBirthDate("1992-08-03");
$participant->setFkUserId(3);
$participant->create();
}
 */
/*
$user = new User();
$user->setFirstName("Adrian");
$user->setLastName("the weakest");
$user->setStreet("Weaklingstreet 23");
$user->setZipCode(6453);
$user->setLocation("Weakhausen");
$user->setEmail("Adrian.Weakling@theWeakest.com");
$user->setBirthDate("1996-10-21");
$user->setPassword("AdriansPassword");
$user->setRole("user");
        
echo "AdriansId: ".$user->register();
 */

/*
$authFunction = function () {
    if (AuthController::authenticate())
        return true;
    Router::redirect("/login");
    return false;
};

Router::route("GET", "/login", function () {
    AuthController::loginView();
});

Router::route("GET", "/register", function () {
    AuthController::registerView();
});

Router::route("POST", "/register", function () {
    if(UserController::register())
        Router::redirect("/logout");
});

Router::route("POST", "/login", function () {
    AuthController::login();
    Router::redirect("/");
});

Router::route("GET", "/logout", function () {
    AuthController::logout();
    Router::redirect("/login");
});

Router::route("POST", "/password/request", function () {
    AgentPasswordResetController::resetEmail();
    Router::redirect("/login");
});

Router::route("GET", "/password/request", function () {
    AgentPasswordResetController::requestView();
});

Router::route("POST", "/password/reset", function () {
    AgentPasswordResetController::reset();
    Router::redirect("/login");
});

Router::route("GET", "/password/reset", function () {
    AgentPasswordResetController::resetView();
});

Router::route_auth("GET", "/", $authFunction, function () {
    CustomerController::readAll();
});

Router::route_auth("GET", "/agent/edit", $authFunction, function () {
    AgentController::editView();
});

Router::route_auth("POST", "/agent/edit", $authFunction, function () {
    if(AgentController::update())
        Router::redirect("/logout");
});

try {
    HTTPHeader::setHeader("Access-Control-Allow-Origin: *");
    HTTPHeader::setHeader("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, HEAD");
    HTTPHeader::setHeader("Access-Control-Allow-Headers: Authorization, Location, Origin, Content-Type, X-Requested-With");
    if($_SERVER['REQUEST_METHOD']=="OPTIONS") {
        HTTPHeader::setStatusHeader(HTTPStatusCode::HTTP_204_NO_CONTENT);
    } else {
        Router::call_route($_SERVER['REQUEST_METHOD'], $_SERVER['PATH_INFO']);
    }
} catch (HTTPException $exception) {
    $exception->getHeader();
    ErrorController::show404();
}
 */



