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
    }

    // Lấy trang hiện tại
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    // Tính offset
    $offset = ($page - 1) * 5;

    $sql_total = "SELECT COUNT(*) as total FROM works WHERE 1";
    $sql_search = "";
    $sql = "SELECT * FROM works WHERE 1";
    $params = [];

    if (!empty($_POST)) {
      $paramsSearch = [
        'slcDateTime' => $_POST['slcDateTime'],
        'txtContent' => $_POST['txtContent'],
        'slcStatus' => $_POST['slcStatus'],
      ];

      if ($paramsSearch['slcStatus']) {
        $sql_search .= " AND work_status = :slcStatus ";
        $params['slcStatus'] = $paramsSearch['slcStatus'];
      }

      if ($paramsSearch['txtContent']) {
        $sql_search .= " AND ( work_name like CONCAT('%',:txtContent,'%') OR work_content like CONCAT('%',:txtContent,'%'))";
        $params['txtContent'] = $paramsSearch['txtContent'];
      }
    }
    // Thêm LIMIT và OFFSET vào truy vấn SQL
    $sql_search .= " ORDER BY id DESC LIMIT 5 OFFSET $offset";

    $myWorks =  Works::findByQuery($sql . $sql_search, $params);

    $totalRecords = Works::getTotalRecord($sql_total . $sql_search, $params);


    // Tính tổng số trang
    $totalPages = ceil($totalRecords / 5);

    if ($page > $totalPages) {
      $page = $totalPages;
    }
    if ($page < 1) {
      $page = 1;
    }

    $this->render([
      'title' => "works",
      'myWorks' => $myWorks,
      'time' => $time,
      'paramsSearch' => $paramsSearch,
      'currentPage' => $page,
      'totalPages' => $totalPages
    ]);
  }
  function createAction()
  {
    if (!empty($_POST)) {
      $newWork = new Works(
        null,
        Session::get("auth")['id'],
        $_POST['work_name'],
        $_POST['work_content'],
        $_POST['start_date'],
        $_POST['end_date'],
        $_POST['work_status'],
        time()
      );
      $newWork->save();
      header("Location: /works");
    }

    $this->render([
      'title' => "Create new work",
    ]);
  }

  function editAction()
  {
    $id = $_GET['id'];
    $work = Works::findById($id);
    if (!$work) {
      header("Location: /works");
    }

    if (!empty($_POST)) {
      $work->setWorkName($_POST['work_name']);
      $work->setWorkContent($_POST['work_content']);
      $work->setWorkStartDate($_POST['start_date']);
      $work->setWorkEndDate($_POST['end_date']);
      $work->setWorkStatus($_POST['work_status']);
      $work->save();
      header("Location: /works");
    }

    $this->render([
      'title' => "Edit work",
      'work' => $work,
    ]);
  }

  function deleteAction()
  {
    $id = $_GET['id'];
    $work = Works::findById($id);
    if (!$work) {
      header("Location: /works");
    }

    if (!empty($_POST)) {
      $work->delete();
      header("Location: /works");
    }

    $this->render([
      'title' => "Delete work",
      'work' => $work,
    ]);
  }
}
