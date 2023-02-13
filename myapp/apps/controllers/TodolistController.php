<?php

use MyTodoList\Controllers\ControllerBase;
use MyTodoList\Models\Works;


class TodolistController extends ControllerBase
{

  // Hàm hiển thị kết quả ra cho người dùng.
  function indexAction()
  {
    $myToDoList =  Works::all();
  }
}
