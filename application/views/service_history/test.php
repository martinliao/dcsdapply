<style>
    #main_table{
        font-family: '微軟正黑體';
        height: 300px;
    }
    #main_table th,#main_table td{
        padding: 5px;
        text-align: center;
    }
    #main_table th{
        background-color: #0e324d;
        color: white;
        text-align: center;
        font-size: 16px;
        font-weight: 600;
    }
    #main_table th.week_title{
        background-color: #4e95cc;
    }
    #main_table th.date_disabled{
        background-color: #5e5e5e;
    }
    #main_table td.date_disabled{
        background-color: #e6e6e6;
    }
    #main_table>thead>tr>th,#main_table>tbody>tr>td{
        border: 1px solid #00000091;
    }
    tr.data_row>td>div{
        min-height: 80px;
    }
    .px60{
        
        width: 60px;
        min-width: 60px;
        max-width: 60px;
    }
    .px120{
        
        width: 120px;
        min-width: 120px;
        max-width: 120px;
    }
    .px135{
        
        width: 140px;
        min-width: 140px;
        max-width: 140px;
    }
    .px180{
        
        width: 180px;
        min-width: 180px;
        max-width: 180px;
    }

    .fixed_header tbody{
      display:block;
      overflow:auto;
      height:500px;
      width:100%;
    }
    .fixed_header thead tr{
      display:block;
    }
    .fixed_header tbody {
        overflow: -moz-hidden-unscrollable;
        /*height: 100%;*/
    }

    .fixed_header tbody::-webkit-scrollbar {
        display: none;
    }

    .fixed_header tbody {
        -ms-overflow-style: none;
        /*height: 100%;*/
        /*width: calc(100vw + 18px);*/
        overflow: auto;
    }
</style>

