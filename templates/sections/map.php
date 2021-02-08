<?php
?>

<input id="x_input" type="hidden" name="x" value="0">
<input id="y_input" type="hidden" name="y" value="0">
<div style=" float: right; padding-right: 0; position: relative; width: 85%">
    <img src="/static/img/exeter.jpg" id="map" style="float: right; width: 100%; z-index: 0; display: block;">
    <div id="pointer-wrapper" style="z-index: 1; position: absolute;" hidden>
        <img src="/static/img/marker_black.png" style="width: 30px;">
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#map").click(function (ev) {
            let offset = $(this).offset()
            let x = ev.clientX - offset.left;
            let y = ev.clientY - offset.top;
            $("#x_input").val(x); $("#y_input").val(y);

            let wrapper = $("#pointer-wrapper")
            wrapper.css("left", `${Math.round(x - 15)}px`);
            wrapper.css("top", `${Math.round(y - 30)}px`);
            wrapper.show();
        });
    })
</script>