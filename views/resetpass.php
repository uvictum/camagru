<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="/styles/bulma.min.css">
    <style type="text/css">
    </style>
</head>
<?php include(ROOT . '/images/icons_sprite.svg')?>
<body class="has-navbar-fixed-top">
<div id="navigate" class="navbar is-fixed-top has-shadow">
    <div id="logo" class="navbar-brand">
        <a class="navbar-item" href="/">
            <svg width="272.55999755859375" height="56">
                <use xlink:href="#logo" />
            </svg>
        </a>
    </div>
    <div class="navbar-menu">
        <div class="navbar-start">
            <?php if (isset($_SESSION['logged_user'])) {
                echo '<a class="navbar-item" href="/cabinet">Hello, ' . $_SESSION['login'] . '</a>';
            } else {
                echo '<a class="navbar-item" href="/login">login</a>';
            }?>
            <a class="navbar-item" href="/editor">editor</a>
            <?php if (isset($_SESSION['logged_user'])) {
                echo '<a class="navbar-item" href="/logout">logout</a>';
            }?>
        </div>
        <div class="navbar-end"></div>
    </div>
</div>
<div class="hero-body">
    <div class="container has-text-centered">
        <?php if (!array_key_exists('email', $_GET)) :?>
            <form  action="/resetpass" method="post">
                Email or Username: <input type="text" name="username" value=""><br>
                <input type="submit" name="submit" value="reset">
            </form>
        <?php elseif (!empty($_SESSION['reset_id'])) :?>
            <form  action="/setpass" method="post">
                NewPassword: <input type="password" name="newpass" value=""><br>
                <input type="submit" name="submit" value="setpass">
            </form>';
        <?php else: {
            header('Location: /');
        }?>
        <?php endif; ?>
    </div>
</div>
</body>
<script src="/scripts/reset_script.js"></script>
<script src="/scripts/request_queries.js"></script>
</html>