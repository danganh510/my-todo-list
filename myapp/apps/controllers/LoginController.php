<?php
use MyTodoList\Controllers\ControllerBase;

class LoginController extends ControllerBase
{

  // Hàm hiển thị kết quả ra cho người dùng.
  public function loginAction()
  {

    $this->render([
      'title' => "login",
    ]);
  }
}
