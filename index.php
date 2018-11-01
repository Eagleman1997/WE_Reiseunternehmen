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
use entities\Hotel;


session_start();
require_once '.\helpers\Autoloader.php';

//For testing purpose
/*
$hotel = new Hotel();
$hotel->setName("PussyHOtel");
$hotel->setDescription("Only schwoeschtere allowed!");
$hotel->setPricePerPerson(145.25);
$hotel->setPicturePath("someOtherPath.jpg");
$hotel->create();
 */
/*
$participant = new Participant();
$participant->setFirstName("Elise");
$participant->setLastName("Merker");
$participant->setBirthDate("1992-08-03");
$participant->setFkUserId(1);
$participant->createParticipant();
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



