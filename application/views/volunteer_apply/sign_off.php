
<style type="text/css">
#myCanvas {
    background: #EEE;
}
</style>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">簽名檔案管理</h3>
            </div>
            <?php if( $show_signature=='y' ) : ?>
                <div class="box-body">
                    目前存檔
                    <br>
                    <img id="img_signature" src="<?php echo $signature ?>" style="width:400px;border: 1px solid;">
                </div>
            <?php endif; ?>


            <div class="box-body">
                更新簽名：請在灰色筐內簽名
                <br>
                <canvas width="800" height="300" id="myCanvas"></canvas>

                <div style="padding: 20px 0px;">
                    <button id="save_signature" class="btn btn-primary">
                        確認更新簽名檔案
                    </button>
                    <button id="clear_signature" class="btn btn-default">
                        清除簽名
                    </button>

                </div>
            </div>

            

        </div>
    </div>
</div>

<script type="text/javascript">
var mousePressed = false;
var lastX, lastY;
var ctx;
 
function InitThis() {
    ctx = document.getElementById('myCanvas').getContext("2d");
 
    $('#myCanvas').mousedown(function (e) {
        mousePressed = true;
        Draw(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, false);
    });
 
    $('#myCanvas').mousemove(function (e) {
        if (mousePressed) {
            Draw(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, true);
        }
    });
 
    $('#myCanvas').mouseup(function (e) {
        mousePressed = false;
    });
        $('#myCanvas').mouseleave(function (e) {
        mousePressed = false;
    });
}
 
function Draw(x, y, isDown) {
    if (isDown) {
        ctx.beginPath();
        ctx.strokeStyle = $('#selColor').val();
        ctx.lineWidth = $('#selWidth').val();
        ctx.lineJoin = "round";
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(x, y);
        ctx.closePath();
        ctx.stroke();
    }
    lastX = x; lastY = y;
}

$('#clear_signature').on('click', function(event) {
    event.preventDefault();
    /* Act on the event */
    // Use the identity matrix while clearing the canvas
    ctx.setTransform(1, 0, 0, 1, 0, 0);
    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
});

$('#save_signature').on('click', function(event) {
    event.preventDefault();
    /* Act on the event */
    // Generate the image data
    var pic = document.getElementById("myCanvas").toDataURL("image/png");

    $.ajax({
        url: '<?php echo base_url();?>volunteer_apply/save_signature',
        type: 'POST',
        dataType: 'json',
        data: { signature : pic },
    })
    .done(function(msg) {
        if (msg.code=='100') {
            $('#img_signature').attr('src',pic) ;
            $('#clear_signature').click();
            alert('更新完成！') ;
        } else {
            alert('系統錯誤，請稍後再試！') ;
        }
    })
    .fail(function() {
        alert('系統錯誤，請稍後再試！') ;
    })
    .always(function() {
        console.log("complete");
    });


});

$(function() {
    InitThis() ;
});  
</script>


<style type="text/css">
.show-msg {
    padding: 20px 10px;
    border: 1px solid #eee;
    margin-bottom: 20px;
    position: relative;
    font-size: 16px;
}
.show-msg button {
    position: absolute;
    right: 13px;
    top: 13px;
}
</style>
<?php if( $show_msg=='y' ) : ?>
    
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">訊息通知</h3>
                </div>
                <div class="box-body">

                    <div class="show-msg">
                        2021/01/22 12:33 費用補助通知

                        <button id="save_sign_off" class="btn btn-primary">
                            確認
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    $('#save_sign_off').on('click', function(event) {
        event.preventDefault();
        /* Act on the event */
        $.ajax({
            url: '<?php echo base_url();?>volunteer_apply/save_sign_off',
            type: 'POST',
            dataType: 'json',
            data: {},
        })
        .done(function(msg) {
            $('#save_sign_off').remove() ;
        })
        .fail(function() {
            alert('系統錯誤，請稍後再試！') ;
        })
        .always(function() {
            console.log("complete");
        });
    });
    </script>
<?php endif; ?>




<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">簽核紀錄</h3>
            </div>
            <div class="box-body">

                <div class="show-msg">
                    2021/01/22 12:33 費用補助通知
                </div>
                <div class="show-msg">
                    2021/05/22 10:33 費用補助通知
                </div>

            </div>
        </div>
    </div>
</div>




