<script type="text/javascript">
  $(function () {
    $('#example2').dataTable({
      oLanguage:  {
              "sProcessing": "處理中...",
              "sLengthMenu": "顯示 _MENU_ 筆記錄",
              "sZeroRecords": "<font color='red'>目前無您可管理的資料集</font>",
              "sInfo": "目前記錄：_START_ 至 _END_, 總筆數：_TOTAL_",
              "sInfoEmpty": "無任何資料",
              "sInfoFiltered": "(過濾總筆數 _MAX_)",
              "sInfoPostFix": "",
              "sSearch": "搜尋",
              "sUrl": "",
              "oPaginate": {
                  "sFirst":    "首頁",
                  "sPrevious": "上頁",
                  "sNext":     "下頁",
                  "sLast":     "末頁"
              }
          },
        deferRender: true,
        select:{
            style:'single',
            blurable: true
        }
    });
  });

  function backFun(){
    location.href="http://elearning.taipei/eda/manage/Instant_message/";
  }
</script>

<div class="row">
<div class="col-xs-12">
  <div class="box">
    <div class="box-header">
      <input type="button" id="back_btn" value="返回" onclick="backFun()"></input>
    </div><!-- /.box-header -->
    <div class="box-body">
      <table class="table table-bordered table-hover">
        <thead>
          <tr style="border-bottom:2px solid #000000">
            <th>
              寄件者：系統管理者
              <br><br>
              收件者：<?php 
                        if($message[0]->recipient_id == 'all'){
                          $message[0]->recipient_name = '臺北e大所有會員';
                        } 

                        echo $message[0]->recipient_name;
                      ?>
              <br><br>
              標&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;題：<?php  echo $message[0]->title; ?>
              <br><br>
              日&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;期：<?php  echo $message[0]->send_time; ?>
            </th>
          </tr> 
        </thead>
      </table>
    </div>
    <div class="box-body">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>
              <?php  echo htmlspecialchars_decode($message[0]->content); ?>
            </th>
          </tr> 
        </thead>
      </table>
    </div>
    <div class="dataTables_paginate paging_simple_numbers">
      <ul class="pagination">
        <?php
          if(!empty($search)){
            if($first == $message[0]->id){
              echo '<li class="paginate_button disabled">
                  <a href="#">第一封</a>
                </li>';
            } else {
              echo '<li class="paginate_button">
                  <a href="http://elearning.taipei/eda/manage/Instant_message/'.$first.'/'.$search.'">第一封</a>
                </li>';
            }
            
          } else {
             if($first == $message[0]->id){
              echo '<li class="paginate_button disabled">
                  <a href="#">第一封</a>
                </li>';
            } else {
              echo '<li class="paginate_button">
                  <a href="http://elearning.taipei/eda/manage/Instant_message/view/'.$first.'">第一封</a>
                </li>';
            }
          }
        ?>
        <?php
          if($prev > 0){
            if(!empty($search)){
              echo '<li class="paginate_button">
                    <a href="http://elearning.taipei/eda/manage/Instant_message/'.$prev.'/'.$search.'">上一封</a>
                  </li>';
            } else {
              echo '<li class="paginate_button">
                    <a href="http://elearning.taipei/eda/manage/Instant_message/view/'.$prev.'">上一封</a>
                  </li>';
            }
          } else {
            echo '<li class="paginate_button disabled">
                    <a href="#">上一封</a>
                  </li>';
          }
         
        ?>
        <?php
          if($next > 0){
            if(!empty($search)){
              echo '<li class="paginate_button">
                    <a href="http://elearning.taipei/eda/manage/Instant_message/'.$next.'/'.$search.'">下一封</a>
                  </li>';
            } else {
              echo '<li class="paginate_button">
                    <a href="http://elearning.taipei/eda/manage/Instant_message/view/'.$next.'">下一封</a>
                  </li>';
            }
          } else {
            echo '<li class="paginate_button disabled">
                    <a href="#">下一封</a>
                  </li>';
          }
         
        ?>
        <?php
          if(!empty($search)){
            if($final == $message[0]->id){
              echo '<li class="paginate_button disabled">
                  <a href="#">最末封</a>
                </li>';
            } else {
              echo '<li class="paginate_button">
                  <a href="http://elearning.taipei/eda/manage/Instant_message/'.$final.'/'.$search.'">最末封</a>
                </li>';
            }
            
          } else {
            if($final == $message[0]->id){
              echo '<li class="paginate_button disabled">
                  <a href="#">最末封</a>
                </li>';
            } else {
              echo '<li class="paginate_button">
                  <a href="http://elearning.taipei/eda/manage/Instant_message/view/'.$final.'">最末封</a>
                </li>';
            }
          }
        ?>
      </ul>
    </div>
  </div>
</div>
</div>