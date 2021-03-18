<?php
?>

<input id="x_input" type="hidden" name="x" value="-1" required>
<input id="y_input" type="hidden" name="y" value="-1" required>
<input id="map_width" type="hidden" name="map_width" value="0" required>
<input id="map_height" type="hidden" name="map_height" value="0" required>
<div style=" float: right; padding-right: 0; position: relative; width: 85%" id="mapWrapper">
    <img src="/static/img/exeter.jpg" id="map" style="float: right; width: 100%; z-index: 0; display: block;">
    <div id="pointer-wrapper" style="z-index: 1; position: absolute;" data-tooltip="" onclick="markerPress(this)" hidden>
        <img src="/static/img/marker_black.png" style="width: 30px;">
    </div>
</div>

<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<script>
    let clickingEnabled;
    $(document).ready(function () {
        let map = $("#map")
        $("#map_width").val(map.width());
        $("#map_height").val(map.height());

        map.click(function (ev) {
            if (clickingEnabled) {

                let offset = $(this).offset()
                let x = ev.clientX - offset.left;
                let y = ev.clientY - offset.top;
                $("#x_input").val(x);
                $("#y_input").val(y);


                // TODO: Make the point position responsive to changes in screen size
                let wrapper = $("#pointer-wrapper")
                // The -15, and -30, is to account for the size of the marker itself
                wrapper.css("left", `${Math.round(x - 15)}px`);
                wrapper.css("top", `${Math.round(y - 30)}px`);
                wrapper.show();
            } else {
                $("#marker-info").text("Click on the marker to see details about an infection.");
            }
        });
    });

    function addMarker(x_ratio, y_ratio, text="", red=false) {
        let wrapper = $("#pointer-wrapper").clone();
        wrapper.appendTo("#mapWrapper");
        wrapper.data("tooltip", text);

        if (red) {wrapper.find("img").attr('src',"/static/img/marker_red.png");}

        let map = $("#map")
        let x = x_ratio * map.width(); let y = y_ratio * map.height();

        wrapper.css("left", `${Math.round(x - 15)}px`);
        wrapper.css("top", `${Math.round(y - 30)}px`);
        wrapper.show();
    }

    function markerPress(pointerObj) {
        let pointer = $(pointerObj);
        let text = pointer.data("tooltip");
        $("#marker-info").text(text);
    }
</script>