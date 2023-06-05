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
    #main_div{
        overflow: hidden;
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



?>

<div class="row">
<div class="col-xs-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">B.服務時數查詢及下載服務時數條</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div>
                <form id="post_form" method="POST" action="" target="_blank">
                    <select name="year">
                    <?php 
                        for ($y=2018; $y <= 2028; $y++)
                        { 
                            echo '<option value="'.$y.'" '.(date('Y')==$y?'selected':null).'>'.$y.'</option>';
                        }
                    ?>
                    </select>
                    年
                    <select name="month_start">
                    <?php 
                        for ($m=1; $m <= 12; $m++)
                        { 
                            echo '<option value="'.str_pad($m,2,'0',STR_PAD_LEFT).'" '.((date('m'))==$m?'selected':null).'>'.str_pad($m,2,'0',STR_PAD_LEFT).'</option>';
                        }
                    ?>
                    </select>
                    月 至 
                    <select name="month_end">
                    <?php 
                        for ($m=1; $m <= 12; $m++)
                        { 
                            echo '<option value="'.str_pad($m,2,'0',STR_PAD_LEFT).'" '.((date('m'))==$m?'selected':null).'>'.str_pad($m,2,'0',STR_PAD_LEFT).'</option>';
                        }
                    ?>
                    </select>
                    月
                    <div>
                        <label><input type="checkbox" name="vID[all]" value="1" class="all vID">全部</label>&emsp;
                        <?php 
                            foreach ($v_list as $each)
                            {
                                echo '<label><input type="checkbox" name="vID['.$each->id.']" value="1" class="vID">'.$each->name.'</label>&emsp;';
                            }
                        ?>
                    </div>
                    <div>
                        <button type="button" onclick="search()">查詢</button>
                        <button type="button" onclick="download()">下載服務時數條</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    $('.vID:not(.all)').on('change',function(){
        var all = true;
        $('.vID:not(.all)').each(function(){
            all = all && ($(this).prop('checked'));
            console.log($(this));
            console.log($(this).prop('checked'));
        });
        if(all)
            $('.vID.all').prop('checked',true);
        else
            $('.vID.all').prop('checked',false);            
    });
    $('.vID.all').on('click',function(){
            $('.vID:not(.all)').prop('checked',$(this).prop('checked'));
    });
    function search(){
        $('#post_form').attr('action','<?php echo base_url('/service_history/search') ?>');
        $('#post_form').submit();
    }

    function download(){
        $('#post_form').attr('action','<?php echo base_url('/service_history/download') ?>');
        $('#post_form').submit();
    }
</script>