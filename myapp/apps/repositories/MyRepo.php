<?php

namespace MyTodoList\Reponsetories;

class MyRepo
{
    public static function formatDateTime($time_stamp)
    {
        return date("Y-m-d", $time_stamp);
    }
    public static function getComboboxStatusWork($statusParam) {
      $html = "";
      foreach (WorksRepo::ARR_STATUS as $status) {
        $selected = '';
        if ( $status == $statusParam) {
            $selected = 'selected';
        }
        $statusName = ucfirst($status);
        $html .=  "<option  $selected  value='$status'>$statusName</option>";
      }
      return $html;
    
    }

    public static function paging($totalPages, $currentPage, $url_param)
    {
        $nextPage =  $currentPage + 1;
        $prePage = $currentPage - 1;
        $html_page = "";
        for ($i = 1; $i <= $totalPages; $i++) {
            $html_page .= ' <li class="page-item ' . ($i == $currentPage ? 'active' : '') . ' ">
            <a class="page-link" href="/my-works?page=' . $i . "&".$url_param.  '">' . $i . '</a>
          </li>';
        }
        $html_pre_page = "";
   
        if($prePage) {
            $html_pre_page = '<li class="page-item">
            <a class="page-link" href="?page=' . $prePage . "&".$url_param. '" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>';
        }
        $html_next_page = "";
        if($nextPage <= $totalPages) {
            $html_next_page = '<li class="page-item">
            <a class="page-link" href="?page=' . $nextPage. "&".$url_param . '" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>';
        }
       
       
        $html = '<div class="card-body p-0">
        <div class="pagination-container mt-3">
          <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
              '. $html_pre_page. $html_page . $html_next_page. '
               
          </ul>
        </nav>
      </div>
    </div>';
        return $html;
    }
}
