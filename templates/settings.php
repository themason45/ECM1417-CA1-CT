<?php
    include_once "support/User.php";
    $user = User::getUserById($_SESSION["user_pk"]);
    if (isset($_POST["distance"], $_POST["window"], $_POST["token"])) {
        if (Csrf::verifyToken($_POST["token"])) {
            $user->distanceOption = $_POST["distance"];
            $user->weekWindow = $_POST["window"];

            $user->update();
            Header("Location: /");
        }
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
                <td colspan="3" style="border-bottom: black solid 2pt"><h2 style="text-align: center">Alert settings</h2></td>
            </tr>
            <tr>
                <td colspan="3" style="padding-top: 10px;">
                    <div style="align-content: center;">
                        <p style="text-align: center">Here you may change the distance, and the time span for which
                        the contact tracing will be performed</p>
                    </div>
                </td>
            </tr>
            <tr style="height: 35%">
                <td colspan="3">
                    <div class="content center-page" style="width: 100%">
                        <!--suppress HtmlUnknownTarget -->
                        <form action="/settings" method="post" style="width: 75%">
                            <?php echo Csrf::formInput()?>
                            <table style="width: 100%;">
                                <tbody>
                                <tr>
                                    <td colspan="3">
                                        <div style="width: 75%; display: block; margin: 0 auto">
                                            <div class="form-group">
                                                <label for="window_input">window</label>
                                                <span><select id="window_input" name="window">
                                                        <option value="1">1 week</option>
                                                        <option value="2">2 weeks</option>
                                                        <option value="3">3 weeks</option>
                                                        <option value="4">4 weeks</option>
                                                    </select>
                                                </span>
                                            </div>
                                            <div class="form-group">
                                                <label for="distance_input">distance</label>
                                                <span><input type="number" id="distance_input" name="distance"
                                                    min="0" max="500" value="<?php echo $user->distanceOption ?>"></span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr style="width: 100%">
                                    <td colspan="1" style="align-content: start">
                                        <input type="submit" class="btn" value="Update" style="width: 50%"></td>
                                    <td colspan="1"></td>
                                    <td colspan="1" style="text-align: end;">
                                        <input type="button" class="btn" value="Cancel"
                                               onclick="goHome()" style="width: 50%"></td>
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
    function goHome() {window.location.href = '/'}
    (() => {
        let option = parseInt(<?php echo $user->weekWindow ?>);
        document.querySelector(`#window_input`).options[option - 1].setAttribute("selected", "true");
    })();
</script>
