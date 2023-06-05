<div class="row">
<div class="col-xs-12">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">E.自評專區</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
    <p>填寫人：<?=htmlspecialchars($user_name,ENT_HTML5|ENT_QUOTES)?></p>
    <table id="example2" class="table table-bordered table-hover" style="text-align:center;vertical-align:middle">
        <thead>
          <tr>
            <th style="text-align:center;">年度</th>
            <th style="text-align:center;">上下半年</th>
            <th style="text-align:center;">志工類別</th>
            <th style="text-align:center;">填寫狀態</th>
           </tr> 
        </thead>
        <tbody>
            <?php for($i=0;$i<count($info);$i++){ ?>
              <?php if(count($info[$i]['list']) > 0){?>
                <tr>
                    <td style="vertical-align:middle"><?=htmlspecialchars($info[$i]['year'],ENT_HTML5|ENT_QUOTES).'年'?></td>
                    <td style="vertical-align:middle"><?=($info[$i]['helf']=='1')?'上半年':'下半年'?></td>
                    <td style="vertical-align:middle"><?=htmlspecialchars($info[$i]['list'][0]['name'],ENT_HTML5|ENT_QUOTES)?></td>
                    <?php if($info[$i]['list'][0]['status']=='1'){?>
                      <td style="vertical-align:middle">已完成</td>
                    <?php } else { ?>
                      <td style="vertical-align:middle"><a href="<?=htmlspecialchars($url,ENT_HTML5|ENT_QUOTES).'/'.htmlspecialchars($info[$i]['year'],ENT_HTML5|ENT_QUOTES).'/'.htmlspecialchars($info[$i]['helf'],ENT_HTML5|ENT_QUOTES).'/'.htmlspecialchars($info[$i]['category'],ENT_HTML5|ENT_QUOTES)?>">未完成 <button type='button' class='btn btn-success btn-flat'>開始填寫</button></a></td>
                    <?php } ?>
                </tr>
              <?php } ?>
            <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>