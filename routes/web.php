<?php

/**
 * Routes that doesn't require auth
 */
$router->group(['middleware' => 'cors'], function () use ($router) {
    // User routes
    $router->post('/login', ['uses' => 'LoginController@login']);
    $router->post('/register', ['uses' => 'UserController@register']);
});

/**
 * Routes that require auth
 */
$router->group(['middleware' => ['cors', 'auth']], function () use ($router) {
    // Users routes
    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->get('', ['uses' => 'UserController@getLoggedUser']);
        $router->patch('', ['uses' => 'UserController@updateLoggedUser']);
    });

    // Checklists routes
    $router->get('/lists', ['uses' => 'ListController@getUserLists']);
    $router->group(['prefix' => 'list'], function () use ($router) {
        $router->post('/', ['uses' => 'ListController@createList']);
        $router->group(['prefix' => '{id}'], function () use ($router) {
            $router->get('', ['uses' => 'ListController@getList']);
            $router->patch('', ['uses' => 'ListController@updateList']);
            $router->delete('', ['uses' => 'ListController@deleteList']);

            // Checklist items routes
            $router->get('/items', ['uses' => 'ItemController@getListItems']);
            $router->group(['prefix' => 'items'], function () use ($router) {
                $router->post('/', ['uses' => 'ItemController@createItem']);
                $router->group(['prefix' => '{itemId}'], function () use ($router) {
                    $router->patch('', ['uses' => 'ItemController@updateItem']);
                    $router->delete('', ['uses' => 'ItemController@deleteItem']);
                });
            });
        });
    });
});