<table id="main_table" class="fixed_header">
   <thead>
      <tr>
         <th class="px60">
            志工<br>類別
         </th>
         <th class="px120">
            場地
         </th>
         <th class="px135 week_title date_disabled" date_no_in_pre_week="0">
            <span class="date">2018-12-30</span><br>
            (日)
         </th>
         <th class="px135 week_title date_disabled" date_no_in_pre_week="1">
            <span class="date">2018-12-31</span><br>
            (一)
         </th>
         <th class="px135 week_title " date_no_in_pre_week="2">
            <span class="date">2019-01-01</span><br>
            (二)
         </th>
         <th class="px135 week_title " date_no_in_pre_week="3">
            <span class="date">2019-01-02</span><br>
            (三)
         </th>
         <th class="px135 week_title " date_no_in_pre_week="4">
            <span class="date">2019-01-03</span><br>
            (四)
         </th>
         <th class="px135 week_title " date_no_in_pre_week="5">
            <span class="date">2019-01-04</span><br>
            (五)
         </th>
         <th class="px135 week_title " date_no_in_pre_week="6">
            <span class="date">2019-01-05</span><br>
            (六)
         </th>
      </tr>
   </thead>
   <tbody>
      <tr class="data_row">
         <td class="px60" style="font-size: 20px;"><b>班務</b></td>
         <td class="px120" style="font-size: 18px;"><b>B202教室</b></td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
               <div>
                  <label>0800~1200&emsp;班期A</label><br>
                  <div style="text-align:center"></div>
                  <div style="width:100%; text-align:right"><button>報名</button></div>
               </div>
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
               <div>
                  <label>1320~1430&emsp;班期C</label><br>
                  <div style="text-align:center"></div>
                  <div style="width:100%; text-align:right"><button>報名</button></div>
               </div>
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
      </tr>
      <tr class="data_row">
         <td class="px60" style="font-size: 20px;"><b>班務</b></td>
         <td class="px120" style="font-size: 18px;"><b>B203禮堂</b></td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
               <div>
                  <label>0800~1230&emsp;班期B</label><br>
                  <div style="text-align:center"></div>
                  <div style="width:100%; text-align:right"><button>報名</button></div>
               </div>
               <hr>
               <div>
                  <label>1330~1730&emsp;班期B</label><br>
                  <div style="text-align:center"></div>
                  <div style="width:100%; text-align:right"><button>報名</button></div>
               </div>
               <hr>
               <div>
                  <label>1800~2000&emsp;班期B</label><br>
                  <div style="text-align:center"></div>
                  <div style="width:100%; text-align:right"><button>報名</button></div>
               </div>
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
      </tr>
      <tr class="data_row">
         <td class="px60" style="font-size: 20px;"><b>班務</b></td>
         <td class="px120" style="font-size: 18px;"><b>C區大禮堂</b></td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
      </tr>
      <tr class="data_row">
         <td class="px60" style="font-size: 20px;"><b>班務</b></td>
         <td class="px120" style="font-size: 18px;"><b>E101教室</b></td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
      </tr>
      <tr class="data_row">
         <td class="px60" style="font-size: 20px;"><b>班務</b></td>
         <td class="px120" style="font-size: 18px;"><b>E102國際會議廳</b></td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
      </tr>
      <tr class="data_row">
         <td class="px60" style="font-size: 20px;"><b>班務</b></td>
         <td class="px120" style="font-size: 18px;"><b>E201教室</b></td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
      </tr>
      <tr class="data_row">
         <td class="px60" style="font-size: 20px;"><b>班務</b></td>
         <td class="px120" style="font-size: 18px;"><b>E202教室</b></td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
      </tr>
      <tr class="data_row">
         <td class="px60" style="font-size: 20px;"><b>班務</b></td>
         <td class="px120" style="font-size: 18px;"><b>E203教室</b></td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
      </tr>
      <tr class="data_row">
         <td class="px60" style="font-size: 20px;"><b>班務</b></td>
         <td class="px120" style="font-size: 18px;"><b>E206教室</b></td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
      </tr>
      <tr class="data_row">
         <td class="px60" style="font-size: 20px;"><b>班務</b></td>
         <td class="px120" style="font-size: 18px;"><b>E301電腦教室</b></td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
      </tr>
      <tr class="data_row">
         <td class="px60" style="font-size: 20px;"><b>班務</b></td>
         <td class="px120" style="font-size: 18px;"><b>E區地下1樓音樂教室</b></td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
            </div>
         </td>
      </tr>
      <tr class="data_row">
         <td class="px180" colspan="2" style="font-size: 20px;"><b>警衛</b></td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
               <pre>非班務志工</pre>
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
               <pre>非班務志工</pre>
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
               <pre>非班務志工</pre>
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
               <pre>非班務志工</pre>
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
               <pre>非班務志工</pre>
            </div>
         </td>
      </tr>
      <tr class="data_row">
         <td class="px180" colspan="2" style="font-size: 20px;"><b>圖書</b></td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
               <pre>非班務志工</pre>
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
               <pre>非班務志工</pre>
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
               <pre>非班務志工</pre>
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
               <pre>非班務志工</pre>
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
               <pre>非班務志工</pre>
            </div>
         </td>
      </tr>
      <tr class="data_row">
         <td class="px180" colspan="2" style="font-size: 20px;"><b>客服</b></td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
               <pre>非班務志工</pre>
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
               <pre>非班務志工</pre>
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
               <pre>非班務志工</pre>
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
               <pre>非班務志工</pre>
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
               <pre>非班務志工</pre>
            </div>
         </td>
      </tr>
      <tr class="data_row">
         <td class="px180" colspan="2" style="font-size: 20px;"><b>園藝</b></td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 date_disabled">
            <div style="text-align:left">
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
               <pre>非班務志工</pre>
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
               <pre>非班務志工</pre>
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
               <pre>非班務志工</pre>
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
               <pre>非班務志工</pre>
            </div>
         </td>
         <td class="px135 ">
            <div style="text-align:left">
               <pre>非班務志工</pre>
            </div>
         </td>
      </tr>
   </tbody>
</table>

<script>
    $(function(){
        var total_height = $('.content-wrapper').height();
        $('#main_table.fixed_header tbody').css('height',(total_height - 100)+'px');
    });
</script>