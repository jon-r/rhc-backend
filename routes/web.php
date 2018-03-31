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

// products
$router->group([
  'prefix' => 'api/v1/cms',
  'namespace' => 'Products',
  'middleware' => ['cors', 'debug'] // todo add auth
], function ($app) use ($router) {
  $router->get('/products/list/toGoOnline', 'ListController@toGoOnline');

  $router->get('/product/show/{id}', 'ProductController@show');

  $router->get('/categories', 'CategoriesController@show');
});


// products frontend
// $router->group([
//   'prefix' => 'api/v1',
//   'namespace' => 'Products',
//   'middleware' => ['cors']
// ], function ($app) use ($router) {
//   $router->get('/cms/products/listAll/{category?}', 'ProductController@listCategory');
// });

// auth
$router->group([
  'prefix' => 'api/v1',
  'namespace' => 'Auth',
  'middleware' => ['cors']
], function () use ($router) {
  $router->post('/auth/login', 'AuthController@login');
  $router->post('/auth/register', 'AuthController@register');

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
