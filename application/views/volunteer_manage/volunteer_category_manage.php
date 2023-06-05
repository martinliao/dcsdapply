<script type="text/javascript">
  $(function () {
    $('#example2').dataTable({
      oLanguage:  {
              "sProcessing": "處理中...",
              "sLengthMenu": "顯示 _MENU_ 筆記錄 <a href='<?php echo base_url();?>volunteer_manage/volunteer_category_edit/0'><button type='button' class='btn btn-success btn-flat'>新增</button></a>",
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
      <h3 class="box-title">H.志工種類管理</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
      <table id="example2" class="table table-bordered table-hover" style="text-align:center;vertical-align:middle">
        <thead>
          <tr>
            <th style="text-align:center;">序號</th>
            <th style="text-align:center;">志工名稱</th>
            <th style="text-align:center;">起</th>
            <th style="text-align:center;">訖</th>
            <th style="text-align:center;">每月可報班別</th>
            <th style="text-align:center;">編輯</th>
           </tr> 
        </thead>
        <tbody>
        <?php 
          for($i=0;$i<count($list);$i++){
               echo '<tr>
                      <td style="vertical-align:middle">'.($i+1).'</td>
                      <td style="vertical-align:middle">'.$list[$i]->name.'</td>
                      <td style="vertical-align:middle">'.$list[$i]->morning_start.'<br>'.$list[$i]->afternoon_start.'</td> 
                      <td style="vertical-align:middle">'.$list[$i]->morning_end.'<br>'.$list[$i]->afternoon_end.'</td>
                      <td style="vertical-align:middle">'.$list[$i]->sign_month.'</td>
                      <td style="vertical-align:middle">
                        <div class="btn-dataset">
                          <a href="'.base_url().'volunteer_manage/volunteer_category_edit/'.$list[$i]->id.'" title="edit" class="btn btn-default btn-xs"><i class="fa fa-pencil fa-eye"></i>檢視編輯</a>  
                          <a href="'.base_url().'volunteer_manage/volunteer_category_del/'.$list[$i]->id.'" title="edit" class="btn btn-default btn-xs"><i class="fa fa-pencil fa-cut"></i>刪除</a>  
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

