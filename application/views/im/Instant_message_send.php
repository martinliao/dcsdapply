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
</script>

<div class="row">
<div class="col-xs-12">
  <div class="box">
  <form action="http://elearning.taipei/eda/manage/Instant_message/send/" id="sendq" method="post">
    <div class="box-header">
      <h3 class="box-title" style="color:green;font-weight: bold;font-size: 35px">寄件匣</h3>
      <br>
      <br>
      <input type="button" value="傳送" style="zoom:1.5" onclick="sendFun()"></input>
    </div><!-- /.box-header -->
    <div class="box-body">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>
              寄件者：系統管理者<br><br>
              收件者：<input type="radio" id="mode" name="mode" value="specify" style="zoom:1.2;" checked="checked" onclick="displayFun(1)"/>特定使用者<input type="radio" name="mode" value="all" style="margin-left: 5px;zoom:1.2" onclick="displayFun(-1)" />臺北e大所有會員<br><br>
              身分證：<input type="text" id="cname" name="cname" value="" ></input><br><br>
              標&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;題：<input type="text" name="title" value=""></input>
            </th>
            
           </tr> 
        </thead>
        <tbody>
          <tr>
            <td>
              <textarea id="content" name = "content" rows="8" ></textarea>
            </td>
          </tr>
        </tbody>
      </table>
      <!-- <input type="hidden" id="idno" name="idno" value=""></input> -->
      <input type="hidden" id="act" name="act" value=""></input>
    </div>
  </form>
  </div>
</div>
</div>
<script type="text/javascript">
function displayFun(id){
  if(id > 0){
    document.getElementById('cname').disabled=false;
  } else {
    document.getElementById('cname').value='';
    // document.getElementById('idno').value='';
    document.getElementById('cname').disabled=true;
  }
  
}


// function ajaxFun(){
//   var idno = document.getElementById('cname').value;
//   idno = idno.toUpperCase();
//   var check = CheckTaiwanID(idno);


//   if(check){
//     $.ajax({
//       url: 'http://elearning.taipei/eda/manage/Instant_message_ajax/get_name',
//       dataType: 'text',
//       data: {idno:idno},
//       type: "POST",
//       error: function(xhr) {
//         alert('Ajax request error');
//       },
//       success: function(response) {
//         if(response != '0'){
//           document.getElementById('cname').value = response;
//           document.getElementById('idno').value = idno;
//         } else {
//           alert('查無此人');
//         }
        
//       }
//     });
//   } else {
//     alert('身分證不合法');
//   }
// }

// function CheckTaiwanID(idno) { //身份證檢查函式
//     if(idno.length > 10){
//       return false;
//     }

//     var reg=/^[A-Z]{1}[1-2]{1}[0-9]{8}$/;  //身份證的正規表示式
//     if( reg.test( idno ) ) {
//         var s = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";  //把A取代成10,把B取代成11...的作法
//         var ct = ["10","11","12","13","14","15","16","17","34","18","19","20","21",
//                        "22","35","23","24","25","26","27","28","29","32","30","31","33"];
//         var i = s.indexOf(idno.charAt(0));
//         var tempuserid = ct[i] + idno.substr(1, 9); //若此身份證號若是A123456789=>10123456789
//         var num = tempuserid.charAt(0)*1;
//         for( i=1 ; i<=9 ; i++ ) {
//            num = num + tempuserid.charAt(i)*(10-i);
//         }
//         num += tempuserid.charAt(10)*1;
 
//         if( (num%10)==0 ) {
//            return true;
//         } else {
//            return false;
//         }
//     } else {
//         return false;
//     }
// }

function sendFun(){
  var obj  = document.getElementById('sendq');
  var mode = $("input[name='mode']:checked").val(); 
  var idno = document.getElementById('cname').value;
  if(mode == 'specify' && idno.trim() == ''){
    alert('選取特定使用者時，收件者不能為空');
  } else {
    document.getElementById('act').value = 'send';
    obj.submit();
  }
}

$(function() 
{
  var editor=CKEDITOR.replace("content");
  CKFinder.setupCKEditor( editor,"<?php echo base_url();?>resource/adminlte/plugins/ckfinder/" );
});
</script>
