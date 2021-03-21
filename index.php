<?php
session_start();
require_once "config.php";
?>
<head>
    <title>Contact tracer</title>
    <link href="/static/style.css" type="text/css" rel="stylesheet">
</head>
<body style="margin: 0; overflow: hidden">
<div style="margin-bottom: 1vh">
    <?php include 'templates/sections/header.html' ?>
</div>
<?php
include "support/Csrf.php";
// Generate the CSRF token, to verify any post requests.
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = Csrf::generateToken();
}
$token = $_SESSION['token'];

// We want to check if the user is authenticated here, if they are, then display the tabular view, if they are
// not, then display the login/register view
$request = $_SERVER['REQUEST_URI'];
if (!(isset($_SESSION["user_pk"]))) {
    // Check if the current user is logged in
    if (!($request == "/register" or $request == "/login")) {
        Header("Location: /login");
    }
}

$not_login = true;
switch ($request) {
    case '/login' :
        if (isset($_SESSION["user_pk"])) {
            Header("Location: /");
        }
        $not_login = false;
        require __DIR__ . '/templates/login.php';
        break;
    case '/register':
        if (isset($_SESSION["user_pk"])) {
            Header("Location: /");
        }
        $not_login = false;
        require __DIR__ . '/templates/register.php';
        break;
}
?>

<?php if ($not_login) : ?>
    <!--suppress HtmlDeprecatedAttribute -->
    <table style="table-layout: fixed;width: 100%;height: 85.5vh" cellspacing="0" cellpadding="0">
        <tr style="margin: 0">
            <td style="width: 20vw; padding: 0">
                <?php include "templates/sections/sidebar.html"; ?>
            </td>
            <td style="width: 80vw; padding: 0; vertical-align: top">
                <?php
                if (str_starts_with($request, "/api")) {
                    require __DIR__ . '/api.php';
                } else {
                    switch ($request) {
                        case '':
                        case '/' :
                            require __DIR__ . '/templates/home.php';
                            break;
                        case '/overview':
                            require __DIR__ . '/templates/overview.php';
                            break;
                        case '/add_visit':
                            require __DIR__ . '/templates/add_visit.php';
                            break;
                        case '/report':
                            require __DIR__ . '/templates/report.php';
                            break;
                        case '/settings':
                            require __DIR__ . '/templates/settings.php';
                            break;
                        case '/logout':
                            require __DIR__ . '/templates/logout.php';
                            break;
                        case '/logout_confirm':
                            $_SESSION = [];
                            Header("Location: /");
                            break;
                        default:
                            http_response_code(404);
                            require __DIR__ . '/templates/404.php';
                            break;
                    }
                }
                ?>
            </td>
        </tr>
    </table>
<?php endif; ?>
<script>
    let path = window.location.pathname
    let lists = document.querySelectorAll('li.sidebar-li')
    lists.forEach(function (el) {
        let a = el.getElementsByTagName("a")[0]
        let href = a.getAttribute("href")
        if (href === path) {
            el.setAttribute("selected", "");
        }
    })
    window.onresize = function () {
        window.location.reload();
    }
</script>
</body>