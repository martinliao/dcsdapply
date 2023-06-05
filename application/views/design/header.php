<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>課程管理系統</title>
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
    
  </head>
  <body class="skin-red fixed">
    <div class="wrapper">
      
      <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">課程管理系統</a>
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
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li>
              <a href="<?php echo base_url('course_manage');?>">
                <i class="fa fa-dashboard"></i> <span>課程管理</span>
              </a>
            </li>
            
            <li>
              <a href="<?php echo base_url('teaching_manage');?>">
                <i class="fa fa-pagelines"></i> <span>教材管理</span>
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