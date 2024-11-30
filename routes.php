<?php



$router->get('/', 'HomeController@fetchAll');
$router->get('/listings', 'ListingController@fetchListings');
$router->get('/listings/create', 'ListingController@createListing');
$router->get('/listing/{id}', 'ListingController@show');
