<?php
include_once "support/User.php";
include_once "support/Infection.php";

$user = User::getUserById($_SESSION["user_pk"]);
if (isset($_POST["datetime"])) {
    $infection = new Infection($user, date_create_from_format("Y-m-d?H:i",$_POST["datetime"]));
    $infection->save();
}

?>
<div style="margin-top: 20px">
    <div class="watermark">
        <img src="/static/img/watermark.png" alt="watermark" style="margin-left: 15%">
    </div>
    <div class="content" style="height: 100%">
        <!--suppress HtmlDeprecatedAttribute -->
        <table style="table-layout: fixed;width: 100%; padding-left: 50px; padding-right: 50px; height: 100%"
               cellpadding="0"
               cellspacing="0">
            <tr style="height: 5%">
                <td colspan="3" style="border-bottom: black solid 2pt"><h2 style="text-align: center">Report an
                        infection</h2></td>
            </tr>
            <tr>
                <td colspan="3" style="padding-top: 10px;">
                    <div style="align-content: center;">
                        <p style="text-align: center">Please report the date, and time, that you tested positive for
                            COVID-19.</p>
                    </div>
                </td>
            </tr>
            <tr style="height: 35%">
                <td colspan="3">
                    <div class="content center-page" style="width: 100%">
                        <form action="/report" method="post" style="width: 75%">
                            <table style="width: 100%;">
                                <tbody>
                                <tr>
                                    <td colspan="3">
                                        <div style="width: 50%; display: block; margin: 0 auto">
                                            <!--suppress HtmlFormInputWithoutLabel -->
                                            <input type="datetime-local" class="" name="datetime"
                                                   placeholder="Date & Time" id="datetime-field">
                                        </div>
                                    </td>
                                </tr>
                                <tr style="width: 100%">
                                    <td colspan="1" style="align-content: start">
                                        <input type="submit" class="btn" value="Report" style="width: 50%"></td>
                                    <td colspan="1"></td>
                                    <td colspan="1" style="text-align: end;">
                                        <input type="button" class="btn" value="Cancel"
                                               onclick="window.location.href = '/'" style="width: 50%"></td>
                                </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </td>
            </tr>
            <tr style="height: 80%">
                <td colspan="3">
                </td>
            </tr>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#datetime-field").attr("value", moment().format("YYYY-MM-DD\Thh:mm"));
    });
</script>