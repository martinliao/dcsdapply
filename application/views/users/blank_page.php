      <ol class="breadcrumb">
        <li><a href="http://elearning.taipei/eda/manage/course_manage"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">課程資訊</li>
      </ol>
    <!-- Content Header (Page header) -->
<section class="content-header">
  <!--  <h1>
      主席裁示分辦事項(Exam_check) 
      <small></small>
   </h1> -->
</section>
<!-- Main content -->
<section class="content">
    <?php 
        // echo form_open('c=exam_meeting&m=item_save', 'role="form" id="opendata-dataset-edit-form"');
        // echo form_hidden('id', $id);
    ?>   
    <form action="">
    	

    
   <div class="row">
      <div class="col-md-12">
         <div class="box">
            <div class="box-header with-border">
               <h3 class="box-title"><?php echo $course_info[0]->fullname; ?></h3>
               <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>         
               </div>
            </div>
          
            <div class="box-body">
               <div class="nav-tabs-custom">
                  <div class="">
                     <p class="page-header"></p>
                     <div class="form-group">
                         <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">檢驗教材管理狀態</label>
                               <input type="text" class="form-control" name="teaching_status" value="" readonly />
                            </div>
                            <div class="col-md-12">
                               <label for="codename">主類別</label>
                               <input type="text" class="form-control" name="first_type" value="<?php echo $course_info[0]->first; ?>" readonly />
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">副類別(第2層)</label>
                               <input type="text" class="form-control" name="second_type" value="<?php echo $course_info[0]->second; ?>" readonly />
                            </div>
                            <div class="col-md-12">
                               <label for="codename">次類別(第3層)</label>
                               <input type="text" class="form-control" name="third_type" value="<?php echo $course_info[0]->third; ?>" readonly />
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">講師</label>
                               <input type="text" class="form-control" name="teacher" value="<?php echo $course_info[0]->course_teacher; ?>" />
                            </div>
                            <div class="col-md-12">
                               <label for="codename">課程現況</label>
                               <select class="form-control" name="course_status_now">
                                 <option values="依需求上架">依需求上架</option>
                                 <option values="不開行動版">不開行動版</option>
                                 <option values="準備中">準備中</option>
                                 <option values="選取">選取</option>
                                 <option values="淘汰">淘汰</option>
                               </select>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">教材現況</label>
                               <input type="text" class="form-control" name="teaching_status" value="" readonly />
                            </div>
                            <div class="col-md-12">
                               <label for="codename">測驗卷</label>
                               <select class="form-control" name="quiz">
                                  <option values="N">N</option>
                                  <option values="Y">Y</option>
                               </select>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">課程ID</label>
                               <input type="text" class="form-control" name="cid" value="<?php echo $course_info[0]->id; ?>" readonly />
                            </div>
                            <div class="col-md-12">
                               <label for="codename">瀏覽器</label>
                               <input type="text" class="form-control" name="browser" value="" />
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">承辦人備註</label>
                               <input type="text" class="form-control" name="contractor_remark" value="" />
                            </div>
                            <div class="col-md-12">
                               <label for="codename">下線日期</label>
                               <input type="text" class="form-control" name="off_date" id="off_date" value="" />
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">課程首次上線日期</label>
                               <input type="text" class="form-control" name="on_date" id="on_date" value="" />
                            </div>
                            <div class="col-md-12">
                               <label for="codename">課程產出年度</label>
                               <input type="text" class="form-control" name="course_output_year" value="" />
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">教材製作年度</label>
                               <input type="text" class="form-control" name="teaching_materials_year" value="" />
                            </div>
                            <div class="col-md-12">
                               <label for="codename">課程長度(分)</label>
                               <input type="text" class="form-control" name="course_length" value="" />
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">認證時數</label>
                               <input type="text" class="form-control"  value="<?php echo $course_info[0]->certhour; ?>" readonly />
                            </div>
                            <div class="col-md-12">
                               <label for="codename">測驗分數</label>
                               <input type="text" class="form-control"  value="<?php echo $course_info[0]->gradepass; ?>" readonly />
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">重大優先政策</label>
                               <select class="form-control" name="priority_policy">
                                  <option values="N">N</option>
                                  <option values="Y">Y</option>
                               </select>
                            </div>
                            <div class="col-md-12">
                               <label for="codename">關鍵字</label>
                               <input type="text" class="form-control" name="keyword" value="<?php echo $course_info[0]->keyword; ?>" />
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">課程簡介</label>
                               <textarea class="form-control" name = "course_intro" rows="5" >
                               <?php echo $course_info[0]->course_introduce; ?>
                               </textarea>
                            </div>
                            <div class="col-md-12">
                               <label for="codename">課程目標</label>
                               <textarea class="form-control" name = "course_target" rows="5" >
                               <?php echo $course_info[0]->course_target; ?>
                               </textarea>
                            </div>
                         </div>

                         <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">課程大綱</label>
                               <textarea class="form-control" name = "course_outline" rows="5" >
                               <?php echo $course_info[0]->course_outline; ?>
                               </textarea>
                            </div>
                            <div class="col-md-12">
                               <label for="codename">其他注意事項</label>
                               <textarea class="form-control" name = "course_other" rows="5" >
                               <?php echo $course_info[0]->course_outher; ?>
                               </textarea>
                            </div>
                         </div>

                         <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">學習認證</label>
                               <textarea class="form-control" name = "course_info" rows="5" >
                               <?php echo $course_info[0]->course_info; ?>
                               </textarea>
                            </div>
                            <div class="col-md-12">
                               <label for="codename">終身學習課程類別代碼</label>
                               <input type="text" class="form-control" name="ecpa" value="<?php echo $course_info[0]->ecpa_typeid; ?>" />
                            </div>
                         </div>

                         <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">課程備註</label>
                               <textarea class="form-control" name = "course_remark" rows="5" >
                               <?php echo $course_info[0]->course_remark; ?>
                               </textarea>
                            </div>
                            <div class="col-md-12">
                               <label for="codename">教材數</label>
                               <input type="text" class="form-control" name="teaching_sum" value="" readonly/>
                            </div>
                         </div>

                         <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">教材編號1</label>
                               <input type="text" class="form-control" name="teaching_1" value="" />
                            </div>
                            <div class="col-md-12">
                               <label for="codename">教材編號3</label>
                               <input type="text" class="form-control" name="teaching_3" value="" />
                            </div>
                         </div>
                         
                         <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">教材編號2</label>
                               <input type="text" class="form-control" name="teaching_2" value="" />
                            </div>
                            <div class="col-md-12">
                               <label for="codename">教材編號4</label>
                               <input type="text" class="form-control" name="teaching_4" value="" />
                            </div>
                         </div>

                         <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">教材編號5</label>
                               <input type="text" class="form-control" name="teaching_5" value="" />
                            </div>
                            <div class="col-md-12">
                               <label for="codename">教材編號7</label>
                               <input type="text" class="form-control" name="teaching_7" value="" />
                            </div>
                         </div>

                         <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">教材編號6</label>
                               <input type="text" class="form-control" name="teaching_6" value="" />
                            </div>
                            <div class="col-md-12">
                               <label for="codename">教材編號8</label>
                               <input type="text" class="form-control" name="teaching_8" value="" />
                            </div>
                         </div>

                         <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">教材編號9</label>
                               <input type="text" class="form-control" name="teaching_9" value="" />
                            </div>
                            <div class="col-md-12">
                               <label for="codename">教材編號11</label>
                               <input type="text" class="form-control" name="teaching_11" value="" />
                            </div>
                         </div>

                         <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">教材編號10</label>
                               <input type="text" class="form-control" name="teaching_10" value="" />
                            </div>
                            <div class="col-md-12">
                               <label for="codename">教材編號12</label>
                               <input type="text" class="form-control" name="teaching_12" value="" />
                            </div>
                         </div>

                         <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">教材編號13</label>
                               <input type="text" class="form-control" name="teaching_13" value="" />
                            </div>
                            <div class="col-md-12">
                               <label for="codename">教材編號15</label>
                               <input type="text" class="form-control" name="teaching_15" value="" />
                            </div>
                         </div>

                         <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">教材編號14</label>
                               <input type="text" class="form-control" name="teaching_14" value="" />
                            </div>
                            <div class="col-md-12">
                               <label for="codename">教材編號16</label>
                               <input type="text" class="form-control" name="teaching_16" value="" />
                            </div>
                         </div>

                         <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">班期-名稱-104</label>
                               <input type="text" class="form-control" name="class_name" value="" />
                            </div>
                            <div class="col-md-12">
                               <label for="codename">是否訪客瀏覽</label>
                              <select class="form-control" name="guest_allow">
                                <option values="N">N</option>
                                <option values="Y">Y</option>
                              </select>
                            </div>
                         </div>

                         <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">是否有行動版</label>
                              <select class="form-control" name="mobile_allow">
                                <option values="N">N</option>
                                <option values="Y">Y</option>
                              </select>
                            </div>
                            <div class="col-md-12">
                               <label for="codename">全教網課程性質_代碼</label>
                               <input type="text" class="form-control" name="edu_courseid" value="" />
                            </div>
                         </div>

                         <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">全教課程類別代碼</label>
                               <input type="text" class="form-control" name="edu_typeid" value="<?php echo $course_info[0]->edu_typeid; ?>" />
                            </div>
                            <div class="col-md-12">
                               <label for="codename">全教課程類別細項代碼</label>
                               <input type="text" class="form-control" name="edu_detailtypeid" value="<?php echo $course_info[0]->edu_detailtypeid; ?>" />
                            </div>
                         </div>

                         <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">全教課程類別科目代碼</label>
                               <input type="text" class="form-control" name="edu_typesubid" value="<?php echo $course_info[0]->edu_typesubid; ?>" />
                            </div>
                            <div class="col-md-12">
                               <label for="codename">全教研習進修範疇細項</label>
                               <input type="text" class="form-control" name="edu_studydetailid" value="<?php echo $course_info[0]->edu_studydetailid; ?>" />
                            </div>
                         </div>

                         <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">環教課程方法代碼</label>
                               <input type="text" class="form-control" name="env_funid" value="<?php echo $course_info[0]->env_funid; ?>" />
                            </div>
                            <div class="col-md-12">
                               <label for="codename">人工檢核異常狀態</label>
                               <input type="text" class="form-control" name="artificial_check_error" value="" />
                            </div>
                         </div>

                         <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">環教課程類別代碼</label>
                               <input type="text" class="form-control" name="env_typeid" value="<?php echo $course_info[0]->env_typeid; ?>" />
                            </div>
                         </div>

                         <div class="col-md-6">
                            <div class="col-md-12">
                               <label for="codename">畸形教材編號</label>
                               <input type="text" class="form-control" name="deformity_teaching_id" value="" />
                            </div>
                         </div>
                     </div>
                  </div>
               </div>
               <!-- ./box-body -->
               <div class="box-footer">
               </div>
               <!-- /.box-footer -->
            </div>
            <!-- /.box -->
         </div>
         <!-- /.col -->
      </div>
      
      <div class="row">
        <div class="col-md-6">
           <div class="col-xs-12">
              <br>              
              <div class="form-group">
                 <button type="submit" class="btn btn-success btn-flat"  name="submit" value="accept">確定儲存</button>
                  <button type="button" class="btn btn-default" onclick="history.go(-1);">取消</button>
              </div>
              </form>
           </div>
        </div>
      </div>
   </div>
</section>

<script type="text/javascript">
$(function() 
{
   $('#off_date').datetimepicker({
        format:'YYYY-MM-DD'
   });

   $('#on_date').datetimepicker({
        format:'YYYY-MM-DD'
   });
});
</script>