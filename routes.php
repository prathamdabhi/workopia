<?php
$router->get('/', 'HomeController@fetchAll');
$router->get('/listings', 'ListingController@fetchListings');
$router->get('/listings/create', 'ListingController@createListing');
$router->get('/listings/{id}', 'ListingController@show');
$router->get('/listings/edit/{id}', 'ListingController@edit');

$router->post('/listings', 'ListingController@store');

$router->put('/listings/{id}', 'ListingController@update');

$router->delete('/listings/{id}', 'ListingController@delete');

$router->get('/auth/register', 'UserController@register');
$router->get('/auth/login', 'UserController@login');

$router->post('/auth/register', 'UserController@store');
$router->post('/auth/logout', 'UserController@logout');
$router->post('/auth/login', 'UserController@authenticate');
