<?php
if (isset($_POST['username'], $_POST['password'], $_POST['name'], $_POST['surname'], $_POST['token'])) {
    if (Csrf::verifyToken($_POST['token'])) {
        require_once 'support/User.php';
        $user = new User(0, $_POST['username'], password_hash($_POST['password'], PASSWORD_DEFAULT));
        $user->firstName = $_POST['name'];
        $user->lastName = $_POST['surname'];

        $user->save();
        $_SESSION["user_pk"] = $user->pk;
        Header("Location: /");
    }
}
?>
<div class="watermark">
    <img src="/static/img/watermark.png" alt="watermark">
</div>
<div class="content center-page" style="width: 100%">
    <div style="margin-top: 100px; width: 50%" >
        <form action="/register" method="post">
            <?php echo Csrf::formInput() ?>
            <!--suppress HtmlFormInputWithoutLabel -->
            <input type="text" name="name" placeholder="Name">
            <!--suppress HtmlFormInputWithoutLabel -->
            <input type="text" name="surname" placeholder="Surname">
            <!--suppress HtmlFormInputWithoutLabel -->
            <input type="text" name="username" placeholder="Username">
            <!--suppress HtmlFormInputWithoutLabel -->
            <input type="password" name="password" placeholder="Password">

            <input class="btn" type="submit" style="margin-top: 10px" value="Register">
        </form>
    </div>
</div>