<?php

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
    return $router->app->version();
});

$router->options('{any}', [
    'middleware' => ['cors'],
    function () {
        return response(['status' => 'success']);
    }
]);

/* -------------------
 *
 * CMS Routes
 *
 * ----------------- */

// items
$router->group([
    'prefix' => 'api/v1/cms',
    'namespace' => 'Items',
    'middleware' => ['cors', 'debug'] // todo auth
], function ($app) use ($router) {
    $app->post('/item', 'ItemController@add');
    $app->get('/item/{id}', 'ItemController@view');
    $app->get('/items', 'ItemController@list');
});

// purchases
$router->group([
    'prefix' => 'api/v1/cms',
    'namespace' => 'Purchases',
    'middleware' => ['cors', 'debug'] // todo auth
], function ($app) use ($router) {
    $app->post('/purchase', 'PurchaseController@add');
    $app->get('/purchase/{id}', 'PurchaseController@view');
    $app->get('/purchases', 'PurchaseController@list');
    $app->put('/purchases', 'PurchaseController@edit');
});

// workshop
$router->group([
    'prefix' => 'api/v1/cms',
    'namespace' => 'Workshop',
    'middleware' => ['cors', 'debug'] // todo auth
], function ($app) use ($router) {
    $app->get('/workshop/{id}', 'WorkshopController@view');
    $app->get('/workshop', 'WorkshopController@list');
    $app->put('/workshop', 'WorkshopController@edit');
});

// products
$router->group([
    'prefix' => 'api/v1/cms',
    'namespace' => 'Products',
    'middleware' => ['jwt.auth', 'cors', 'debug']
], function ($app) use ($router) {
    $app->get('/products/list/toGoOnline', 'ListController@toGoOnline');

    $app->get('/product/show/{id}', 'ProductController@show');

    $app->get('/categories', 'CategoriesController@show');
    $app->get('/categories/names', 'CategoriesController@names');
    $app->post('/categories/update', 'CategoriesController@update');
    $app->post('/categories/update-all', 'CategoriesController@updateAll');

    $app->post('/brand', 'BrandController@add');
    $app->get('/brand/{id}', 'BrandController@view');
    $app->get('/brands', 'BrandController@list');
    $app->put('/brands', 'BrandController@edit');
});

// sales
$router->group([
    'prefix' => 'api/v1/cms',
    'namespace' => 'Sales',
    'middleware' => ['cors', 'debug'] // todo auth
], function ($app) use ($router) {
    $app->post('/sale', 'SaleController@add');
    $app->get('/sale/{id}', 'SaleController@view');
    $app->get('/sales', 'SaleController@list');
    $app->put('/sales', 'SaleController@edit');
});

// contacts
$router->group([
    'prefix' => 'api/v1/cms',
    'namespace' => 'Contacts',
    'middleware' => ['cors', 'debug'] // todo auth
], function ($app) use ($router) {
    $app->post('/contact', 'ContactController@add');
    $app->get('/contact/{id}', 'ContactController@view');
    $app->get('/contacts', 'ContactController@list');
    $app->put('/contacts', 'ContactController@edit');
});

// options
$router->group([
    'prefix' => 'api/v1/cms',
    'namespace' => 'Options',
    'middleware' => ['cors', 'debug'] // todo auth
], function ($app) use ($router) {
    $app->post('/page-edit', 'PageEditController@add');
    $app->get('/page-edit/{id}', 'PageEditController@view');
    $app->get('/page-edit', 'PageEditController@list');
    $app->put('/page-edit', 'PageEditController@edit');
});


// products frontend
// $router->group([
//   'prefix' => 'api/v1',
//   'namespace' => 'Products',
//   'middleware' => ['cors']
// ], function ($app) use ($router) {
//   $app->get('/cms/products/listAll/{category?}', 'ProductController@listCategory');
// });

// auth
$router->group([
    'prefix' => 'api/v1',
    'namespace' => 'Auth',
    'middleware' => ['cors']
], function ($app) use ($router) {
    $app->post('/auth/login', 'AuthController@login');
    $app->post('/auth/register', 'AuthController@register');

});
$router->group([
    'prefix' => 'api/v1',
    'namespace' => 'Auth',
    'middleware' => ['cors', 'jwt.refresh']
], function ($app) use ($router) {
    $app->get('/auth/refresh', 'AuthController@refresh');
});
$router->group([
    'prefix' => 'api/v1',
    'namespace' => 'Auth',
    'middleware' => ['jwt.auth', 'cors']
], function ($app) use ($router) {
    $app->post('/auth/logout', 'AuthController@logout');
    $app->post('/auth/impersonate', 'AuthController@impersonate');
    $app->get('/auth/user', 'AuthController@user');

    $app->get('/users', 'UserController@all');
});
