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

// core
$router->group([
    'prefix' => 'api/v1/cms',
    'middleware' => ['cors', 'debug'] // todo auth
], function ($app) use ($router) {
    $app->get('/core', 'CoreController@index');
    $app->post('/core', 'CoreController@edit');
});

// items
$router->group([
    'prefix' => 'api/v1/cms',
    'namespace' => 'Items',
    'middleware' => ['cors', 'debug'] // todo auth
], function ($app) use ($router) {
    $app->post('/item', 'ItemController@add');
    $app->get('/item/{id}', 'ItemController@view');
    $app->post('/items', 'ItemController@list');
});

// purchases
$router->group([
    'prefix' => 'api/v1/cms',
    'namespace' => 'Purchases',
    'middleware' => ['cors', 'debug'] // todo auth
], function ($app) use ($router) {
    $app->post('/purchase', 'PurchaseController@add');
    $app->get('/purchase/{id}', 'PurchaseController@view');
    $app->post('/purchases', 'PurchaseController@list');
    $app->put('/purchases', 'PurchaseController@edit');
});

// workshop
$router->group([
    'prefix' => 'api/v1/cms',
    'namespace' => 'Workshop',
    'middleware' => ['cors', 'debug'] // todo auth
], function ($app) use ($router) {
    $app->get('/workshop/{id}', 'WorkshopController@view');
    $app->post('/workshop', 'WorkshopController@list');
    $app->put('/workshop', 'WorkshopController@edit');
});

// products
$router->group([
    'prefix' => 'api/v1/cms',
    'namespace' => 'Products',
    'middleware' => ['cors', 'debug'] // todo auth
], function ($app) use ($router) {
    $app->post('/product', 'ProductController@add');
    $app->get('/product/{id}', 'ProductController@view');
    $app->post('/products', 'ProductController@list');
    $app->put('/products', 'ProductController@edit');
    $app->get('/products/prep', 'ProductController@editPrep');

    $app->post('/categories', 'CategoriesController@list');
    $app->put('/categories', 'CategoriesController@edit');

    $app->post('/brands', 'BrandController@list');
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
    $app->post('/sales', 'SaleController@list');
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
    $app->post('/contacts', 'ContactController@list');
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
    $app->post('/page-edit', 'PageEditController@list');
    $app->put('/page-edit', 'PageEditController@edit');

    $app->get('/home-page', 'SiteSettingsController@homePageView');
    $app->post('/home-page', 'SiteSettingsController@homePageEdit');

    $app->get('/contacts', 'SiteSettingsController@contactsView');
    $app->post('/contacts', 'SiteSettingsController@contactsEdit');

    $app->get('/site-layout', 'SiteSettingsController@siteLayoutView');
    $app->post('/site-layout', 'SiteSettingsController@siteLayoutEdit');

    $app->post('/images', 'ImageController@list');
});

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

/* -------------------
 *
 * Frontend Routes
 *
 * ----------------- */

// core
$router->group([
    'prefix' => 'api/v1/site',
    'namespace' => 'Frontend',
    'middleware' => ['cors']
], function ($app) use ($router) {
    $app->get('/core', 'CoreController@siteLoad');
    $app->get('/core/common', 'CoreController@common');
});

// products
$router->group([
    'prefix' => 'api/v1/site',
    'namespace' => 'Frontend',
    'middleware' => ['cors']
], function ($app) use ($router) {
    $app->get('/product/{id}', 'ProductController@view');
    $app->post('/products', 'ProductController@list');
    $app->get('/search', 'ProductController@search');

    $app->get('/categories', 'ListController@categories');
    $app->get('/brands', 'ListController@brands');
});

// pages
$router->group([
    'prefix' => 'api/v1/site',
    'namespace' => 'Frontend',
    'middleware' => ['cors']
], function ($app) use ($router) {
    $app->post('/page', 'PageController@viewPage');
    $app->get('/page/home', 'PageController@homePage');
    $app->get('/page/contact', 'PageController@contactPage');
});

// contact
$router->group([
    'prefix' => 'api/v1/site',
    'namespace' => 'Frontend',
    'middleware' => ['cors']
], function ($app) use ($router) {
    // maybe do different for special messages?
    $app->post('/form/submit', 'FormController@submit');
});
