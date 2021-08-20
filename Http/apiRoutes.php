<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/ibinnacle/v1'/*,'middleware' => ['auth:api']*/], function (Router $router) {
  //======  CATEGORIES
  require('ApiRoutes/binnacleRoutes.php');
  
});
