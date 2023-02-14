<?php

use MyTodoList\Controllers\ControllerBase;
use MyTodoList\Models\Works;


class WorksController extends ControllerBase
{

  // Hàm hiển thị kết quả ra cho người dùng.
  function indexAction()
  {
    $myWorks = [];
    $paramsSearch = [];
    $time = isset($_GET["time"])  ? $_GET["time"] : "";
    if (!$time) {
      $time = "All";
      $myWorks =  Works::all();
    }
    if (!empty($_POST)) {
      $paramsSearch = [
        'slcDateTime' => $_POST['slcDateTime'],
        'txtContent' => $_POST['txtContent'],
        'slcStatus' => $_POST['slcStatus'],
      ];
      $params = [];
      $sql = "SELECT * FROM works WHERE 1";
      if ($paramsSearch['slcStatus']) {
        $sql .= " AND work_status = :slcStatus ";
        $params['slcStatus'] = $paramsSearch['slcStatus'];
      }
   
      if ($paramsSearch['txtContent']) {
        $sql .= " AND ( work_name like CONCAT('%',:txtContent,'%') OR work_content like CONCAT('%',:txtContent,'%'))";
        $params['txtContent'] = $paramsSearch['txtContent'];
      }
      
      $myWorks =  Works::findByQuery($sql,$params);

    }

    $this->render([
      'title' => "works",
      'myWorks' => $myWorks,
      'time' => $time,
      'paramsSearch' => $paramsSearch
    ]);
  }
}
