<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> -->
    <title>志工園地</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link rel="stylesheet" href="<?php echo base_url();?>resource/adminlte/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url();?>resource/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url();?>resource/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>resource/adminlte/plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url();?>resource/artdialog/css/ui-dialog.css">
    <link rel="stylesheet" href="<?php echo base_url();?>resource/toastr/toastr.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>resource/adminlte/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>resource/bootstrap-switch/css/bootstrap3/bootstrap-switch.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>resource/adminlte/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>resource/adminlte/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>resource/fileinput/css/fileinput.css">
    <link rel="stylesheet" href="<?php echo base_url();?>resource/jquery.tagsinput/jquery.tagsinput.css">
    <link rel="stylesheet" href="<?php echo base_url();?>resource/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <!-- 用JQUERY UI 來執行 datepicker -->
    <link rel="stylesheet" href="<?php echo base_url();?>resource/jquery-ui-1.12.1.custom/jquery-ui.min.css">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    
    <!-- jQuery 2.1.3 -->
    <script type="text/javascript" src="<?php echo base_url();?>resource/adminlte/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>resource/adminlte/plugins/jQueryUI/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>resource/adminlte/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>resource/arttemplate/template-native.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>resource/artdialog/dialog-plus-min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>resource/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>resource/js/jquery.form.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>resource/js/bootbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>resource/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>resource/toastr/toastr.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>resource/adminlte/plugins/fastclick/fastclick.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>resource/autosize/autosize.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>resource/momentjs/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>resource/momentjs/locales.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url();?>resource/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url();?>resource/adminlte/plugins/select2/select2.full.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>resource/adminlte/plugins/fullcalendar/fullcalendar.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>resource/adminlte/plugins/fullcalendar/lang-all.js"></script>

    <script type="text/javascript" src="<?php echo base_url();?>resource/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>resource/adminlte/plugins/datatables/dataTables.bootstrap.min.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url();?>resource/adminlte/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>resource/adminlte/dist/js/app.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>resource/sammy/lib/min/sammy-latest.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>resource/js/server.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>resource/js/jquery.blockUI.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>resource/fileinput/js/fileinput.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>resource/adminlte/plugins/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>resource/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>resource/jquery.tagsinput/jquery.tagsinput.js"></script>

    <!-- 用JQUERY UI 來執行 datepicker -->
    <script type="text/javascript" src="<?php echo base_url();?>resource/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>resource/JQueryDatePickerTW-master/JQueryDatePickerTW.js" charset="BIG5"></script>

    
  </head>
  <body class="skin-red fixed">
    <div class="wrapper">
      
      <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo base_url();?>volunteer_manage" class="logo">志工園地</a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
         
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
      
      
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree">
            <!-- <li class="header">MAIN NAVIGATION</li> -->
            <li class="<?php echo $active=='volunteer_apply'?'active':null ?>">
              <a href="#">
                <span>A.志工報名</span>
              </a>
              <ul class="treeview-menu">
                <li>
                  <a href="<?php echo base_url('volunteer_apply');?>"><span style="margin-left: 10px">顯示全部</span></a>
                </li>
                <li>
                  <a href="<?php echo base_url('volunteer_apply/only_me/');?>"><span style="margin-left: 10px">個人報名狀況</span></a>
                </li>
                <li>
                  <a href="<?php echo base_url('volunteer_apply/download/');?>"><span style="margin-left: 10px">下載</span></a>
                </li>
                <li>
                  <a href="<?php echo base_url('volunteer_apply/download/1');?>"><span style="margin-left: 10px">下載個人班表</span></a>
                </li>
              </ul>
            </li>
            <li class="<?php echo $active=='service_history'?'active':null ?>">
              <a href="<?php echo base_url('service_history_new');?>">
                <span>B.服務時數查詢及<br>下載服務時數條</span>
              </a>
            </li>

            <?php if( isset($_SESSION['back_mID'] ) ) : ?>
              <li class="">
                <a href="javascript:alert('您現在使用的是模擬志工登入，無法使用此功能！')">
                  <span>C.語言自費進修班期專區</span>
                </a>
              </li>
            <?php else: ?>
              <li class="">
                <a href="http://elearning.taipei/elearn/fetpayment/apply_class.php" target="_blank">
                  <span>C.語言自費進修班期專區</span>
                </a>
              </li>
            <?php endif; ?>

            <li class="<?php echo $active=='sign_off'?'active':null ?>">
              <a href="<?php echo base_url('volunteer_apply/sign_off/');?>">
                <span>D.簽核專區</span>
              </a>
            </li>

            <li class="<?php echo $active=='self_evaluation'?'active':null ?>">
              <a href="<?php echo base_url('volunteer_apply/self_evaluation/');?>">
                <span>E.自評專區</span>
              </a>
            </li>
            <li class="<?php echo $active=='outside_signin'?'active':null ?>">
              <a href="<?php echo base_url('outside_signin');?>">
                <span>F.處外班刷到</span>
              </a>
            </li>

            <li class="<?php echo $active=='user_profile'?'active':null ?>">
              <a href="<?php echo base_url('user_profile');?>">
                <span>G.個人資料</span>
              </a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
       
        
        <!-- Main content -->
        <section class="content">
          <!-- Info boxes -->

            <?php if( isset($_SESSION['back_mID'] ) ) : ?>
              <p class="bg-warning" style="padding: 10px 20px;">
                您現在使用的是 <?php echo $_SESSION['userName']; ?> 的帳號
                <a href="<?php echo base_url('/manage/back_to_close');?>" class="btn btn-warning" style="margin-left: 20px;">
                  關閉
                </a>
              </p>
            <?php endif; ?>


