<?php
include_once "support/User.php";
$user = \User::getUserById($_SESSION["user_pk"]);
?>
<div style="margin-top: 20px">
    <div class="watermark">
        <img src="/static/img/watermark.png" alt="watermark" style="margin-left: 15%">
    </div>
    <div class="content">
        <!--suppress HtmlDeprecatedAttribute -->
        <table style="table-layout: fixed;width: 100%; padding-left: 50px; padding-right: 50px" cellpadding="0"
               cellspacing="0">
            <tr>
                <td colspan="3" style="border-bottom: black solid 2pt"><h2 style="text-align: center">Status</h2></td>
            </tr>
            <tr>
                <td style="vertical-align: top; padding-top: 10px; display: flex">
                    <p>Hi <?php echo $user->username ?>, you may have had a connection with an infected person.</p>
                    <p style="bottom: 0; position: absolute; width: 30%">Click on the marker to see details about an infection.</p>
                </td>
                <td colspan="2" style="padding-top: 10px">
                    <div style="width: 100%;max-height: 500px; overflow: hidden;"> <?php include_once 'templates/sections/map.php' ?></div>
                </td>
            </tr>
        </table>
    </div>
</div>