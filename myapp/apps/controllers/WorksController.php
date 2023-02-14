<?php

use MyTodoList\Controllers\ControllerBase;
use MyTodoList\Models\Works;
use MyTodoList\Reponsetories\MyRepo;

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
    if (!$page) {
      $page = 1;
    }

    // Tính offset
    $offset = ($page - 1) * 5;

    $sql_total = "SELECT COUNT(*) as total FROM works WHERE 1";
    $sql_search = "";
    $sql = "SELECT * FROM works WHERE 1";
    $params = [];

    if (!empty($_GET)) {
      $paramsSearch = $_GET;

      if (isset($paramsSearch['slcStatus']) && $paramsSearch['slcStatus']) {
        $sql_search .= " AND work_status = :slcStatus ";
        $params['slcStatus'] = trim($paramsSearch['slcStatus']);
      }
      if (isset($paramsSearch['slcStartDate']) && $paramsSearch['slcStartDate']) {
        $sql_search .= " AND work_start_date >= :slcStartDate ";
        $params['slcStartDate'] = trim($paramsSearch['slcStartDate']);
      }
      if (isset($paramsSearch['slcEndDate']) && $paramsSearch['slcEndDate']) {
        $sql_search .= " AND work_end_date <= :slcEndDate ";
        $params['slcEndDate'] = trim($paramsSearch['slcEndDate']);
      }
      if (isset($paramsSearch['txtContent']) && $paramsSearch['txtContent']) {
        $sql_search .= " AND ( work_name like CONCAT('%',:txtContent,'%') OR work_content like CONCAT('%',:txtContent,'%'))";
        $params['txtContent'] = trim($paramsSearch['txtContent']);
      }
    }
    // Thêm LIMIT và OFFSET vào truy vấn SQL
    $sql_search .= " ORDER BY id DESC ";
    $sql_offset = "  LIMIT 5 OFFSET $offset";

    $myWorks =  Works::findByQuery($sql . $sql_search .$sql_offset, $params);

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
    $messages = [];
    $data = [];
    if (!empty($_POST)) {

      $this->checkValidPost($messages);

      if (!empty($messages)) {
        goto end;
      }
      $data = $_POST;
      $newWork = new Works(
        null,
        Session::get("auth")['id'],
        $data['work_name'],
        $data['work_content'],
        $data['work_start_date'],
        $data['work_end_date'],
        MyRepo::formatDateTime(time()),
        $data['work_status']

      );
      $result = $newWork->save();
      if (!$result) {
        $messages['update'] = "Can't save work!";
        goto end;
      }
      Session::set("result", "Save work success!");
      header("Location: /my-works");
    }

    end:
    $this->render([
      'data' => $data,
      'messages' => $messages,
      'title' => "Create new work",
    ]);
  }
  function updateAction()
  {
    $id = $_GET['id'];
    $work = Works::findById($id);
    if (!$work) {
      header("Location: /works");
    }
    $data = [
      'work_name' => $work->getWorkName(),
      'work_content' => $work->getWorkContent(),
      'work_start_date' => $work->getWorkStartDate(),
      'work_end_date' => $work->getWorkEndDate(),
      'work_status' => $work->getWorkStatus(),
    ];
    $messages = [];
    if (!empty($_POST)) {
      $this->checkValidPost($messages);
      if (!empty($messages)) {
        goto end;
      }
      $data = $_POST;

      $result = $work->updateAll(
        Session::get("auth")['id'],
        $data['work_name'],
        $data['work_content'],
        $data['work_start_date'],
        $data['work_end_date'],
        MyRepo::formatDateTime(time()),
        $data['work_status']
      );
      if (!$result) {
        $messages['update'] = "Can't update work!";
        goto end;
      }
      Session::set("result", "Update work success!");
      header("Location: /my-works");
    }

    end:
    $this->render([
      'data' => $data,
      'messages' => $messages,
      'title' => "Update work",
    ],
    'works/create'
  );
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
  private function checkValidPost(&$messages)
  {

    if (empty($_POST['work_name'])) {
      $messages['work_name'] = "Work Name is required";
    }
    if (empty($_POST['work_start_date'])) {
      $messages['work_start_date'] = "Start Date is required";
    } elseif (!strtotime($_POST['work_start_date'])) {
      $messages['work_start_date'] = "Start Date is valid";
    }
    if (empty($_POST['work_end_date'])) {
      $messages['work_end_date'] = "End Date is required";
    } elseif (!is_numeric(strtotime($_POST['work_end_date']))) {
      $messages['work_end_date'] = "End Date is valid";
    }
    if (empty($_POST['work_status'])) {
      $messages['work_status'] = "Status is required";
    }
    return $messages;
  }
}
