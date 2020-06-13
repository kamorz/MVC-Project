<?php

/**
 * Front controller
 *
 * PHP version 7.0
 */

/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';


/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


/**
 * Sessions
 */
session_start();


/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('login', ['controller' => 'Login', 'action' => 'new']);
$router->add('newIncome', ['controller' => 'AddingIncomes', 'action' => 'new']);
$router->add('newExpense', ['controller' => 'AddingExpenses', 'action' => 'new']);
$router->add('currentMonthOverview', ['controller' => 'Balance', 'action' => 'currentMonth']);
$router->add('previousMonthOverview', ['controller' => 'Balance', 'action' => 'previousMonth']);
$router->add('logout', ['controller' => 'Login', 'action' => 'destroy']);
$router->add('{controller}/{action}');

$router->dispatch($_SERVER['QUERY_STRING']);
