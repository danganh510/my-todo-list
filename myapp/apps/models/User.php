<?php
namespace MyTodoList\Models;

use DB;
use PDO;

class User {
  private $id;
  private $user_email;
  private $user_password;
  private $user_name;
  private $user_active;

  public function __construct($user_email, $user_password, $user_name, $user_active, $id = null) {
    $this->id = $id;
    $this->user_email = $user_email;
    $this->user_password = $user_password;
    $this->user_name = $user_name;
    $this->user_active = $user_active;
  }

  // Getters and setters
  public function getId() {
    return $this->id;
  }

  public function getUserEmail() {
    return $this->user_email;
  }

  public function setUserEmail($user_email) {
    $this->user_email = $user_email;
  }

  public function getUserPassword() {
    return $this->user_password;
  }

  public function setUserPassword($user_password) {
    $this->user_password = password_hash($user_password, PASSWORD_DEFAULT);
  }

  public function getUserName() {
    return $this->user_name;
  }

  public function setUserName($user_name) {
    $this->user_name = $user_name;
  }

  public function getUserActive() {
    return $this->user_active;
  }

  public function setUserActive($user_active) {
    $this->user_active = $user_active;
  }
  public static function findById($id) {
    $db = DB::getInstance();
    $statement = $db->prepare('SELECT * FROM user WHERE id = :id');
    $statement->bindParam(':id', $id);
    $statement->execute();

    $user_data = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$user_data) {
      return null;
    }

    return new User($user_data['user_email'], $user_data['user_password'], $user_data['user_name'], $user_data['user_active'], $user_data['id']);
  }

  public static function findByEmail($email) {
    $db = DB::getInstance();
    $statement = $db->prepare('SELECT * FROM user WHERE user_email = :email AND user_active = "Y"');
    $statement->bindParam(':email', $email);
    $statement->execute();

    $user_data = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$user_data) {
      return null;
    }
    return new User($user_data['user_email'], $user_data['user_password'], $user_data['user_name'], $user_data['user_active'], $user_data['id']);
  }

}

