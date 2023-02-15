<?php

use MyTodoList\Controllers\ControllerBase;
use MyTodoList\Models\User;

class LoginController extends ControllerBase
{

  // Hàm hiển thị kết quả ra cho người dùng.
  public function loginAction()
  {
    if ($_POST) {
      $email = trim($_POST['email']);
      $password = trim($_POST['password']);
      if (empty($email)) {
        $messages['email'] = "Email is required";
      }
      if (empty($messages)) {
        $messages['password'] = "Email is required";
      }
      if (empty($messages)) {
        goto end;
      }
      //check valid
      $user = User::findByEmail($email);
      if (!$user) {
        goto end;
      }

      if (!password_verify($password, $user->getUserPassword())) {
        $messages['password'] = "Password is not correct";
      } else {
        Session::set('auth', [
          'id' => $user->getId(),
          'name' => $user->getUserName(),
          'email' => $user->getUserEmail(),
        ]);
        header("Location: /my-works");
      }
    }
    end:
    $this->render([
      'title' => "login",
    ]);
  }
}
