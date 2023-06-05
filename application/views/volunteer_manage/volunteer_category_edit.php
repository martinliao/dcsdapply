      <!-- <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>volunteer_manage"><i class="fa fa-home"></i> Home</a></li>
        <li class="active"></li>
      </ol> -->
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
    <form action="<?php echo base_url();?>volunteer_manage/volunteer_category_edit" method="POST">
    	

    
   <div class="row">
      <div class="col-md-12">
         <div class="box">
            <div class="box-header with-border">
               <h3 class="box-title">編輯志工類別</h3>
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
                        <div class="col-md-12">
                          <label for="name">志工名稱</label>
                          <input type="text" class="form-control" name="name" value="<?php if(isset($detail[0]->name)){echo $detail[0]->name;}?>" />
                        </div>
                        <div class="col-md-12">
                          <label for="morning_start">上午班別時間(起)</label>
                          <input type="text" class="form-control" name="morning_start" value="<?php if(isset($detail[0]->name)){echo $detail[0]->morning_start;}?>" />
                        </div>
                        <div class="col-md-12">
                            <label for="morning_end">上午班別時間(迄)</label>
                            <input type="text" class="form-control" name="morning_end" value="<?php if(isset($detail[0]->name)){echo $detail[0]->morning_end;}?>" />
                         </div>
                         <div class="col-md-12">
                            <label for="afternoon_start">下午班別時間(起)</label>
                            <input type="text" class="form-control" name="afternoon_start" value="<?php if(isset($detail[0]->name)){echo $detail[0]->afternoon_start;}?>" />
                         </div>
                         <div class="col-md-12">
                            <label for="afternoon_end">下午班別時間(迄)</label>
                            <input type="text" class="form-control" name="afternoon_end" value="<?php if(isset($detail[0]->name)){echo $detail[0]->afternoon_end;}?>" />
                         </div>
                         <div class="col-md-12">
                            <label for="sign_month">每月可報班別</label>
                            <input type="text" class="form-control" name="sign_month" value="<?php if(isset($detail[0]->name)){echo $detail[0]->sign_month;}?>" />
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
                 <input type="hidden" name="id" value="<?php echo $id;?>" />
                 <button type="submit" class="btn btn-success btn-flat">確定儲存</button>
                 <button type="button" class="btn btn-default" onclick="history.go(-1);">取消</button>
              </div>
              </form>
           </div>
        </div>
      </div>
   </div>
</section>
