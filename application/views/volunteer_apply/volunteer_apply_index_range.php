<style>
    #main_table{
        font-family: '微軟正黑體';
    }
    #main_table th,#main_table td{
        padding: 5px;
        text-align: center;
    }
    #main_table td.apply_data_list{
        padding: 0px
    }
    div.apply_info{
        padding: 5px
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
        background-color: #8b8b8b;
    }
    #main_table tr th,#main_table tr td{
        /*border: 1px solid #00000091;*/
        border-width: 1px;
        border-style: solid;
        border-color: #00000091;

    }
    tr.data_row>td>div{
        min-height: 60px;
    }
    .px60{
        min-width: 60px;
        width: 60px;
    }
    .px120{
        min-width: 120px;
        width: 120px;
    }
    .px135{
        min-width: 135px;
        width: 135px;
    }
    .px180{
        min-width: 180px;
        width: 180px;
    }
    hr.break_line{
        border-style: dashed;
        border-color: #636363;
        border-width: 1px;
        margin-top: -2px;
        margin-bottom: 0px;
        margin-right: 5px;
        margin-left: 5px;
    }
    div.can_apply{
        background-color: #51cf56cc;
    }
    div.applied{
        background-color: #ffd8a2;
    }
    button.applied{
        background-color: black;
        color: white;
        border-color: blanchedalmond;
    }

    /* 2019 05 06 鵬加上 */
    table {
        /* table-layout: fixed;
        word-wrap:break-word; */
        word-break: break-all;
    }
    /* 2019 05 06 鵬加上 */
    div.long_range{
        background-color: #8ea0ff;
    }     
</style>

<style>    
    #main_div{
        overflow: hidden;
    }
    .fixed_header tbody{
        display:block;
        overflow:auto;
        overflow:overlay;
        width:100%;
    }
    .fixed_header thead tr{
      display:block;
    }

    .got_it{
        color: #e60000;
    }

    .special_scrollbar::-webkit-scrollbar-track
    {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        border-radius: 10px;
        background-color: #F5F5F5;
    }

    .special_scrollbar::-webkit-scrollbar
    {
        width: 8px;
        height: 8px;
        background-color: #F5F5F5;
    }

    .special_scrollbar::-webkit-scrollbar-thumb
    {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
        background-color: #555;
    }
</style>

<script>
    $(function(){
        var total_height = $('.content-wrapper').css('min-height');
        total_height = total_height.replace(/[a-z ]/gi,"");
        $('#main_table.fixed_header tbody').css('height',(total_height - 260)+'px');
        $('#main_div').css('height',(total_height - 200)+'px');
    });
</script>

<?php 
$NOW_MONTH = date('m');
$SHOW_MONTH = ($NOW_MONTH+1)%12;
$WEEK_INDEX = array(
    0 => '日',
    1 => '一',
    2 => '二',
    3 => '三',
    4 => '四',
    5 => '五',
    6 => '六',
);
$TIME_TYPE_INDEX = array(
    1 => '上午',
    2 => '下午',
    3 => '晚上',
);


// seeData(date('Y-m-d',strtotime(($week_list[3]).'-4 day')));
?>

<div class="row">
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">志工報名-顯示狀況</h3><br>

            查詢起迄：<input type="text" class="datepicker" name="start_date" id="start_date" value="<?=$start_date?>"> 至 <input type="text" class="datepicker" name="end_date" id="end_date" value="<?=$end_date?>"> <button type="button" onclick="search_range()">查詢</button><br>

            注意事項：<?=$note ?>
            <br>
            公告更新時間：<?php echo ROCdate('Y/m/d H:i:s');?>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div style="padding-left: calc((100% - 1134px) / 2);padding-right: calc((100% - 1134px) / 2);">
