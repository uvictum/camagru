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
            <div class="column is-4 is-offset-4">
                <h3 class="title has-text-grey">Registration</h3>
                <p class="subtitle has-text-grey">Please fill up the form to signup</p>
                <div class="box">
                    <form action="/login" method="post">
                        <div class="field">
                            <div class="control">
                                <input class="input" type="text" name="username" placeholder="Your Login" autofocus="">
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <input class="input" type="email" name="email" placeholder="Your Email">
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <input class="input" type="password" id="pass" name="pass" placeholder="Your Password">
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <input class="input" type="password" id="pass_repeat" placeholder="Repeat Password">
                            </div>
                        </div>
                        <button class="button is-centered is-info">Signup</button>
                    </form>
                </div>
                <p class="help is-small is-success"></p>
            </div>
        </div>
    </div>
    <footer class="footer is-fixed-bottom">
        <div class="content has-text-centered">
            &copy; 2018 <span class="has-text-weight-semibold">by vmorguno</span> at UNIT Factory</br>
            All questions to vmorguno@student.unit.ua
        </div>
    </footer>
</body>
<script src="/scripts/request_queries.js"></script>
<script src="/scripts/signup_script.js"></script>
</html>