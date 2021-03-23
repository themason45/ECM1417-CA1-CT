<?php
if (isset($_POST['datetime'], $_POST['duration'], $_POST["x"], $_POST["y"])) {
    include_once "support/Location.php";
    include_once "support/User.php";

    if ($_POST["x"] == -1 && $_POST["y"] == -1) {
        echo "Please select a location.";
    } elseif ($_POST["duration"] == 0) {echo "Please choose a duration above 0.";} else {

        $location = new Location();
        $location->x = $_POST["x"];
        $location->y = $_POST["y"];

        $location->x_ratio = $_POST["x"] / $_POST["map_width"];
        $location->y_ratio = $_POST["y"] / $_POST["map_height"];

        $location->user = User::getUserById($_SESSION["user_pk"]);
        echo $_POST["datetime"];
        $location->timeVisited = date_create_from_format("Y-m-d?H:i", $_POST["datetime"]);
        $location->duration = $_POST["duration"];

        $location->save();
        Header("Location: /overview");
    }
}
?>
<div style="margin-top: 20px">
    <div class="watermark">
        <img src="/static/img/watermark.png" alt="watermark" style="margin-left: 15%">
    </div>
    <div class="content">
        <!--suppress HtmlDeprecatedAttribute, HtmlUnknownTarget -->
        <form action="/add_visit" method="post">
            <!--suppress HtmlDeprecatedAttribute -->
            <table style="table-layout: fixed;width: 100%; padding-left: 50px; padding-right: 50px" cellpadding="0"
                   cellspacing="0">
                <tr>
                    <td colspan="3" style="border-bottom: black solid 2pt"><h2 style="text-align: center">Add new
                            visit</h2>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; padding-top: 10px;">
                        <ul style="list-style: none; width: 100%; padding: 0">
                            <li class="form-li">
                                <label for="datetime-field">Date/Time</label><input id="datetime-field" name="datetime"
                                                                                    type="datetime-local" value=""></li>
                            <li class="form-li">
                                <label for="duration-field">Duration (Minutes)</label><input id="duration-field"
                                                                                          name="duration"
                                                                                          type="number" value="1"
                                min="1"></li>
                        </ul>
                        <div style="width: 30%; padding: 0; margin-bottom: 20px; position: absolute; bottom: 0">
                            <input type="submit" value="Save" style="margin-bottom: 20px"/>
                            <button class="btn" type="button" onclick="window.location.href='/'">Cancel</button>
                        </div>
                    </td>
                    <td colspan="2" style="padding-top: 10px">
                        <div style="width: 100%;max-height: 500px; overflow: hidden;"> <?php include_once 'templates/sections/map.php' ?></div>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<script>
    (() => {
        clickingEnabled = true;
        document.querySelector("#datetime-field")
            .setAttribute("value", "<?php echo date_format(new DateTime(), "Y-m-d\TH:i") ?>")
    })();
</script>