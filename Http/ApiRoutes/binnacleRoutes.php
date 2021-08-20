<?php


use Illuminate\Routing\Router;

$router->group(['prefix' => '/binnacles'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

  $router->post('/', [
    'as' => $locale . 'api.ibinnacle.binnacles.create',
    'uses' => 'BinnacleApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.ibinnacle.binnacles.index',
    'uses' => 'BinnacleApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.ibinnacle.binnacles.update',
    'uses' => 'BinnacleApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.ibinnacle.binnacles.delete',
    'uses' => 'BinnacleApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.ibinnacle.binnacles.show',
    'uses' => 'BinnacleApiController@show',
  ]);


});

