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
use controllers\ErrorController;

session_start();
require_once 'helpers/Autoloader.php';


//For testing purpose
/*
$trip = new Trip();
$trip->setId(5);
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
$invoice->setFkTripId(5);
$invoice->setPdfPath("views/assets/pdfs/ramdomPdf.pdf");
$invoice->setPrice(8888.03);
$invoice->setType("Insurance");
$invoice->create();
 */
/*
$trip = new Trip();
$trip->setDepartureDate("2019-12-31");
$trip->setFkInsuranceId(7);
$trip->setFkTripTemplateId(8);
$trip->setFkUserId(8);
$trip->setNumOfParticipation(12);
$participantIds = array(23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34);
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
    $dayprogram->setFkHotelId(3);
    $dayprogram->setFkTripTemplateId(8);
    $dayprogram->setName("Test dayprogram".$i);
    $dayprogram->setPicturePath("views/assets/img/defaultDayprogram.jpg");
    $dayprogram->create();
}
 */
/*
$tripTemplate = new TripTemplate();
$tripTemplate->setName("Trip to Testland");
$tripTemplate->setDescription("Test description");
$tripTemplate->setDurationInDays(6);
$tripTemplate->setFkBusId(5);
$tripTemplate->setMinAllocation(8);
$tripTemplate->setMaxAllocation(22);
$tripTemplate->setPicturePath("views/assets/img/defaultTripTemplate.jpg");
$tripTemplate->create();
 */
/*
$bus = new Bus();
$bus->setName("testBus");
$bus->setDescription("Normal bus");
$bus->setPicturePath("views/assets/img/defaultBus.jpg");
$bus->setPricePerDay(100.35);
$bus->setSeats(19);
$bus->create();
 */
/*
$hotel = new Hotel();
$hotel->setName("TestHotel");
$hotel->setDescription("Only schwoeschtere allowed!");
$hotel->setPricePerPerson(80.25);
$hotel->setPicturePath("someOtherPath.jpg");
$hotel->create();
 */
/*
for($i = 0; $i < 20; $i++){
$participant = new Participant();
$participant->setFirstName("Elise".$i);
$participant->setLastName("Merker".$i);
$participant->setBirthDate("1992-08-03");
$participant->setFkUserId(8);
$participant->create();
}
 */
/*
$user = new User();
$user->setFirstName("Admin");
$user->setLastName("Admin");
$user->setGender("male");
$user->setStreet("Adminstreet 1");
$user->setZipCode(9999);
$user->setLocation("Adminhausen");
$user->setEmail("Admin@admin.ch");
$user->setBirthDate("2000-01-01");
$user->setPassword("Admin");
$user->setRole("user");
 */


$authFunction = function () {
    if (AuthController::authenticate()){
        return true;
    }
    Router::redirect("/login");
    return false;
};

Router::route("GET", "/login", function () {
    AuthController::loginView();
});

Router::route("GET", "/registration", function () {
    AuthController::registerView();
});

Router::route("POST", "/registration", function () {
    UserController::register();
    Router::redirect("/");
});

Router::route("POST", "/login", function () {
    UserController::login();
    Router::redirect("/");
});

Router::route("GET", "/logout", function () {
    UserController::logout();
    Router::redirect("/login");
});

Router::route_auth("GET", "/", $authFunction, function () {
    UserController::getHomepage();
});

Router::route_auth("GET", "/admin", $authFunction, function () {
    UserController::getHomepage();
});

Router::route_auth("GET", "/admin/users", $authFunction, function () {
    UserController::getAllUsers();
});

Router::route_auth("DELETE", "/admin/users/{id}", $authFunction, function ($id) {
    if(UserController::deleteUser($id)){
        Router::redirect("/admin/users");
        //or with AJAX?
    }
});

//Not in use
Router::route_auth("DELETE", "/profile", $authFunction, function () {
    if(UserController::deleteSelf()){
        Router::redirect("/logout");
    }
});

Router::route_auth("PUT", "/admin/users/{id}", $authFunction, function ($id) {
    UserController::changeRole($id);
});

Router::route_auth("GET", "/travelers", $authFunction, function () {
    UserController::getParticipants();
});

Router::route_auth("POST", "/travelers", $authFunction, function () {
    if(UserController::createParticipant()){
        //Update with AJAX
    }
});

Router::route_auth("DELETE", "/travelers/{id}", $authFunction, function ($id) {
    UserController::deleteParticipant($id);
});

