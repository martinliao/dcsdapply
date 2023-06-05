<script type="text/javascript">
  $(function () {
    $("#example1").dataTable();
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
</script>

<div class="row">
<div class="col-xs-12">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">課程管理列表</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
      <table id="example2" class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>序號</th>
            <th>課程編號(索引)</th>
            <th>課程名稱</th>
            <th>操作</th>
           </tr> 
        </thead>
        <tbody>
        <?php 
          for($i=0;$i<count($course);$i++){
               echo '<tr>
                      <td>'.($i+1).'</td>
                      <td>'.$course[$i]->idnumber.'</td>
                      <td>'.$course[$i]->fullname.'</td> 
                      <td>
                        <div class="btn-dataset">
                          <a href="http://elearning.taipei/eda/manage/course_manage/course_info?id='.$course[$i]->id.'" title="edit" class="btn btn-default btn-xs"><i class="fa fa-pencil fa-eye"></i>檢視編輯</a>  
                        </div>
                      </td>
                    </tr>';
          }  

        ?>
         
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>

