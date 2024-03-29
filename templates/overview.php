<?php
include_once "support/Location.php";
$locations = Location::queryForUserId($_SESSION["user_pk"])
?>
<div style="margin-top: 20px">
    <div class="watermark">
        <img src="/static/img/watermark.png" alt="watermark" style="margin-left: 15%">
    </div>
    <div class="content">
        <!--suppress HtmlDeprecatedAttribute -->
        <table style="table-layout: fixed;width: 100%; text-align: left; padding-left: 50px; padding-right: 50px;
font-family: Arial,serif; font-size: 20px" >
            <thead>
            <tr>
                <th style="width: 10%; text-align: center">Date</th>
                <th style="width: 10%;">Time</th>
                <th style="width: 10%">Duration</th>
                <th style="width: 10%">X</th>
                <th style="width: 10%">Y</th>
                <th style="width: 10%"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($locations as $loc): ?>
                <tr class="pad-cells">
                    <td style="text-align: center"><?php echo date_format($loc->timeVisited, "d/m/Y") ?></td>
                    <td><?php echo date_format($loc->timeVisited, "h:m") ?></td>
                    <td><?php echo $loc->duration ?></td>
                    <td><?php echo round($loc->x_ratio * 100) ?></td>
                    <td><?php echo round($loc->y_ratio * 100) ?></td>
                    <td style="text-align: left" onclick="removeLocation(<?php echo $loc->pk ?>)">
                        <img src="/static/img/cross.png" width="25px" alt="X"></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    function removeLocation(pk) {
        let xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                location.reload();
            }
        };

        xhttp.open("POST", `/api/location/${pk}/delete/`, true);
        xhttp.send();
    }
</script>