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
    UserController::deleteUser($id);
    Router::redirect("/admin/users");
});

//Not in use
Router::route_auth("DELETE", "/profile", $authFunction, function () {
    if(UserController::deleteSelf()){
        Router::redirect("/logout");
    }
});

Router::route_auth("PUT", "/admin/users/{id}", $authFunction, function ($id) {
    UserController::changeRole($id);
    Router::redirect("/admin/users");
});

Router::route_auth("GET", "/travelers", $authFunction, function () {
    UserController::getParticipants();
});

Router::route_auth("POST", "/travelers", $authFunction, function () {
    UserController::createParticipant();
    Router::redirect("/travelers");
});

Router::route_auth("DELETE", "/travelers/{id}", $authFunction, function ($id) {
    UserController::deleteParticipant($id);
});

Router::route_auth("GET", "/admin/buses", $authFunction, function () {
    BusController::getAllBuses();
});

Router::route_auth("POST", "/admin/buses", $authFunction, function () {
    BusController::createBus();
    Router::redirect("/admin/buses");
});

Router::route_auth("DELETE", "/admin/buses/{id}", $authFunction, function ($id) {
    BusController::deleteBus($id);
});

Router::route_auth("GET", "/admin/hotels", $authFunction, function () {
    HotelController::getAllHotels();
});

Router::route_auth("POST", "/admin/hotels", $authFunction, function () {
    HotelController::createHotel();
    Router::redirect("/admin/hotels");
});

Router::route_auth("DELETE", "/admin/hotels/{id}", $authFunction, function ($id) {
    HotelController::deleteHotel($id);
});

Router::route_auth("GET", "/admin/insurances", $authFunction, function () {
    InsuranceController::getAllInsurances();
});

Router::route_auth("POST", "/admin/insurances", $authFunction, function () {
    InsuranceController::createInsurance();
    Router::redirect("/admin/insurances");
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

Router::route_auth("GET", "/bookedTrips/detail/{id}", $authFunction, function ($id) {
    TripController::getBookedTrip($id);
});

Router::route_auth("GET", "/admin/bookedTrips/detail/{id}", $authFunction, function ($id) {
    TripController::getBookedTrip($id);
});

Router::route_auth("POST", "/admin/bookedTrips/detail", $authFunction, function () {
    InvoiceController::createInvoice();
    //AJAX?
});

Router::route_auth("DELETE", "/admin/bookedTrips/detail/{id}", $authFunction, function ($id) {
    InvoiceController::deleteInvoice($id);
});

Router::route_auth("PUT", "/admin/bookedTrips/detail/{id}", $authFunction, function ($id) {
    TripController::changeInvoicesRegistered($id);
});

Router::route_auth("GET", "/admin/bookedTrips/detail/invoices/{id}", $authFunction, function ($id) {
    InvoiceController::getCustomersInvoice($id);
});

Router::route_auth("GET", "/bookedTrips/detail/invoices/{id}", $authFunction, function ($id) {
    InvoiceController::getCustomersInvoice($id);
});

Router::route_auth("GET", "admin/bookedTrips/detail/finalSettlement/{id}", $authFunction, function ($id) {
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