Router::route_auth("GET", "/admin/buses", $authFunction, function () {
    BusController::getAllBuses();
});

Router::route_auth("POST", "/admin/buses", $authFunction, function () {
    if(BusController::createBus()){
        //Update with AJAX
    }
});

Router::route_auth("DELETE", "/admin/buses/{id}", $authFunction, function ($id) {
    BusController::deleteBus($id);
});

Router::route_auth("GET", "/admin/hotels", $authFunction, function () {
    HotelController::getAllHotels();
});

Router::route_auth("POST", "/admin/hotels", $authFunction, function () {
    if(HotelController::createHotel()){
        //Update with AJAX
    }
});

Router::route_auth("DELETE", "/admin/hotels/{id}", $authFunction, function ($id) {
    HotelController::deleteHotel($id);
});

Router::route_auth("GET", "/admin/insurances", $authFunction, function () {
    InsuranceController::getAllInsurances();
});

Router::route_auth("POST", "/admin/insurances", $authFunction, function () {
    if(InsuranceController::createInsurance()){
        //Update with AJAX
    }
});

Router::route_auth("DELETE", "/admin/insurances/{id}", $authFunction, function ($id) {
    InsuranceController::deleteInsurance($id);
});

//no use of $authFunctin necessary to allow users without a loggin to see the packageOverview
Router::route("GET", "/packageOverview", function () {
    TripController::getAllTrips();
});

Router::route_auth("GET", "admin/packageOverview", $authFunction, function () {
        TripController::getAllTrips();
});

Router::route_auth("GET", "admin/tripTemplates", $authFunction, function () {
        TripController::getAllTripTemplates();
});

Router::route_auth("POST", "/admin/tripTemplates", $authFunction, function () {
    TripController::createTripTemplate();
    Router::redirect("/admin/tripTemplates");
});

Router::route_auth("DELETE", "/admin/tripTemplates/{id}", $authFunction, function ($id) {
    TripController::deleteTripTemplate($id);
});

Router::route("GET", "/packageOverview/package/{id}", function ($id) {
    TripController::getTripTemplate($id);
});

Router::route_auth("POST", "/packageOverview/package", $authFunction, function () {
    if(TripController::bookTrip()){
        Router::redirect("/bookedTrips");
    }
});

Router::route_auth("GET", "/admin/tripTemplates/package/{id}", $authFunction, function ($id) {
    TripController::getTripTemplate($id);
});

Router::route_auth("PUT", "/admin/tripTemplates/package/{id}", $authFunction, function ($id) {
    TripController::changeBookableOfTripTemplate($id);
});

Router::route_auth("POST", "/admin/tripTemplates/package", $authFunction, function () {
    if(TripController::createDayprogram()){
        //Update with AJAX
    }
});

Router::route_auth("DELETE", "/admin/tripTemplates/package/{id}", $authFunction, function ($id) {
    TripController::deleteDayprogram($id);
    //AJAX?
});

Router::route_auth("DELETE", "/admin/bookedTrips/{id}", $authFunction, function ($id) {
    TripController::cancelTrip($id);
    //AJAX?
});

Router::route_auth("GET", "/bookedtrips/detail/{id}", $authFunction, function ($id) {
    TripController::getBookedTrip($id);
});

Router::route_auth("GET", "/admin/bookedtrips/detail/{id}", $authFunction, function ($id) {
    TripController::getBookedTrip($id);
});

Router::route_auth("POST", "/admin/bookedtrips/detail", $authFunction, function () {
    InvoiceController::createInvoice();
    //AJAX?
});

Router::route_auth("DELETE", "/admin/bookedtrips/detail/{id}", $authFunction, function ($id) {
    InvoiceController::deleteInvoice($id);
});

Router::route_auth("PUT", "/admin/bookedtrips/detail/{id}", $authFunction, function ($id) {
    TripController::changeInvoicesRegistered($id);
});

Router::route_auth("GET", "/admin/bookedtrips/detail/invoices/{id}", $authFunction, function ($id) {
    InvoiceController::getCustomersInvoice($id);
});

Router::route_auth("GET", "/bookedtrips/detail/invoices/{id}", $authFunction, function ($id) {
    InvoiceController::getCustomersInvoice($id);
});

Router::route_auth("GET", "admin/bookedtrips/detail/finalSettlement/{id}", $authFunction, function ($id) {
    InvoiceController::getFinalSettlement($id);
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





