<?php
    $state = $page_name != 'edit' ? 'disabled' : '';
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">個人資料</h3>
            </div>
            <?php if (validation_errors()) { ?>
                <div class="alert alert-danger">
                    <button class="close" data-dismiss="alert" type="button">×</button>
                    <?= validation_errors(); ?>
                </div>
            <?php } ?>
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <!-- <h3 class="box-title">個人資料</h3> -->
                    <?php if ($page_name == 'edit') { ?>
                        <h3 style="color: red">目前為修改模式</h3>
                    <?php } ?>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" role="form" method="post" action="<?=$link_save;?>">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">姓名</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?= set_value('name', $form['name']); ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="idno" class="col-sm-2 control-label">身份證字號</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="idno" name="idNo" placeholder="IDNO" value="<?= set_value('idNo', $form['idNo']); ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="telphone" class="col-sm-2 control-label">電話</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="telphone" name="telphone" placeholder="Telphone" value="<?= set_value('telphone', $form['telphone']); ?>" <?=$state?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">電子信箱</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="email" name="email" placeholder="eMail" value="<?= set_value('email', $form['email']); ?>" <?=$state?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-2 control-label">戶籍地址</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?= set_value('$address', $form['address']); ?>" <?=$state?>>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <?php if ($page_name == 'edit') { ?>
                            <button type="submit" class="btn btn-primary">確認</button>
                            <button type="submit" class="btn btn-default">取消</button>
                        <?php } else { ?>
                            <button type="submit" class="btn btn-primary">編修</button>
                        <?php } ?>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box -->