<!--                 <div class="row" style="margin-bottom: 10px;">
                    <div class="col-md-4" style="text-align: left">
                        <a href="<?php echo base_url('/volunteer_apply/'.($ONLY_ME?'only_me':'index').'/'.strtotime(($week_list[3]).'-4 day')) ?>"><button>《上一週</button></a>
                    </div>                
                    <div class="col-md-4">
                        
                    </div>                
                    <div class="col-md-4" style="text-align: right">
                        <a href="<?php echo base_url('/volunteer_apply/'.($ONLY_ME?'only_me':'index').'/'.strtotime(($week_list[3]).'+4 day')) ?>"><button>下一週》</button></a>
                    </div>                
                </div> -->
                <div id="main_div" class="special_scrollbar" style="overflow-x: auto;">
                    <table id="main_table" class="fixed_header" width="100%">
                        <thead>
                            <tr>
                                <th class="px60">
                                    志工<br>類別
                                </th>
                                <th class="px120">
                                    場地
                                </th>
                                <?php 
                                foreach ($week_list as $key => $date)
                                {
                                    // seeData($key);
                                    // 只顯示大於今天至下個月月底為止                                    
                                    $SHOW = (strtotime($date)>strtotime(date('Y-m-d'))) && strtotime(date('Y-m-01').' + 2 month')>strtotime($date);
                                    echo '
                                    <th class="px135 week_title '.(!$SHOW?'date_disabled':null).'" date_no_in_pre_week="'.(date('w',strtotime($date))).'">
                                        <span class="date">'.$date.'</span><br>
                                        ('.$WEEK_INDEX[date('w',strtotime($date))].')
                                    </th>
                                    ';
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody class="special_scrollbar" style="height:500px;">
                        <?php 
                            foreach ($vc_list as $vID => $pre_classroom_for_each_volunteer)
                            {
                                $rowspan = count($pre_classroom_for_each_volunteer);
                                $rowspan_done = false;
                                foreach ($pre_classroom_for_each_volunteer as $cID => $vc_data)
                                {
                                    echo '<tr class="data_row">';
                                    if($vc_data->others)
                                    {
                                        echo '<td class="px180" rowspan="'.$rowspan.'" colspan="2" style="font-size: 20px;word-break: break-all;"><b>'.$vc_data->volunteerName.'</b></td>';
                                    }
                                    else
                                    {
                                        if(!$rowspan_done)
                                            echo '<td class="px60" rowspan="'.$rowspan.'" style="font-size: 20px;word-break: break-all;"><b>'.$vc_data->volunteerName.'</b></td>';

                                        echo '<td class="px120" style="font-size: 18px;"><b>'.$vc_data->classroomName.'</b></td>';
                                    }
                                    $rowspan_done = true;                            


                                    foreach ($week_list as $key => $date)
                                    {
                                        $there_is_data = false;
                                        $data_str = '(未開放)';

                                        // 只顯示大於今天至下個月月底為止
                                        $SHOW = (strtotime($date)>strtotime(date('Y-m-d'))) && strtotime(date('Y-m-01').' + 2 month')>strtotime($date);
                                        if($SHOW)
                                        {
                                            // 如果這天有資料
                                            if(!empty($calendar_list[$vc_data->vcID][$date]))
                                            {
                                                $list_str = array();
                                                foreach ($calendar_list[$vc_data->vcID][$date] as $type => $calendar_data)
                                                {
                                                    // 如果不開放就PASS
                                                    if(!$calendar_data->status)
                                                        continue;

                                                    // 如果不在報名時間內也PASS
                                                    if(isset($calendar_data->apply_start) && $calendar_data->apply_end && (date('Y-m-d')< $calendar_data->apply_start || date('Y-m-d')> $calendar_data->apply_end ))
                                                        continue;


                                                    if($ONLY_ME && empty($apply_data[$calendar_data->id][$userID]))
                                                        continue;

                                                    $there_is_data = true;                                                    

                                                    // 時段的標題文字，僅班務志工要顯示課程名稱
                                                    $time_str = date('Hi',strtotime($calendar_data->start_time)).'~'.date('Hi',strtotime($calendar_data->end_time));
                                                    $title_str = $time_str.(!empty($calendar_data->courseName)?'&nbsp;'.$calendar_data->courseName.'('.$calendar_data->term.')'.$calendar_data->worker.'('.$calendar_data->hours.')':null);

                                                    // 報名按鈕
                                                    $action = 'apply(\''.$calendar_data->id.'\')';
                                                    $action_str = '報名';
                                                    $applied_class = null;
                                                    $can_apply_class = 'can_apply';
                                                    $applied_count = isset($apply_data[$calendar_data->id])?count($apply_data[$calendar_data->id]):0;

                                                    // 如果已經報名過了
                                                    if(!empty($apply_data[$calendar_data->id][$userID]))
                                                    {
                                                        $action = 'cancel(\''.$apply_data[$calendar_data->id][$userID]->id.'\')';
                                                        $action_str = '取消';
                                                        $applied_class = 'applied';
                                                        $button_str = '<div style="width:100%; text-align:right"><button class="'.$applied_class.'" onclick="'.$action.'">'.$action_str.'</button></div>';                                                        
                                                    }
                                                    else
                                                    {
                                                        // 報名按鈕(如果額滿則不顯示)
                                                        $button_str = '<div style="width:100%; text-align:right"><button class="'.$applied_class.'" onclick="'.$action.'">'.$action_str.'</button></div>';
                                                        if($calendar_data->num_got_it+$calendar_data->num_waiting <= $applied_count && empty($applied_class))
                                                        {
                                                            $can_apply_class = null;
                                                            $button_str = null;
                                                        }
                                                        // 如果不在報名期間內也不顯示
                                                        if($calendar_data->courseID && (date('Y-m-d')< $calendar_data->apply_start || date('Y-m-d')> $calendar_data->apply_end ))
                                                        {
                                                            $can_apply_class = null;
                                                            $action = 'alert(\'現在不是報名期間!\\n('.$calendar_data->apply_start.'~'.$calendar_data->apply_end.')\')';
                                                            $button_str = '<div style="width:100%; text-align:right"><button class="'.$applied_class.'" onclick="'.$action.'">'.$action_str.'</button></div>';
                                                        }                                                        
                                                    }

                                                    $long_range_class = $calendar_data->long_range?'long_range':null;
                                                    $tmp_str = '
                                                        <div class="apply_info '.$can_apply_class.' '.$applied_class.' '.$long_range_class.'">
                                                            <label>'.$title_str.'</label><br>
                                                            <div style="text-align:center" class="applied_person">';
                                                    if(!empty($apply_data[$calendar_data->id]))
                                                    {
                                                        $users = array();
                                                        foreach ($apply_data[$calendar_data->id] as $key_userID => $each_applied_user)
                                                        {
                                                            $userName_str = $each_applied_user->userName_enc;
                                                            if($each_applied_user->got_it)
                                                                $userName_str = '<span class="got_it">'.$userName_str.'</span>';
                                                            $users[] = $userName_str;
                                                        }
                                                        $tmp_str.= implode('<br>',$users);
                                                    }
                                                    else                                                        
                                                    {
                                                        $tmp_str.= '<span style="color:blue">未報名</span>';
                                                    }
                                                    $tmp_str .='
                                                            </div>
                                                            '.$button_str.'
                                                        </div>
                                                    ';

                                                    $list_str[] = $tmp_str;                                                        
                                                }

                                                if($there_is_data)
                                                {
                                                    $data_str = '<div style="text-align:left">';
                                                    $data_str .= implode('<hr class="break_line">',$list_str);
                                                    $data_str .= '</div>';                                                    
                                                }
                                            }
                                        }

                                        $SHOW = (strtotime($date)>strtotime(date('Y-m-d'))) && strtotime(date('Y-m-01').' + 2 month')>strtotime($date);
                                        echo '<td class="apply_data_list px135 '.( !$SHOW || !$there_is_data?'date_disabled':null).'">';
                                        echo $data_str;
                                        echo'
                                        </td>
                                        ';
                                    }
                                    echo'</tr>';
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>



<script>
    function apply(calendarID){
        var post_data = {'calendarID':calendarID};
        $.post('<?php echo base_url('volunteer_apply/apply') ?>', post_data).done(function(response){
            var json = $.parseJSON(response);

            alert(json.msg);

            if(json.success)
            {
                location.reload();
            }
        });
    }
    function cancel(applyID){
        if(confirm('是否確定取消報名?'))
        {
            var post_data = {'applyID':applyID};
            $.post('<?php echo base_url('volunteer_apply/cancel') ?>', post_data).done(function(response){
                var json = $.parseJSON(response);

                alert(json.msg);

                if(json.success)
                {
                    location.reload();
                }
            });
        }
    }
    function search_range(){
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();



        start_date = (start_date.toString()).split('-');
        end_date = (end_date.toString()).split('-');

        var unixtime_start = 0;
        unixtime_start = (parseInt(start_date[0])+1911)+'-'+start_date[1]+'-'+start_date[2];
        unixtime_start = new Date(unixtime_start);
        unixtime_start = Math.floor(unixtime_start/1000);
        
        var unixtime_end = 0;
        unixtime_end = (parseInt(end_date[0])+1911)+'-'+end_date[1]+'-'+end_date[2];
        unixtime_end = new Date(unixtime_end);
        unixtime_end = Math.floor(unixtime_end/1000);

        location.href="/eda/apply/volunteer_apply/range/"+unixtime_start+"/"+unixtime_end;
    }
    $(function(){

        $(".datepicker").datepickerTW({
            dateFormat: "yy-mm-dd"//,
        });
    })

    
</script>