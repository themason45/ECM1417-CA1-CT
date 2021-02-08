<?php
include_once 'support/db_connector.php';
include_once 'support/User.php';

if (isset($_POST['username'], $_POST['password'])) {
    $conn = getConnection();

    $username = $_POST["username"];
    $password = $_POST["password"];
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=:username AND password=:password;");
    $stmt->execute(['username' => $username, 'password' => $password]);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $res = $stmt->fetchAll();
    // If there is 1 user in the list, then we can authenticate

    if (count($res) == 1) {
        // Set the session value
        $_SESSION["user_pk"] = $res[0]["pk"];
        header("Location: /");
    }
    $conn = null;
}
?>
<div class="watermark">
    <img src="/static/img/watermark.png" alt="watermark">
</div>
<div class="content center-page" style="width: 100%">
    <div style="margin-top: 100px">
        <form action="/login" method="post">
            <!--suppress HtmlFormInputWithoutLabel -->
            <input type="text" name="username" placeholder="Username">
            <!--suppress HtmlFormInputWithoutLabel -->
            <input type="password" name="password" placeholder="Password">

            <table style="width: 100%">
                <tr>
                    <td style="padding-left: 0"><input type="submit" value="Login" class="btn"></td>
                    <td style="padding-right: 0"><button class="btn" type="button">Cancel</button></td>
                </tr>
            </table>
            <button class="btn" style="margin-top: 10px">Register</button>
        </form>
    </div>
</div>