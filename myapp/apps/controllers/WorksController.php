<?php

use MyTodoList\Controllers\ControllerBase;
use MyTodoList\Models\Works;


class WorksController extends ControllerBase
{

  // Hàm hiển thị kết quả ra cho người dùng.
  function indexAction()
  {
    $myWorks =  Works::all();

    $this->render([
      'title' => "works",
      'myWorks' => $myWorks,
    ]);
  }
}
