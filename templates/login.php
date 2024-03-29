<?php
include_once 'support/db_connector.php';
include_once 'support/User.php';
include_once 'support/Csrf.php';

if (isset($_POST['username'], $_POST['password'], $_POST['token'])) {
    if (Csrf::verifyToken($_POST["token"])) {
        $conn = getConnection();

        $username = $_POST["username"];

        $stmt = $conn->prepare("SELECT `username`, `pk` FROM users WHERE username=:username");
        $stmt->execute(['username' => $username]);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $res = $stmt->fetchAll();
        // If there is 1 user in the list, then we can authenticate
        $password = $_POST["password"];
        if (count($res) == 1) {
            $user = User::getUserById($res[0]["pk"]);

            if ($user->checkPassword($password)) {
                // Set the session value
                $_SESSION["user_pk"] = $res[0]["pk"];
                header("Location: /");
            }
        } else {
            echo "Invalid username, or password";
        }
        $conn = null;
    }
}
?>
<div class="watermark">
    <img src="/static/img/watermark.png" alt="watermark">
</div>
<div class="content center-page" style="width: 100%">
    <div style="margin-top: 100px">
        <!--suppress HtmlUnknownTarget -->
        <form action="/login" method="post">
            <?php echo Csrf::formInput() ?>
            <!--suppress HtmlFormInputWithoutLabel -->
            <input type="text" name="username" placeholder="Username">
            <!--suppress HtmlFormInputWithoutLabel -->
            <input type="password" name="password" placeholder="Password">

            <table style="width: 100%">
                <tr>
                    <td style="padding-left: 0"><input type="submit" value="Login" class="btn"></td>
                    <td style="padding-right: 0">
                        <button class="btn" type="button">Cancel</button>
                    </td>
                </tr>
            </table>
            <input class="btn" type="button" style="margin-top: 10px" onclick="window.location.href='/register'"
                   value="Register">
        </form>
    </div>
</div>