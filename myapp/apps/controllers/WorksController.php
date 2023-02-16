<?php

use MyTodoList\Controllers\ControllerBase;
use MyTodoList\Models\Works;
use MyTodoList\Reponsetories\MyRepo;

class WorksController extends ControllerBase
{
  function calenderAction()
  {

    $sql = "SELECT * FROM works WHERE 1";
    $myWorks =  Works::findByQuery($sql, []);
    $result = [];
    foreach ($myWorks as $work) {
      $result['events'][] = [
        "id" => $work->getId(),
        "title" => $work->getWorkName(),
        "start" => $work->getWorkStartDate(),
        "end" => $work->getWorkEndDate(),
        "color" => $work->getWorkStatus() == "planning" ? "red" : ($work->getWorkStatus() == "doing" ? "blue" : "black"),
        "description" => $work->getWorkContent(),
      ];
    }
    //  echo (json_encode($result));exit;
    $this->render([
      'myWorks' => $result
    ]);
  }
  function indexAction()
  {
    $myWorks = [];
    $paramsSearch = [];
    $params = [];
    $type = isset($_GET["type"])  ? $_GET["type"] : "";
    if (!$type) {
      $type = "all";
    }
    $query_get_time = "";
    $start_run_time = time();

    switch ($type) {
      case "day":
        //work that will be finished during the today

        $date_start = MyRepo::formatDateTime($start_run_time);

        $query_get_time .= " AND  work_end_date >= :date_searh_start ";
        $params['date_searh_start'] = $date_start;

        break;
      case "week":
        //work that will be finished during the week
        $date_start = MyRepo::formatDateTime(strtotime("monday this week", $start_run_time));
        $date_end = MyRepo::formatDateTime(strtotime("sunday this week", $start_run_time));
        $query_get_time .= " AND  (work_end_date >= :date_searh_start AND work_end_date <= :date_searh_end) ";
        $params['date_searh_start'] = $date_start;
        $params['date_searh_end'] = $date_end;
        break;
      case "month":
        //work that will be finished during the month
        $date_start = date('Y-m-01');
        $date_end = date('Y-m-t');
        $query_get_time .= " AND  work_end_date >= :date_searh_start: AND work_end_date <= :date_searh_end ";
        $params['date_searh_start'] = $date_start;
        $params['date_searh_end'] = $date_end;

        break;
      case "year":
        //work that will be finished during the year

        $date_start = date('Y-01-01');
        $date_end = date('Y-12-31');
        $query_get_time .= " AND  work_end_date >= :date_searh_start: AND work_end_date <= :date_searh_end ";
        $params['date_searh_start'] = $date_start;
        $params['date_searh_end'] = $date_end;

        break;
      default:
        break;
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


    if (!empty($_POST) || !empty($_GET)) {
      $paramsSearch = $_POST;
      if (empty($paramsSearch)) {
        $paramsSearch = $_GET;
      }
      foreach ($paramsSearch as $key => $value) {
        if (empty($value)) {
          unset($paramsSearch[$key]);
        }
      }


      //search by status
      if (isset($paramsSearch['slcStatus']) && $paramsSearch['slcStatus']) {
        $sql_search .= " AND work_status = :slcStatus ";
        $params['slcStatus'] = trim($paramsSearch['slcStatus']);
      }

      //search start date 
      if (isset($paramsSearch['slcStartDate']) && $paramsSearch['slcStartDate']) {
        $sql_search .= " AND work_start_date >= :slcStartDate ";
        $params['slcStartDate'] = trim($paramsSearch['slcStartDate']);
      }

      //search end date 
      if (isset($paramsSearch['slcEndDate']) && $paramsSearch['slcEndDate']) {
        $sql_search .= " AND work_end_date <= :slcEndDate ";
        $params['slcEndDate'] = trim($paramsSearch['slcEndDate']);
      }

      //search nmae,content,id
      if (isset($paramsSearch['txtContent']) && $paramsSearch['txtContent']) {
        $sql_search .= " AND ( work_name like CONCAT('%',:txtContent,'%') OR work_content like CONCAT('%',:txtContent,'%')) OR id = :txtContent ";
        $params['txtContent'] = trim($paramsSearch['txtContent']);
      }
    }
    $sql_search .= $query_get_time;
    // Thêm LIMIT và OFFSET vào truy vấn SQL
    $sql_search .= " ORDER BY id DESC ";
    $sql_offset = "  LIMIT 5 OFFSET $offset ";

    $myWorks =  Works::findByQuery($sql . $sql_search  . $sql_offset, $params);

    $totalRecords = Works::getTotalRecord($sql_total . $sql_search, $params);

    // Tính tổng số trang
    $totalPages = ceil($totalRecords / 5);

    if ($page > $totalPages) {
      $page = $totalPages;
    }

    if ($page < 1) {
      $page = 1;
    }
    $messages = [];
    //checking messages:
    if (Session::get("result")) {
      $messages = Session::get("result");
      Session::delete("result");
    }

    $this->render([
      'title' => "works",
      'myWorks' => $myWorks,
      'type' => $type,
      'paramsSearch' => $paramsSearch,
      'currentPage' => $page,
      'totalPages' => $totalPages,
      'messages' => $messages
    ]);
  }
  function createAction()
  {
    $messages = [];
    $data = [];
    if (!empty($_POST)) {

      //check valid field post
      $this->checkValidPost($messages);

      if (!empty($messages)) {
        goto end;
      }
      foreach ($_POST as $key => $post) {
        $data[$key] = trim($post);
      }
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
      $result = [
        'status' => "success",
        'message' => "Save work success!"
      ];
      Session::set("result", $result);
      header("Location: /my-works");
      die();
    }

    end:
    $this->render([
      'data' => $data,
      'messages' => $messages,
      'title' => "Create",
      'action' => 'create'
    ]);
  }
  function updateAction()
  {
    $id = $_GET['id'];
    $work = Works::findById($id);
    if (!$work) {
      header("Location: /my-works");
      die();
    }
    $data = [
      'id' => $work->getId(),
      'work_name' => $work->getWorkName(),
      'work_content' => $work->getWorkContent(),
      'work_start_date' => $work->getWorkStartDate(),
      'work_end_date' => $work->getWorkEndDate(),
      'work_status' => $work->getWorkStatus(),
    ];
    $messages = [];
    if (!empty($_POST)) {

      //check valid field post
      $this->checkValidPost($messages);
      
      if (!empty($messages)) {
        goto end;
      }
      foreach ($_POST as $key => $post) {
        $data[$key] = trim($post);
      }

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
      $result = [
        'status' => "success",
        'message' => "Update work success!"
      ];
      Session::set("result", $result);
      header("Location: /my-works");
      die();
    }

    end:
    $this->render(
      [
        'data' => $data,
        'messages' => $messages,
        'title' => "Update",
        'action' => 'update?id=' . $data['id']
      ],
      'works/create'
    );
  }

  function deleteAction()
  {

    $messages = [];
    if (empty($_POST['item'])) {
      $messages = [
        'status' => 'danger',
        'message' => 'Has error'
      ];
      goto end;
    }
    $arrId = $_POST['item'];
    if (empty($arrId)) {
      $messages = [
        'status' => 'danger',
        'message' => 'please check item'
      ];
      goto end;
    }
    foreach ($arrId as $id) {
      $work = Works::findById($id);
      if (!$work->delete()) {
        $messages = [
          'status' => 'danger',
          'message' => 'Delete false'
        ];
        goto end;
      }
      $messages = [
        'status' => 'success',
        'message' => 'Delete success'
      ];
    }



    end:
    Session::set("result", $messages);
    header("Location: /my-works");
    die();
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
