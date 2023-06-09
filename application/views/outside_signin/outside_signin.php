<?php
$state = $page_name != 'edit' ? 'disabled' : '';
?>
<div class="row">
    <div class="col-md-5 col-md-offset-3">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">處外班刷到</h3>
            </div>
            <div class="box box-info">
                <div class="box-header with-border">
                </div>
                <!-- /.box-header -->
                <?php if ($this->session->flashdata('error_msg')) : ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php if (is_array($this->session->flashdata('error_msg'))) {
                            echo '<ul class="list-unstyled">';
                            foreach ($this->session->flashdata('error_msg') as $error_msg) {
                                echo '<li>' . $error_msg . '</li>';
                            }
                            echo '</ul>';
                        } else {
                            echo $this->session->flashdata('error_msg');
                        } ?>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('success_msg')) : ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $this->session->flashdata('success_msg'); ?>
                    </div>
                <?php endif; ?>
                <!-- form start -->
                <form class="form-horizontal" role="form" method="post" action="<?= $link_save; ?>">
                    <div class="box-body">
                        <?php if ($hasOutside) : ?>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">姓名</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?= set_value('name', $form['name']); ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="idno" class="col-sm-2 control-label">身份證字號</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="idno" name="idNo" placeholder="IDNO" value="<?= set_value('idNo', $form['idNo']); ?>">
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <?php if ($hasOutside) : ?>
                            <button type="submit" class="btn btn-primary">確定送出</button>
                            <button type="submit" class="btn btn-default">取消</button>
                        <?php else : ?>
                            <button type="submit" class="btn btn-default">本日無處外班</button>
                        <?php endif; ?>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box -->