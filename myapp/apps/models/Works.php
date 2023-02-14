<?php

namespace MyTodoList\Models;

use DB;

class Works
{
  private $id;
  private $user_id;
  private $work_name;
  private $work_content;
  private $start_date;
  private $end_date;
  private $work_status;

  public function __construct($id, $user_id, $work_name, $work_content, $start_date, $end_date, $work_status)
  {
    $this->id = $id;
    $this->user_id = $user_id;
    $this->work_name = $work_name;
    $this->work_content = $work_content;
    $this->start_date = $start_date;
    $this->end_date = $end_date;
    $this->work_status = $work_status;
  }

  public static function all()
  {
    $list = [];
    $db = DB::getInstance();
    $req = $db->query('SELECT * FROM works');

    foreach ($req->fetchAll() as $work) {
      $list[] = new Works($work['id'], $work['user_id'], $work['work_name'], $work['work_content'], $work['start_date'], $work['end_date'], $work['work_status']);
    }

    return $list;
  }

  public static function find($id)
  {
    $db = Db::getInstance();
    $id = intval($id);
    $req = $db->prepare('SELECT * FROM works WHERE id = :id');
    $req->execute(array('id' => $id));
    $work = $req->fetch();

    return new Works($work['id'], $work['user_id'], $work['work_name'], $work['work_content'], $work['start_date'], $work['end_date'], $work['work_status']);
  }
  public static function findByQuery($query, $params)
  {
    $db = Db::getInstance();
    $req = $db->prepare($query);
    $req->execute($params);
    $list = []; 
    foreach ($req->fetchAll() as $work) {
      $list[] = new Works($work['id'], $work['user_id'], $work['work_name'], $work['work_content'], $work['start_date'], $work['end_date'], $work['work_status']);
    }
  
    return $list;
  }
  

  public static function create($user_id, $work_name, $work_content, $start_date, $end_date, $work_status)
  {
    $db = Db::getInstance();
    $req = $db->prepare("INSERT INTO works (user_id, work_name, work_content, start_date, end_date, work_status) VALUES (:user_id, :work_name, :work_content, :start_date, :end_date, :work_status)");
    $req->execute(array(
      'user_id' => $user_id,
      'work_name' => $work_name,
      'work_content' => $work_content,
      'start_date' => $start_date,
      'end_date' => $end_date,
      'work_status' => $work_status
    ));
  }

  public function update($user_id, $work_name, $work_content, $start_date, $end_date, $work_status)
  {
    $db = Db::getInstance();
    $req = $db->prepare("UPDATE works SET user_id = :user_id, work_name = :work_name, work_content = :work_content, start_date = :start_date, end_date = :end_date, work_status = :work_status WHERE id = :id");
    $req->execute(array(
      'id' => $this->id,
      'user_id' => $user_id,
      'work_name' => $work_name,
      'work_content' => $work_content,
      'start_date' => $start_date,
      'end_date' => $end_date,
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

  public function getUserID()
  {
    return $this->user_id;
  }
  public function getWorkName()
  {
    return $this->work_name;
  }
  public function getWorkContent()
  {
    return $this->work_content;
  }
  public function getStartDate()
  {
    return $this->start_date;
  }

  public function getEndDate()
  {
    return $this->end_date;
  }

  public function getWorkStatus()
  {
    return $this->work_status;
  }
}
