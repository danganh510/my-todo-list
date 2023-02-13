<?php
namespace MyTodoList\Models;

use DB;

class Works
{
  private $id;
  private $work_name;
  private $start_date;
  private $end_date;
  private $status;

  public function __construct($id, $work_name, $start_date, $end_date, $status)
  {
    $this->id = $id;
    $this->work_name = $work_name;
    $this->start_date = $start_date;
    $this->end_date = $end_date;
    $this->status = $status;
  }

  public static function all()
  {
    $list = [];
    $db = DB::getInstance();
    $req = $db->query('SELECT * FROM works');

    foreach ($req->fetchAll() as $work) {
      $list[] = new Works($work['id'], $work['work_name'], $work['start_date'], $work['end_date'], $work['status']);
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

    return new Works($work['id'], $work['work_name'], $work['start_date'], $work['end_date'], $work['status']);
  }

  public static function create($work_name, $start_date, $end_date, $status)
  {
    $db = Db::getInstance();
    $req = $db->prepare("INSERT INTO works (work_name, start_date, end_date, status) VALUES (:work_name, :start_date, :end_date, :status)");
    $req->execute(array(
      'work_name' => $work_name,
      'start_date' => $start_date,
      'end_date' => $end_date,
      'status' => $status
    ));
  }

  public function update($work_name, $start_date, $end_date, $status)
  {
    $db = Db::getInstance();
    $req = $db->prepare("UPDATE works SET work_name = :work_name, start_date = :start_date, end_date = :end_date, status = :status WHERE id = :id");
    $req->execute(array(
      'id' => $this->id,
      'work_name' => $work_name,
      'start_date' => $start_date,
      'end_date' => $end_date,
      'status' => $status
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

  public function getWorkName()
  {
    return $this->work_name;
  }

  public function getStartDate()
  {
    return $this->start_date;
  }

  public function getEndDate()
  {
    return $this->end_date;
  }

  public function getStatus()
  {
    return $this->status;
  }
}
