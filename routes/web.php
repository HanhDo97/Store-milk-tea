<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Faker\Core\Number;
use Ramsey\Uuid\Type\Integer;
use App\Http\Controllers\Store1Controller;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return redirect('/store1');
});
$router->get('/store1', 'Store1Controller@index');
$router->get('/store1/sort-by-name', 'Store1Controller@sortByNameAsc');
$router->get('/store1/sort-by-name-dsc', 'Store1Controller@sortByNameDsc');
$router->get('/store1/sort-by-price', 'Store1Controller@sortByPriceAsc');
$router->get('/store1/sort-by-price-dsc', 'Store1Controller@sortByPriceDsc');
$router->post('/clear-session', 'Store1Controller@clearSession');
$router->post('/store1/filter', 'Store1Controller@getFilterProducts');

$router->get('/store2', 'Store2Controller@index');
$router->get('/store2/sort-by-name', 'Store2Controller@sortByNameAsc');
$router->get('/store2/sort-by-name-dsc', 'Store2Controller@sortByNameDsc');
$router->get('/store2/sort-by-price', 'Store2Controller@sortByPriceAsc');
$router->get('/store2/sort-by-price-dsc', 'Store2Controller@sortByPriceDsc');
$router->post('/store2/filter', 'Store2Controller@getFilterProducts');
