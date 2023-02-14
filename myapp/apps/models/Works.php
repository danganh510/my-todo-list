<?php

namespace MyTodoList\Models;

use DB;

class Works
{
  private $id;
  private $user_id;
  private $work_name;
  private $work_content;
  private $work_start_date;
  private $work_end_date;
  private $work_insert_date;
  private $work_status;

  public function __construct($id, $user_id, $work_name, $work_content, $work_start_date, $work_end_date, $work_status, $work_insert_date)
  {
    $this->id = $id;
    $this->user_id = $user_id;
    $this->work_name = $work_name;
    $this->work_content = $work_content;
    $this->work_start_date = $work_start_date;
    $this->work_end_date = $work_end_date;
    $this->work_insert_date = $work_insert_date;
    $this->work_status = $work_status;
  }

  public static function all()
  {
    $list = [];
    $db = DB::getInstance();
    $req = $db->query('SELECT * FROM works');

    foreach ($req->fetchAll() as $work) {
      $list[] = new Works($work['id'], $work['user_id'], $work['work_name'], $work['work_content'], $work['work_start_date'], $work['work_end_date'], $work['work_insert_date'], $work['work_status']);
    }

    return $list;
  }

  public static function findById($id)
  {
    $db = Db::getInstance();
    $id = intval($id);
    $req = $db->prepare('SELECT * FROM works WHERE id = :id');
    $req->execute(array('id' => $id));
    $work = $req->fetch();

    return new Works($work['id'], $work['user_id'], $work['work_name'], $work['work_content'], 
    $work['work_start_date'], $work['work_end_date'], $work['work_insert_date'], $work['work_status']);
  }
  public static function findByQuery($query, $params)
  {
    $db = Db::getInstance();
    $req = $db->prepare($query);
    $req->execute($params);
    $list = [];
    foreach ($req->fetchAll() as $work) {
      $list[] = new Works($work['id'], $work['user_id'], $work['work_name'], $work['work_content'], $work['work_start_date'],
       $work['work_end_date'], $work['work_insert_date'], $work['work_status']);
    }

    return $list;
  }
  public static function getTotalRecord($query, $params)
  {
    $db = Db::getInstance();
    $req = $db->prepare($query);
    $req->execute($params);
    $count_record = [];
    foreach ($req->fetchAll() as $work) {
      $count_record = $work['total'];
      break;
    }
    return $count_record;
  }


  public static function create($user_id, $work_name, $work_content, $work_start_date, $work_end_date, $work_insert_date, $work_status)
  {
    $db = Db::getInstance();
    $req = $db->prepare("INSERT INTO works (user_id, work_name, work_content, work_start_date, work_end_date, work_insert_date, work_status) VALUES (:user_id, :work_name, :work_content, :work_start_date, :work_end_date,:work_insert_date, :work_status)");
    $req->execute(array(
      'user_id' => $user_id,
      'work_name' => $work_name,
      'work_content' => $work_content,
      'work_start_date' => $work_start_date,
      'work_end_date' => $work_end_date,
      'work_insert_date' => $work_insert_date,
      'work_status' => $work_status
    ));
  }
  public function save()
  {
    $db = Db::getInstance();
    $req = $db->prepare("INSERT INTO works (user_id, work_name, work_content, work_start_date, work_end_date, work_insert_date, work_status) VALUES (:user_id, :work_name, :work_content, :work_start_date, :work_end_date,:work_insert_date, :work_status)");
    $req->execute(array(
      'user_id' => $this->user_id,
      'work_name' => $this->work_name,
      'work_content' => $this->work_content,
      'work_start_date' => $this->work_start_date,
      'work_end_date' => $this->work_end_date,
      'work_insert_date' => $this->work_insert_date,
      'work_status' => $this->work_status,
    ));
  }
  public function update()
  {
    $db = Db::getInstance();
    $req = $db->prepare("UPDATE works SET user_id = :user_id, work_name = :work_name, work_content = :work_content, work_start_date = :work_start_date, work_end_date = :work_end_date, work_insert_date = :work_insert_date, work_status = :work_status WHERE id = :id");
    $req->execute(array(
      'user_id' => $this->user_id,
      'work_name' => $this->work_name,
      'work_content' => $this->work_content,
      'work_start_date' => $this->work_start_date,
      'work_end_date' => $this->work_end_date,
      'work_insert_date' => $this->work_insert_date,
      'work_status' => $this->work_status,
    ));
  }

  public function updateAll($user_id, $work_name, $work_content, $work_start_date, $work_end_date, $work_insert_date, $work_status)
  {
    $db = Db::getInstance();
    $req = $db->prepare("UPDATE works SET user_id = :user_id, work_name = :work_name, work_content = :work_content, work_start_date = :work_start_date, work_end_date = :work_end_date, work_insert_date = :work_insert_date, work_status = :work_status WHERE id = :id");
    $req->execute(array(
      'id' => $this->id,
      'user_id' => $user_id,
      'work_name' => $work_name,
      'work_content' => $work_content,
      'work_start_date' => $work_start_date,
      'work_end_date' => $work_end_date,
      'work_insert_date' => $work_insert_date,
      'work_status' => $work_status
    ));
  }

  public function delete()
  {
    $db = Db::getInstance();
    $req = $db->prepare('DELETE FROM works WHERE id = :id');
    $req->execute(array('id' => $this->id));
  }

  public function getId()
  {
    return $this->id;
  }
  public function setId($id)
  {
    $this->id = $id;
    return $this->id;
  }

  public function getUserID()
  {
    return $this->user_id;
  }
  public function setUserId($user_id)
  {
    $this->user_id = $user_id;
    return $this->user_id;
  }

  public function getWorkName()
  {
    return $this->work_name;
  }
  public function setWorkName($work_name)
  {
    $this->work_name = $work_name;
    return $this->work_name;
  }
  public function getWorkContent()
  {
    return $this->work_content;
  }
  public function setWorkContent($work_content)
  {
    $this->work_content = $work_content;
    return $this->work_content;
  }
  public function getWorkStartDate()
  {
    return $this->work_start_date;
  }
  public function setWorkStartDate($work_start_date)
  {
    $this->work_start_date = $work_start_date;
    return $this->work_start_date;
  }
  public function getWorkEndDate()
  {
    return $this->work_end_date;
  }
  public function setWorkEndDate($work_end_date)
  {
    $this->work_start_date = $work_end_date;
    return $this->work_end_date;
  }
  public function getWorkInsertDate()
  {
    return $this->work_insert_date;
  }
  public function setWorkInsertDate($work_insert_date)
  {
    $this->work_insert_date = $work_insert_date;
    return $this->work_insert_date;
  }
  public function getWorkStatus()
  {
    return $this->work_status;
  }
  public function setWorkStatus($work_status)
  {
    $this->work_status = $work_status;
    return $this->work_status;
  }
}
