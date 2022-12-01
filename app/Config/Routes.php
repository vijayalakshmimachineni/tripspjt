<?php

namespace Config; 

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}
/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
// $routes->get('/curlHome','Home::home_url');

/*Treks*/
$routes->get('/trekList/','Treklist::index');
$routes->get('/trekFaq/(:num)','Treklist::trekfaq/$1');
$routes->get('/addTrekFaq/(:num)','Treklist::addFaq/$1');
$routes->post('/saveFaq','Treklist::saveFaq');
$routes->get('/editTrekFaq/(:num)','Treklist::editFaq/$1');
$routes->post('/updateFaq','Treklist::updateFaq');
$routes->get('/deleteTrekFaq/(:num)/(:num)','Treklist::deleteTrekFaq/$1/$2');
$routes->get('/trekGallery/(:num)','Treklist::trekGallery/$1');
$routes->post('/addgallerydetails/(:num)','Treklist::addgallerydetails/$1');

$routes->get('/trekItinerary/(:num)', 'Treklist::gettrekitinerary/$1');
$routes->post('/trekiterinarystore', 'Treklist::trekiterinarystore');
$routes->get('/addTrek', 'Treklist::addTrek');
$routes->post('/storetrek', 'Treklist::storetrek');
$routes->get('/editTrek/(:num)', 'Treklist::gettrek/$1');
$routes->post('/updateTrek', 'Treklist::updateTrek');
$routes->post('/fileupload', 'Treklist::fileupload');

/* Bike Trips */
$routes->get('/bikeTripList/','Biketrip::index');
$routes->get('/biketripFaq/(:num)','Biketrip::biketripFaq/$1');
$routes->get('/addBikeFaq/(:num)','Biketrip::addBikeFaq/$1');
$routes->post('/saveBikeFaq','Biketrip::saveFaq');
$routes->get('/editBikeFaq/(:num)','Biketrip::editFaq/$1');
$routes->post('/updateBikeFaq','Biketrip::updateFaq');
$routes->get('/deleteBikeFaq/(:num)/(:num)','Biketrip::deleteBikeFaq/$1/$2');
$routes->get('/biketripGallery/(:num)','Biketrip::tripGallery/$1');
$routes->post('/addTripgallerydetails/(:num)','Biketrip::addgallerydetails/$1');

$routes->get('/bikeTripItinerary/(:num)', 'Biketrip::biketripItinerary/$1');
$routes->post('biketripIterinaryStore','Biketrip::biketripiterinarystore');
$routes->get('/addBikeTrip', 'Biketrip::addBikeTrip');
$routes->post('/storeBiketrip', 'Biketrip::storeBiketrip');
$routes->get('/getBiketrip/(:any)', 'Biketrip::getBikeTrip/$1');
$routes->post('/editBiketrip', 'Biketrip::editBikeTrip');
$routes->post('/biketripiterinarystore', 'Biketrip::biketripiterinarystore');
$routes->post('/bikefileupload', 'Biketrip::fileupload');

/* Expenditions */
$routes->get('/expeditionsList/','Expeditions::index');
$routes->get('/expeditionsFaq/(:num)','Expeditions::expeditionFaq/$1');
$routes->get('/addExpeditionFaq/(:num)','Expeditions::addExpeditionFaq/$1');
$routes->post('/saveExpeditionFaq','Expeditions::saveFaq');
$routes->get('/editExpeditionFaq/(:num)','Expeditions::editFaq/$1');
$routes->post('/updateExpeditionFaq','Expeditions::updateFaq');
$routes->get('/deleteExpeditionFaq/(:num)/(:num)','Expeditions::deleteExpeditionFaq/$1/$2');
$routes->get('/expeditionGallery/(:num)','Expeditions::expeditionGallery/$1');
$routes->post('/addExpgallerydetails/(:num)','Expeditions::addGalleryDetails/$1');


$routes->get('/expeditionitinerary', 'Expeditions::expeditionitinerary');
$routes->get('/addexpedition', 'Expeditions::addexpedition');
$routes->get('/getexpedition/(:any)', 'Expeditions::getexpedition/$1');
$routes->post('/editexpedition', 'Expeditions::editExpedition');
$routes->post('/storeexpedition', 'Expeditions::storeexpedition');
$routes->get('/getexpeditionitinerary/(:any)', 'Expeditions::getExpeditionitinerary/$1');
$routes->post('/expeditioniterinarystore', 'Expeditions::expeditioniterinarystore');
$routes->post('/expeditionFileupload', 'Expeditions::fileupload');
$routes->get('/deleteexpeditionitinerary/(:any)', 'Expeditions::deleteitineraryExpedition/$1');
$routes->get('/deleteexpedition/(:any)', 'Expeditions::deleteexpedition/$1');


/*leisure packages*/
$routes->get('/leisurepackagesList/','LeisurePackages::index');
$routes->get('/leisurepackagesFaq/(:num)','LeisurePackages::leisurePackagesFaq/$1');
$routes->get('/addLeisurepackagesFaq/(:num)','LeisurePackages::addLeisurePackagesFaq/$1');
$routes->post('/saveLpFaq','LeisurePackages::saveFaq');
$routes->get('/editLpFaq/(:num)','LeisurePackages::editFaq/$1');
$routes->post('/updateLpFaq','LeisurePackages::updateFaq');
$routes->get('/deleteLpFaq/(:num)/(:num)','LeisurePackages::deleteLeisurePackagesFaq/$1/$2');
$routes->get('/leisurepackageGallery/(:num)','LeisurePackages::leisurepackageGallery/$1');
$routes->post('/addLpgallerydetails/(:num)','LeisurePackages::addGalleryDetails/$1');

$routes->get('/leisureitinerary', 'LeisurePackages::leisureitinerary');
$routes->get('/addleisure', 'LeisurePackages::addLeisure');
$routes->post('/storeleisure', 'LeisurePackages::storeleisure');
$routes->get('/getLeisure/(:any)', 'LeisurePackages::getleisure/$1');
$routes->get('/getLeisureitinerary/(:any)', 'LeisurePackages::getleisureitinerary/$1');
$routes->post('/leisureiterinarystore', 'LeisurePackages::leisureiterinarystore');
$routes->post('/editLeisure', 'LeisurePackages::editleisure');
$routes->get('/deleteLeisure/(:any)', 'LeisurePackages::deleteLeisure/$1');
$routes->get('/deleteitineraryLeisure/(:any)', 'LeisurePackages::deleteitineraryLeisure/$1');
$routes->post('/storeLeisure', 'LeisurePackages::storeleisure');
$routes->post('/leisureFileupload', 'LeisurePackages::fileupload');

/* Hostels */
$routes->get('/hostelsList/','Hostels::index');
$routes->get('/hostelsFaq/(:num)','Hostels::hostelsFaq/$1');
$routes->get('/addHostelFaq/(:num)','Hostels::addHostelFaq/$1');
$routes->post('/saveHostelFaq','Hostels::saveFaq');
$routes->get('/editHostelFaq/(:num)','Hostels::editFaq/$1');
$routes->post('/updateHostelFaq','Hostels::updateFaq');
$routes->get('/deleteHostelFaq/(:num)/(:num)','Hostels::deleteHostelFaq/$1/$2');
$routes->get('/hostelGallery/(:num)','Hostels::hostelGallery/$1');
$routes->post('/addHostelgallerydetails/(:num)','Hostels::addGalleryDetails/$1');


$routes->get('/addHostel', 'HostelController::addhostel');
$routes->post('/storeHostel', 'HostelController::storehostel');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
