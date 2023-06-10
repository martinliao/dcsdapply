<div class="row">
<div class="col-xs-12">
  <div class="box" style="overflow-x: auto;">
    <div class="box-header">
      <h3 style="text-align:center">臺北市政府公務人員訓練處<?=htmlspecialchars($category_name,ENT_HTML5|ENT_QUOTES)?>志工服務績效平時考核表</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <form id="sendform" method="post" action="<?=htmlspecialchars($action,ENT_HTML5|ENT_QUOTES)?>">
       
        <?php if($category == 1) { ?>
        <table id="example2" class="table table-bordered table-hover" style="text-align:center;vertical-align:middle">
            <thead>
                <tr>
                    <th colspan="4" style="text-align:left;">考核期間：<?=htmlspecialchars($date_range,ENT_HTML5|ENT_QUOTES)?></th>
                </tr> 
            </thead>
            <tbody>
                <tr>
                    <td colspan="3" style="text-align:left;width:65%">姓名：<?=htmlspecialchars($user_name,ENT_HTML5|ENT_QUOTES)?></td>
                    <td colspan="1" style="text-align:left;width:35%">實際出勤時數：<?=htmlspecialchars($total_hours,ENT_HTML5|ENT_QUOTES)?>小時</td>
                </tr>
                <tr >
                    <td rowspan="2" style="vertical-align:middle;width:5%">項次</td>
                    <td rowspan="2" style="vertical-align:middle;width:15%">考核項目</td>
                    <td rowspan="2" style="vertical-align:middle;width:45%">考核內容</td>
                    <td style="vertical-align:middle;width:35%"><?=htmlspecialchars($category_name,ENT_HTML5|ENT_QUOTES)?>志工 自評<br>20%</td>
                </tr>
                <tr>
                    <td style="vertical-align:middle;width:35%">(左列每考核項目滿分以10分計算)<br>配分及加權請參閱背面填表說明</td>
                </tr>
                <tr>
                    <td rowspan="7" style="vertical-align:middle;width:5%">1</td>
                    <td rowspan="7" style="vertical-align:middle;width:15%">工作表現70%</td>
                    <td style="text-align:left;width:45%">1. 協助學員刷到退、請假相關事項並督促學員準時上、下課，午休時間確實協助引導學員及講座用餐。(10分)</td>
                    <td rowspan="7" style="vertical-align:middle;width:35%">滿分70<br><br><input id="top_grade" name="top_grade" oninput="totalTopFun(this)" value="<?=isset($grades[0]['top_grade'])?htmlspecialchars($grades[0]['top_grade'],ENT_HTML5|ENT_QUOTES):''?>">分</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">2. 協助接待授課講座、教具準備、講義發放及教學設備安裝等事宜。(10分)</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">3. 帶班期間全程出勤，及時支援隨班參與實地教學及參訪等活動(詳填表說明4)。(10分)</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">4. 工作積極主動、掌握時效，並與講座、訓練機關同仁及學員互動良好。(10分)</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">5. 上課中除要務外，未使用手機電腦等相關電子產品處理私務。(10分)</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">6. 主動關懷表現特殊學員並蒐集相關資料。提出創新觀念，發掘並反應隱藏問題。(10分)</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">7. 課堂臨時緊急狀況確實通報與支援。面對學員問題理性周詳分析，並尋求解決方法。(10分)</td>
                </tr>
                <tr>
                    <td rowspan="3" style="vertical-align:middle;width:5%">2</td>
                    <td rowspan="3" style="vertical-align:middle;width:15%">服務態度30%</td>
                    <td style="text-align:left;width:45%">8. 服務勤奮認真、充滿工作熱情且具有團隊精神。(10分)</td>
                    <td rowspan="3" style="vertical-align:middle;width:35%">滿分30<br><br><input id="bottom_grade" name="bottom_grade" oninput="totalBottomFun(this)" value="<?=isset($grades[0]['bottom_grade'])?htmlspecialchars($grades[0]['bottom_grade'],ENT_HTML5|ENT_QUOTES):''?>">分</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">9. 輔導員主動溝通且配合度良好，樂於接受建議並主動虛心檢討。(10分)</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">10. 恪遵訓練機關服務規範並嚴守服務機密。(10分)</td>
                </tr>
                <tr>
                    <td style="vertical-align:middle;width:5%">3</td>
                    <td style="vertical-align:middle;width:15%">開放性意見</td>
                    <td colspan=1><textarea class="form-control" name="selfcomment" v-model="text" rows="6" placeholder="字數限制100字">
<?=isset($grades[0]['selfcomment'])?htmlspecialchars($grades[0]['selfcomment'],ENT_HTML5|ENT_QUOTES):''?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:left;width:65%">
                    <?=htmlspecialchars($category_name,ENT_HTML5|ENT_QUOTES)?>志工簽名：
                    <?php if( $show_signature=='y' ) : ?>
                        <img id="img_signature" src="<?php echo $signature ?>" style="width:400px;">
                    <?php endif; ?>
                    </td>
                    <td colspan="1" style="text-align:center;width:35%" id="total">
                        總分：
                        <?php 
                            if(isset($grades[0]['top_grade']) && isset($grades[0]['bottom_grade'])){
                                $total = $grades[0]['top_grade'] + $grades[0]['bottom_grade'];
                            } else if(isset($grades[0]['top_grade'])){
                                $total = $grades[0]['top_grade'];
                            } else if(isset($grades[0]['bottom_grade'])){
                                $total = $grades[0]['bottom_grade'];
                            } else {
                                $total = 0;
                            }

                            echo htmlspecialchars($total,ENT_HTML5|ENT_QUOTES).'分';
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php } else if($category == 2) {?>
        <table id="example2" class="table table-bordered table-hover" style="text-align:center;vertical-align:middle">
            <thead>
                <tr>
                    <th colspan="4" style="text-align:left;">考核期間：<?=htmlspecialchars($date_range,ENT_HTML5|ENT_QUOTES)?></th>
                </tr> 
            </thead>
            <tbody>
                <tr>
                    <td colspan="3" style="text-align:left;width:65%">姓名：<?=htmlspecialchars($user_name,ENT_HTML5|ENT_QUOTES)?></td>
                    <td colspan="1" style="text-align:left;width:35%">實際出勤時數：<?=htmlspecialchars($total_hours,ENT_HTML5|ENT_QUOTES)?>小時</td>
                </tr>
                <tr >
                    <td rowspan="2" style="vertical-align:middle;width:5%">項次</td>
                    <td rowspan="2" style="vertical-align:middle;width:15%">考核項目</td>
                    <td rowspan="2" style="vertical-align:middle;width:45%">考核內容</td>
                    <td style="vertical-align:middle;width:35%"><?=htmlspecialchars($category_name,ENT_HTML5|ENT_QUOTES)?>志工 自評<br>20%</td>
                </tr>
                <tr>
                    <td style="vertical-align:middle;width:35%">(左列每考核項目滿分以10分計算)<br>配分及加權請參閱背面填表說明</td>
                </tr>
                <tr>
                    <td rowspan="5" style="vertical-align:middle;width:5%">1</td>
                    <td rowspan="5" style="vertical-align:middle;width:15%">工作表現50%</td>
                    <td style="text-align:left;width:45%">1. 協助處理全處辨證勤務、園區位置引導、交管及通報相關人員。(10分)</td>
                    <td rowspan="5" style="vertical-align:middle;width:35%">滿分50<br><br><input id="top_grade" name="top_grade" oninput="totalTopFun(this)" value="<?=isset($grades[0]['top_grade'])?htmlspecialchars($grades[0]['top_grade'],ENT_HTML5|ENT_QUOTES):''?>">分</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">2. 協助處理相關表報登記EX:「來賓、洽公、施工人員進出登記簿」、「假日暨晚間進出登記簿」、「圖書館進出登記簿」。(10分)</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">3. 協助接聽電話及現場服務之禮儀。(10分)</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">4. 除要務外，未使用手機電腦等相關電子產品處理私務。(10分)</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">5. 臨時緊急狀況之通報與支援。(10分)</td>
                </tr>
                <tr>
                    <td rowspan="5" style="vertical-align:middle;width:5%">2</td>
                    <td rowspan="5" style="vertical-align:middle;width:15%">服務態度50%</td>
                    <td style="text-align:left;width:45%">6. 充滿工作熱情。(10分)</td>
                    <td rowspan="5" style="vertical-align:middle;width:35%">滿分50<br><br><input id="bottom_grade" name="bottom_grade" oninput="totalBottomFun(this)" value="<?=isset($grades[0]['bottom_grade'])?htmlspecialchars($grades[0]['bottom_grade'],ENT_HTML5|ENT_QUOTES):''?>">分</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">7. 具有團隊精神、與駐警室人員主動溝通且配合度良好。(10分)</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">8. 樂於接受建議並主動虛心檢討。(10分)</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">9. 恪遵訓練機關服務規範。(10分)</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">10. 嚴守服務機密。(10分)</td>
                </tr>
                <tr>
                    <td style="vertical-align:middle;width:5%">3</td>
                    <td style="vertical-align:middle;width:15%">開放性意見</td>
                    <td colspan=1><textarea class="form-control" name="selfcomment" v-model="text" rows="6" placeholder="字數限制100字">
<?=isset($grades[0]['selfcomment'])?htmlspecialchars($grades[0]['selfcomment'],ENT_HTML5|ENT_QUOTES):''?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:left;width:65%">
                    <?=htmlspecialchars($category_name,ENT_HTML5|ENT_QUOTES)?>志工簽名：
                    <?php if( $show_signature=='y' ) : ?>
                        <img id="img_signature" src="<?php echo $signature ?>" style="width:400px;">
                    <?php endif; ?>
                    </td>
                    <td colspan="1" style="text-align:center;width:35%" id="total">
                        總分：
                        <?php 
                            if(isset($grades[0]['top_grade']) && isset($grades[0]['bottom_grade'])){
                                $total = $grades[0]['top_grade'] + $grades[0]['bottom_grade'];
                            } else if(isset($grades[0]['top_grade'])){
                                $total = $grades[0]['top_grade'];
                            } else if(isset($grades[0]['bottom_grade'])){
                                $total = $grades[0]['bottom_grade'];
                            } else {
                                $total = 0;
                            }

                            echo htmlspecialchars($total,ENT_HTML5|ENT_QUOTES).'分';
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php } else if($category == 3) {?>
            <table id="example2" class="table table-bordered table-hover" style="text-align:center;vertical-align:middle">
            <thead>
                <tr>
                    <th colspan="4" style="text-align:left;">考核期間：<?=htmlspecialchars($date_range,ENT_HTML5|ENT_QUOTES)?></th>
                </tr> 
            </thead>
            <tbody>
                <tr>
                    <td colspan="3" style="text-align:left;width:65%">姓名：<?=htmlspecialchars($user_name,ENT_HTML5|ENT_QUOTES)?></td>
                    <td colspan="1" style="text-align:left;width:35%">實際出勤時數：<?=htmlspecialchars($total_hours,ENT_HTML5|ENT_QUOTES)?>小時</td>
                </tr>
                <tr >
                    <td rowspan="2" style="vertical-align:middle;width:5%">項次</td>
                    <td rowspan="2" style="vertical-align:middle;width:15%">考核項目</td>
                    <td rowspan="2" style="vertical-align:middle;width:45%">考核內容</td>
                    <td style="vertical-align:middle;width:35%"><?=htmlspecialchars($category_name,ENT_HTML5|ENT_QUOTES)?>志工 自評<br>20%</td>
                </tr>
                <tr>
                    <td style="vertical-align:middle;width:35%">(左列每考核項目滿分以10分計算)<br>配分及加權請參閱背面填表說明</td>
                </tr>
                <tr>
                    <td rowspan="7" style="vertical-align:middle;width:5%">1</td>
                    <td rowspan="7" style="vertical-align:middle;width:15%">工作表現70%</td>
                    <td style="text-align:left;width:45%">1. 協助館員執行館務相關工作。(10分)</td>
                    <td rowspan="7" style="vertical-align:middle;width:35%">滿分70<br><br><input id="top_grade" name="top_grade" oninput="totalTopFun(this)" value="<?=isset($grades[0]['top_grade'])?htmlspecialchars($grades[0]['top_grade'],ENT_HTML5|ENT_QUOTES):''?>">分</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">2. 協助整理館藏圖書。(10分)</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">3. 協助接聽電話。(10分)</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">4. 協助館員回應讀者諮詢。(10分)</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">5. 工作積極主動、掌握時效。(10分)</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">6. 與館員及讀者互動良好。(10分)</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">7. 臨時緊急狀況之通報與支援。(10分)</td>
                </tr>
                <tr>
                    <td rowspan="3" style="vertical-align:middle;width:5%">2</td>
                    <td rowspan="3" style="vertical-align:middle;width:15%">服務態度30%</td>
                    <td style="text-align:left;width:45%">8. 充滿工作熱情。(10分)</td>
                    <td rowspan="3" style="vertical-align:middle;width:35%">滿分30<br><br><input id="bottom_grade" name="bottom_grade" oninput="totalBottomFun(this)" value="<?=isset($grades[0]['bottom_grade'])?htmlspecialchars($grades[0]['bottom_grade'],ENT_HTML5|ENT_QUOTES):''?>">分</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">9. 具有團隊精神。(10分)</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">10. 嚴守服務機密。(10分)</td>
                </tr>
                <tr>
                    <td style="vertical-align:middle;width:5%">3</td>
                    <td style="vertical-align:middle;width:15%">開放性意見</td>
                    <td colspan=1><textarea class="form-control" name="selfcomment" v-model="text" rows="6" placeholder="字數限制100字">
<?=isset($grades[0]['selfcomment'])?htmlspecialchars($grades[0]['selfcomment'],ENT_HTML5|ENT_QUOTES):''?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:left;width:65%">
                    <?=htmlspecialchars($category_name,ENT_HTML5|ENT_QUOTES)?>志工簽名：
                    <?php if( $show_signature=='y' ) : ?>
                        <img id="img_signature" src="<?php echo $signature ?>" style="width:400px;">
                    <?php endif; ?>
                    </td>
                    <td colspan="1" style="text-align:center;width:35%" id="total">
                        總分：
                        <?php 
                            if(isset($grades[0]['top_grade']) && isset($grades[0]['bottom_grade'])){
                                $total = $grades[0]['top_grade'] + $grades[0]['bottom_grade'];
                            } else if(isset($grades[0]['top_grade'])){
                                $total = $grades[0]['top_grade'];
                            } else if(isset($grades[0]['bottom_grade'])){
                                $total = $grades[0]['bottom_grade'];
                            } else {
                                $total = 0;
                            }

                            echo htmlspecialchars($total,ENT_HTML5|ENT_QUOTES).'分';
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php } else if($category == 4) {?>
        <table id="example2" class="table table-bordered table-hover" style="text-align:center;vertical-align:middle">
            <thead>
                <tr>
                    <th colspan="4" style="text-align:left;">考核期間：<?=htmlspecialchars($date_range,ENT_HTML5|ENT_QUOTES)?></th>
                </tr> 
            </thead>
            <tbody>
                <tr>
                    <td colspan="3" style="text-align:left;width:65%">姓名：<?=htmlspecialchars($user_name,ENT_HTML5|ENT_QUOTES)?></td>
                    <td colspan="1" style="text-align:left;width:35%">實際出勤時數：<?=htmlspecialchars($total_hours,ENT_HTML5|ENT_QUOTES)?>小時</td>
                </tr>
                <tr >
                    <td rowspan="2" style="vertical-align:middle;width:5%">項次</td>
                    <td rowspan="2" style="vertical-align:middle;width:15%">考核項目</td>
                    <td rowspan="2" style="vertical-align:middle;width:45%">考核內容</td>
                    <td style="vertical-align:middle;width:35%"><?=htmlspecialchars($category_name,ENT_HTML5|ENT_QUOTES)?>志工 自評<br>20%</td>
                </tr>
                <tr>
                    <td style="vertical-align:middle;width:35%">(左列每考核項目滿分以10分計算)<br>配分及加權請參閱背面填表說明</td>
                </tr>
                <tr>
                    <td rowspan="5" style="vertical-align:middle;width:5%">1</td>
                    <td rowspan="5" style="vertical-align:middle;width:15%">工作表現50%</td>
                    <td style="text-align:left;width:45%">1. 客服電話接聽及現場服務之禮儀。(10分)</td>
                    <td rowspan="5" style="vertical-align:middle;width:35%">滿分50<br><br><input id="top_grade" name="top_grade" oninput="totalTopFun(this)" value="<?=isset($grades[0]['top_grade'])?htmlspecialchars($grades[0]['top_grade'],ENT_HTML5|ENT_QUOTES):''?>">分</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">2. 客服電話諮詢服務接聽及現場服務之積極度。(10分)</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">3. 客服電話諮詢服務內容之準確度。(10分)</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">4. 按時及確實填報服務紀錄及臺北e大數位課程檢核表。(10分)</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">5. 值勤期間全程出勤。(10分)</td>
                </tr>
                <tr>
                    <td rowspan="5" style="vertical-align:middle;width:5%">2</td>
                    <td rowspan="5" style="vertical-align:middle;width:15%">服務態度50%</td>
                    <td style="text-align:left;width:45%">6. 充滿工作熱情。(10分)</td>
                    <td rowspan="5" style="vertical-align:middle;width:35%">滿分50<br><br><input id="bottom_grade" name="bottom_grade" oninput="totalBottomFun(this)" value="<?=isset($grades[0]['bottom_grade'])?htmlspecialchars($grades[0]['bottom_grade'],ENT_HTML5|ENT_QUOTES):''?>">分</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">7. 具有團隊精神、主動溝通且配合度良好。(10分)</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">8. 樂於接受建議並主動虛心檢討。(10分)</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">9. 恪遵訓練機關服務規範。(10分)</td>
                </tr>
                <tr>
                    <td style="text-align:left;width:45%">10. 嚴守服務機密。(10分)</td>
                </tr>
                <tr>
                    <td style="vertical-align:middle;width:5%">3</td>
                    <td style="vertical-align:middle;width:15%">開放性意見</td>
                    <td colspan=1><textarea class="form-control" name="selfcomment" v-model="text" rows="6" placeholder="字數限制100字">
<?=isset($grades[0]['selfcomment'])?htmlspecialchars($grades[0]['selfcomment'],ENT_HTML5|ENT_QUOTES):''?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:left;width:65%">
                    <?=htmlspecialchars($category_name,ENT_HTML5|ENT_QUOTES)?>志工簽名：
                    <?php if( $show_signature=='y' ) : ?>
                        <img id="img_signature" src="<?php echo $signature ?>" style="width:400px;">
                    <?php endif; ?>
                    </td>
                    <td colspan="1" style="text-align:center;width:35%" id="total">
                        總分：
                        <?php 
                            if(isset($grades[0]['top_grade']) && isset($grades[0]['bottom_grade'])){
                                $total = $grades[0]['top_grade'] + $grades[0]['bottom_grade'];
                            } else if(isset($grades[0]['top_grade'])){
                                $total = $grades[0]['top_grade'];
                            } else if(isset($grades[0]['bottom_grade'])){
                                $total = $grades[0]['bottom_grade'];
                            } else {
                                $total = 0;
                            }

                            echo htmlspecialchars($total,ENT_HTML5|ENT_QUOTES).'分';
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php } ?>
        <input type="hidden" id="year" name="year" value="<?=htmlspecialchars($year,ENT_HTML5|ENT_QUOTES)?>">
        <input type="hidden" id="helf" name="helf" value="<?=htmlspecialchars($helf,ENT_HTML5|ENT_QUOTES)?>">
        <input type="hidden" id="category" name="category" value="<?=htmlspecialchars($category,ENT_HTML5|ENT_QUOTES)?>">
        <input type="hidden" id="mode" name="mode" value="">
        </form>
        <br>
        <div style="margin-left: 2%;">
            <button type='button' class='btn btn-success btn-flat' style="float:right;margin-left:5px" onclick="sendNewFun(1)">送出</button>
            <button type='button' class='btn btn-success btn-flat' style="float:right;margin-left:5px" onclick="sendNewFun(0)">暫存</button>
            <font style="font-weight:bold">填表說明：</font><br>
            <p>1. 配分說明：</p>
            <img src=<?=htmlspecialchars($img_url,ENT_HTML5|ENT_QUOTES)?>>
            <p>2. 考核方式包括<?=htmlspecialchars($category_name,ENT_HTML5|ENT_QUOTES)?>志工自我考評、承辦人考核及單位主管考核，分別占20%、40%及40%，分數採各自四捨五入後加總計算。</p>
            <p>3. 考核項目包括「工作表現」及「服務態度」。</p>
            <!-- <p>4. 無服務戶外班期該類班教學參訪者，該考核項目滿分請填8分。</p> -->
            <p>4. 考核總分90分(含)以上，列「特優」；80分至不滿90分，列「優等」；70分至不滿80分，列「適任」；60分至不滿70分，列「待觀察」；不滿60分，列「不適任」。考核為適任(含)以上者，繼續派用；待觀察者，當年度暫停派用；不適任者，不再派用。</p>
        </div>
    </div>
  </div>
