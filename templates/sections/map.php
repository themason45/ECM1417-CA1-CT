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

<script>
    let clickingEnabled;

    (() => {
        let map = document.querySelector("#map");
        document.querySelector("#map_width").setAttribute("value", map.offsetWidth);
        document.querySelector("#map_height").setAttribute("value", map.offsetHeight);

        map.addEventListener("click", function (ev) {
            if (clickingEnabled) {
                let offsets = calculateOffsets();
                let x = ev.clientX - offsets.left;
                let y = ev.clientY - offsets.top;

                document.querySelector("#x_input").setAttribute("value", x.toString());
                document.querySelector("#y_input").setAttribute("value", y.toString());

                let wrapper = document.querySelector("#pointer-wrapper");
                // The -15, and -30, is to account for the size of the marker itself
                wrapper.setAttribute("style",
                    `z-index: 1; position: absolute; left: ${Math.round(x - 15)}px; top: ${Math.round(y - 30)}px`)
                wrapper.removeAttribute("hidden");
            } else {
                document.querySelector("#marker-info").textContent =
                    "Click on the marker to see details about an infection.";
            }
        })
    })();

    function addMarker(x_ratio, y_ratio, text="", red=false) {
        let map = document.querySelector("#map");

        let wrapper = document.querySelector("#pointer-wrapper").cloneNode(true);
        map.parentElement.appendChild(wrapper);
        wrapper.dataset.tooltip = text;

        if (red) {wrapper.getElementsByTagName("img")[0].setAttribute('src',"/static/img/marker_red.png");}
        let mapRect = map.getBoundingClientRect();
        let x = x_ratio * mapRect.width; let y = y_ratio * mapRect.width;

        wrapper.setAttribute("style",
            `z-index: 1; position: absolute; left: ${Math.round(x - 15)}px; top: ${Math.round(y - 30)}px`)
        console.log(wrapper);
        wrapper.removeAttribute("hidden");
    }

    function markerPress(pointerObj) {
        document.querySelector("#marker-info").textContent = pointerObj.dataset.tooltip;
    }

    function calculateOffsets() {
        let bodyRect = document.body.getBoundingClientRect(), mapRect = map.getBoundingClientRect();
        let offsetLeft = mapRect.left - bodyRect.left, offsetTop = mapRect.top - bodyRect.top;
        return {left: offsetLeft, top: offsetTop};
    }
</script>