<?php

// Array to store the routes and the corresponding controller and action
$routes = [
  "/my-works" => [
    'controller' => "works",
    'action' => "index"
  ],
  "/my-works/create" => [
    'controller' => "works",
    'action' => "create"
  ],
  "/login" => [
    'controller' => "login",
    'action' => "login"
  ],
];

// Get the current request URI
$request_uri = $_SERVER['REQUEST_URI'];

// Remove the query string from the request URI
$request_uri = explode("?", $request_uri)[0];

// Check if the route is valid
if (!isset($routes[$request_uri])) {
  // Set the controller and action name to the error page if the route is invalid
  $controller_name = 'error';
  $action_name = 'error';
} else {
  // Get the controller and action name from the routes array
  $route = $routes[$request_uri];
  $controller_name = $route['controller'];
  $action_name = $route['action'];
}

Session::set("controllerName",$controller_name);
Session::set("actionName",$action_name);

// Set the path to the controller file
$controller_file = './apps/controllers/' .ucfirst( $controller_name) . 'Controller.php';

// Check if the controller file exists
if (!file_exists($controller_file)) {
  die("Controller file not found: $controller_file");
}

// Include the controller file
include_once($controller_file);

// Set the name of the controller class
$controller_class = ucfirst($controller_name) . 'Controller';

// Check if the controller class exists
if (!class_exists($controller_class)) {
  die("Controller class not found: $controller_class");
}

// Create an instance of the controller class
$controller = new $controller_class();

// Set the name of the action method
$action_name = $action_name . "Action";

// Check if the action method exists
if (!method_exists($controller, $action_name)) {
  die("Action not found: $action_name");
}

// Call the action method
$controller->$action_name();