</div>
</div>

<script>
    function sendNewFun(mode){
        var obj = document.getElementById('sendform');
        var top_grade = document.getElementById('top_grade').value;
        var bottom_grade = document.getElementById('bottom_grade').value;
        var category = document.getElementById('category').value;
        document.getElementById('mode').value = mode;
        if(top_grade.trim() == '' || bottom_grade.trim() == ''){
            alert('自評分數不能為空');
            return false;
        } else {
            if(category == 1 || category == 3){
                if(top_grade > 70){
                    alert('滿分為70分');
                    return false;
                }

                if(bottom_grade > 30){
                    alert('滿分為30分');
                    return false;
                }
            } else if(category == 2 || category == 4){
                if(top_grade > 50){
                    alert('滿分為50分');
                    return false;
                }

                if(bottom_grade > 50){
                    alert('滿分為50分');
                    return false;
                }
            }


            obj.submit();
        }
    }

    function totalTopFun(obj){
        var total = 0;
        var bottom_grade = document.getElementById('bottom_grade').value;

        if(obj.value != ''){
            total += parseInt(obj.value,10);
        }

        if(bottom_grade != ''){
            total += parseInt(bottom_grade,10);
        }

        document.getElementById('total').innerText = '總分：'+total.toString()+'分';
    }

    function totalBottomFun(obj){
        var total = 0;
        var top_grade = document.getElementById('top_grade').value;

        if(obj.value != ''){
            total += parseInt(obj.value,10);
        }

        if(top_grade != ''){
            total += parseInt(top_grade,10);
        }

        document.getElementById('total').innerText = '總分：'+total.toString()+'分';
    }
</script>