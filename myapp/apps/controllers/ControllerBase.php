<?php

namespace MyTodoList\Controllers;

use Session;

class ControllerBase
{
  private $controllerName;
  private $actionName;
  public function __construct()
  {

    $this->controllerName = Session::get("controllerName");
    $this->actionName = Session::get("actionName");
  }
  public function getControllerName()
  {
    return $this->controllerName;
  }
  public function getActionName()
  {
    return $this->actionName;
  }
  public function render($data = [], $views = "")
  {

    // Extract the data array into variables
    extract($data);

    if (!$views) {
      $views = $this->getControllerName() . "/" . $this->getActionName();
    }

    // Include the header file
     include(__DIR__ . "/../views/layouts/header.phtml");
    // Include the view file
    include(__DIR__ . "/../views/" . $views . ".phtml");

    // Include the footer file
    include(__DIR__ . "/../views/layouts/footer.phtml");
  }
  public function getView($data = [], $views = "")
  {

    // Extract the data array into variables
    extract($data);

    if (!$views) {
      $views = $this->getControllerName() . "/" . $this->getActionName();
    }

    // Include the view file
    return include(__DIR__ . "/../views/" . $views . ".phtml");

  }
}
