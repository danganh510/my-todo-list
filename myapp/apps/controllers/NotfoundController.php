<?php

use MyTodoList\Controllers\ControllerBase;
use MyTodoList\Models\User;

class NotfoundController extends ControllerBase
{

  // Hàm hiển thị kết quả ra cho người dùng.
  public function notfoundAction()
  {
    $this->render([
        'title' => "Notfound",
      ]);
  }
}
