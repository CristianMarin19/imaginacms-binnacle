<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/ibinnacle'], function (Router $router) {
  $router->bind('binnacle', function ($id) {
    return app('Modules\Ibinnacle\Repositories\BinnacleRepository')->find($id);
  });
  $router->get('binnacles', [
    'as' => 'admin.ibinnacle.binnacle.index',
    'uses' => 'BinnacleController@index',
    'middleware' => 'can:ibinnacle.binnacles.index'
  ]);
  $router->get('binnacles/create', [
    'as' => 'admin.ibinnacle.binnacle.create',
    'uses' => 'BinnacleController@create',
    'middleware' => 'can:ibinnacle.binnacles.create'
  ]);
  $router->post('binnacles', [
    'as' => 'admin.ibinnacle.binnacle.store',
    'uses' => 'BinnacleController@store',
    'middleware' => 'can:ibinnacle.binnacles.create'
  ]);
  $router->get('binnacles/{binnacle}/edit', [
    'as' => 'admin.ibinnacle.binnacle.edit',
    'uses' => 'BinnacleController@edit',
    'middleware' => 'can:ibinnacle.binnacles.edit'
  ]);
  $router->put('binnacles/{binnacle}', [
    'as' => 'admin.ibinnacle.binnacle.update',
    'uses' => 'BinnacleController@update',
    'middleware' => 'can:ibinnacle.binnacles.edit'
  ]);
  $router->delete('binnacles/{binnacle}', [
    'as' => 'admin.ibinnacle.binnacle.destroy',
    'uses' => 'BinnacleController@destroy',
    'middleware' => 'can:ibinnacle.binnacles.destroy'
  ]);
// append
  
});

