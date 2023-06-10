<style type="text/css">
    #canvas {}
    
    #canvasDiv {
        background-color:gray;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
    }

    body{
        /*font-family: DFKai-sb;*/
        font-size: 18px;
    }
</style>


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

            更新簽名：請在灰色筐內簽名
            <br>
            <div id="canvasDiv" ></div>

            <div style="padding: 20px 0px;">
                <button id="btn_submit" class="btn btn-primary">
                    確認更新簽名檔案
                </button>
                <button id="btn_clear" class="btn btn-default">
                    清除簽名
                </button>

            </div>


<script language="javascript">
    $('#canvasDiv').on('touchmove', function (event) {
        event.preventDefault();
    });
    var canvasDiv = document.getElementById('canvasDiv');
    var canvas = document.createElement('canvas');
    var screenwidth = (window.innerWidth > 0) ? window.innerWidth : screen.width;

    var canvasWidth = screenwidth;
    var canvasHeight = 300;
    document.addEventListener('touchmove', onDocumentTouchMove, false);
    var point = {};
    point.notFirst = false;
    canvas.setAttribute('width', canvasWidth);
    canvas.setAttribute('height', canvasHeight);
    canvas.setAttribute('id', 'canvas');
    canvasDiv.appendChild(canvas);
    if (typeof G_vmlCanvasManager != 'undefined') {
        canvas = G_vmlCanvasManager.initElement(canvas);
    }
    var context = canvas.getContext("2d");
    var img = new Image();
    img.src = "Transparent.png";

    img.onload = function() {
        var ptrn = context.createPattern(img, 'repeat');
        context.fillStyle = ptrn;
        context.fillRect(0, 0, canvas.width, canvas.height);
        //context.strokeStyle="#0000FF";
    }
    canvas.addEventListener("touchstart", function(e) {
        //console.log(e);
        var mouseX = e.touches[0].pageX - this.offsetLeft;
        var mouseY = e.touches[0].pageY - this.offsetTop;
        paint = true;
        addClick(e.touches[0].pageX - this.offsetLeft, e.touches[0].pageY - this.offsetTop);
        //console.log(e.touches[0].pageX - this.offsetLeft, e.touches[0].pageY - this.offsetTop);
        redraw();
    });

    canvas.addEventListener("touchend", function(e) {
        //console.log("touch end");
        paint = false;
    });

    canvas.addEventListener("touchmove", function(e) {
        if (paint) {
            //console.log("touchmove");
            addClick(e.touches[0].pageX - this.offsetLeft, e.touches[0].pageY - this.offsetTop, true);
            //console.log(e.touches[0].pageX - this.offsetLeft, e.touches[0].pageY - this.offsetTop);
            redraw();
        }

    });

    canvas.addEventListener("mousedown", function(e) {
        var mouseX = e.pageX - this.offsetLeft;
        var mouseY = e.pageY - this.offsetTop;
        paint = true;
        addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop);
        redraw();
    });
    canvas.addEventListener("mousemove", function(e) {
        if (paint) {
            addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop, true);
            redraw();
        }
    });
    canvas.addEventListener("mouseup", function(e) {
        paint = false;
    });
    canvas.addEventListener("mouseleave", function(e) {
        paint = false;
    });
    document.getElementById("btn_clear").addEventListener("click", function() {
        canvas.width = canvas.width;
    });

    $('#btn_submit').on('click', function(event) {
        event.preventDefault();
        /* Act on the event */
        // Generate the image data
        var pic = canvas.toDataURL("image/png");

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

    function onDocumentTouchStart(event) {
        if (event.touches.length == 1) {
            event.preventDefault();
            // Faking double click for touch devices
            var now = new Date().getTime();
            if (now - timeOfLastTouch < 250) {
                reset();
                return;
            }
            timeOfLastTouch = now;
            mouseX = event.touches[0].pageX;
            mouseY = event.touches[0].pageY;
            isMouseDown = true;

        }

    }

    function onDocumentTouchMove(event) {

        if (event.touches.length == 1) {
            
            mouseX = event.touches[0].pageX;
            mouseY = event.touches[0].pageY;
        }
    }

    function onDocumentTouchEnd(event) {
        if (event.touches.length == 0) {
            event.preventDefault();
            isMouseDown = false;
        }
    }

    var clickX = new Array();
    var clickY = new Array();
    var clickDrag = new Array();
    var paint;

    function addClick(x, y, dragging) {
        clickX.push(x);
        clickY.push(y);
        clickDrag.push(dragging);
    }

    function redraw() {

        //canvas.width = canvas.width; // Clears the canvas
        //context.strokeStyle = "#df4b26";
        context.strokeStyle = "#0000ff";
        context.lineJoin = "round";
        context.lineWidth = 2;
        while (clickX.length > 0) {
            point.bx = point.x;
            point.by = point.y;
            point.x = clickX.pop();
            point.y = clickY.pop();
            point.drag = clickDrag.pop();
            context.beginPath();
            if (point.drag && point.notFirst) {
                context.moveTo(point.bx, point.by);
            } else {
                point.notFirst = true;
                context.moveTo(point.x - 1, point.y);
            }
            context.lineTo(point.x, point.y);
            context.closePath();
            context.stroke();
        }
    }

    function isCanvasBlank(canvas) {
        return !canvas.getContext('2d')
        .getImageData(0, 0, canvas.width, canvas.height).data
        .some(channel => channel !== 0);
    }

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