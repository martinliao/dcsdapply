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
        border-color: gray;
        margin-top: 6px;
        margin-bottom: 5px;
        margin-right: 5px;
        margin-left: 5px;
    }
    div.applied{
        background-color: #ffd8a2;
    }
    button.applied{
        background-color: black;
        color: white;
        border-color: blanchedalmond;
    }
</style>

<style>    
    .fixed_header tbody{
      display:block;
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
        $('#main_table.fixed_header tbody').css('height',(total_height - 180)+'px');
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



?>

<div class="row">
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">志工報名</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div style="padding-left: calc((100% - 1134px) / 2);padding-right: calc((100% - 1134px) / 2);">
                <div class="row" style="margin-bottom: 10px;">
                    <div class="col-md-4" style="text-align: left">
                        <a href="<?php echo base_url('/volunteer_apply/index/'.strtotime(($week_list[3]).'-4 day')) ?>"><button>《上一週</button></a>
                    </div>                
                    <div class="col-md-4">
                        
                    </div>                
                    <div class="col-md-4" style="text-align: right">
                        <a href="<?php echo base_url('/volunteer_apply/index/'.strtotime(($week_list[3]).'+4 day')) ?>"><button>下一週》</button></a>
                    </div>                
                </div>
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
                                    echo '
                                    <th class="px135 week_title '.(date('m',strtotime($date))!=$SHOW_MONTH?'date_disabled':null).'" date_no_in_pre_week="'.$key.'">
                                        <span class="date">'.$date.'</span><br>
                                        ('.$WEEK_INDEX[$key].')
                                    </th>
                                    ';
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody class="special_scrollbar" style="height:500px;">
                        <?php 
                            foreach ($volunteer_list as $vID => $classroom_list)
                            {
                                $rowspan = count($classroom_list);
                                $rowspan_done = false;
                                foreach ($classroom_list as $cID => $vc_data)
                                {
                                    echo '<tr class="data_row">';
                                    if($vc_data->others)
                                    {
                                        echo '<td class="px180" rowspan="'.$rowspan.'" colspan="2" style="font-size: 20px;"><b>'.$vc_data->volunteerName.'</b></td>';
                                    }
                                    else
                                    {
                                        if(!$rowspan_done)
                                            echo '<td class="px60" rowspan="'.$rowspan.'" style="font-size: 20px;"><b>'.$vc_data->volunteerName.'</b></td>';

                                        echo '<td class="px120" style="font-size: 18px;"><b>'.$vc_data->classroomName.'</b></td>';
                                    }
                                    $rowspan_done = true;                            


                                    foreach ($week_list as $key => $date)
                                    {
                                        echo '<td class="apply_data_list px135 '.(date('m',strtotime($date))!=$SHOW_MONTH?'date_disabled':null).'">';
                                        // 如果是可以顯示的月份
                                        if(date('m',strtotime($date))==$SHOW_MONTH)
                                        {
                                            echo '<div style="text-align:left">';
                                            if(!$vc_data->others)
                                            {
                                                if(!empty($course_list[$vc_data->vcID][$date]))
                                                {
                                                    $list_str = array();
                                                    foreach ($course_list[$vc_data->vcID][$date] as $type => $course_data_pre_type)
                                                    {
                                                        $time_str = date('Hi',strtotime($course_data_pre_type->start_time)).'~'.date('Hi',strtotime($course_data_pre_type->end_time));

                                                        // 報名按鈕
                                                        $action = 'apply(\''.$vc_data->vcID.'\',\''.strtotime($date).'\',\''.$type.'\')';
                                                        $action_str = '報名';
                                                        $applied_class = null;

                                                        if(!empty($apply_data[$vc_data->vcID][$date][$type][$userID]))
                                                        {
                                                            $action = 'cancel(\''.$apply_data[$vc_data->vcID][$date][$type][$userID]->id.'\')';
                                                            $action_str = '取消';
                                                            $applied_class = 'applied';
                                                        }

                                                        $tmp_str ='';
                                                        $tmp_str.='<div class="apply_info '.$applied_class.'">';                                                
                                                        $tmp_str.='<label>'.$time_str.'&nbsp;'.$course_data_pre_type->name.'</label><br>';
                                                        $tmp_str.='<div style="text-align:center" class="applied_person">';
                                                        if(!empty($apply_data[$vc_data->vcID][$date][$type]))
                                                        {
                                                            $users = array();
                                                            foreach ($apply_data[$vc_data->vcID][$date][$type] as $key_userID => $each_applied_user)
                                                            {
                                                                $userName_str = $each_applied_user->userName_enc;
                                                                if($each_applied_user->got_it)
                                                                    $userName_str = '<span class="got_it">'.$userName_str.'</span>';
                                                                $users[] = $userName_str;
                                                            }
                                                            $tmp_str.= implode('<br>',$users);
                                                        }
                                                        $tmp_str.='</div>';
                                                        $tmp_str.='<div style="width:100%; text-align:right"><button class="'.$applied_class.'" onclick="'.$action.'">'.$action_str.'</button></div>';
                                                        $tmp_str.='</div>';
                                                        $list_str[] = $tmp_str;
                                                    }
                                                    echo implode('<hr class="break_line">',$list_str);
                                                }
                                            }
                                            else
                                            {
                                                $list_str = array();
                                                if(!empty($vc_data->morning_start) && !empty($vc_data->morning_start))
                                                {
                                                    $type=1;
                                                    $time_str = $vc_data->morning_start.'~'.$vc_data->morning_end;

                                                    // 報名按鈕
                                                    $action = 'apply(\''.$vc_data->vcID.'\',\''.strtotime($date).'\',\''.$type.'\')';
                                                    $action_str = '報名';
                                                    $applied_class = null;
                                                    // 如果已經報名過了
                                                    if(!empty($apply_data[$vc_data->vcID][$date][$type][$userID]))
                                                    {
                                                        $action = 'cancel(\''.$apply_data[$vc_data->vcID][$date][$type][$userID]->id.'\')';
                                                        $action_str = '取消';
                                                        $applied_class = 'applied';
                                                    }

                                                    $tmp_str = '
                                                        <div class="apply_info '.$applied_class.'">
                                                            <label>'.$time_str.'</label><br>
                                                            <div style="text-align:center" class="applied_person">';
                                                    if(!empty($apply_data[$vc_data->vcID][$date][$type]))
                                                    {
                                                        $users = array();
                                                        foreach ($apply_data[$vc_data->vcID][$date][$type] as $key_userID => $each_applied_user)
                                                        {
                                                            $userName_str = $each_applied_user->userName_enc;
                                                            if($each_applied_user->got_it)
                                                                $userName_str = '<span class="got_it">'.$userName_str.'</span>';
                                                            $users[] = $userName_str;
                                                        }
                                                        $tmp_str.= implode('<br>',$users);
                                                    }
                                                    $tmp_str .='
                                                            </div>                                                            
                                                            <div style="width:100%; text-align:right"><button class="'.$applied_class.'" onclick="'.$action.'">'.$action_str.'</button></div>
                                                        </div>
                                                    ';

                                                    $list_str[] = $tmp_str;

                                                }
                                                if(!empty($vc_data->afternoon_start) && !empty($vc_data->afternoon_start))
                                                {
                                                    $type=2;
                                                    $time_str = $vc_data->afternoon_start.'~'.$vc_data->afternoon_end;

                                                    // 報名按鈕
                                                    $action = 'apply(\''.$vc_data->vcID.'\',\''.strtotime($date).'\',\''.$type.'\')';
                                                    $action_str = '報名';
                                                    $applied_class = null;
                                                    // 如果已經報名過了
                                                    if(!empty($apply_data[$vc_data->vcID][$date][$type][$userID]))
                                                    {
                                                        $applied_class = 'applied';
                                                        $action = 'cancel(\''.$apply_data[$vc_data->vcID][$date][$type][$userID]->id.'\')';
                                                        $action_str = '取消';
                                                    }

                                                    $tmp_str = '
                                                        <div class="apply_info '.$applied_class.'">
                                                            <label>'.$time_str.'</label><br>
                                                            <div style="text-align:center" class="applied_person">';
                                                    if(!empty($apply_data[$vc_data->vcID][$date][$type]))
                                                    {
                                                        $users = array();
                                                        foreach ($apply_data[$vc_data->vcID][$date][$type] as $key_userID => $each_applied_user)
                                                        {
                                                            $userName_str = $each_applied_user->userName_enc;
                                                            if($each_applied_user->got_it)
                                                                $userName_str = '<span class="got_it">'.$userName_str.'</span>';
                                                            $users[] = $userName_str;
                                                        }
                                                        $tmp_str.= implode('<br>',$users);
                                                    }
                                                    $tmp_str .='
                                                            </div>                                                            
                                                            <div style="width:100%; text-align:right"><button class="'.$applied_class.'" onclick="'.$action.'">'.$action_str.'</button></div>
                                                        </div>
                                                    ';
                                                    $list_str[] = $tmp_str;

                                                }
                                                
                                                echo implode('<hr class="break_line">',$list_str);
                                            }
                                            echo '</div>';
                                        }
                                        else
                                        {
                                            echo '(不開放)';
                                        }
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
    function apply(vcID,date,type){
        var post_data = {'vcID':vcID,'date':date,'type':type};
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
</script>