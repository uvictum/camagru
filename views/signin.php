<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="/styles/bulma.min.css">
    <link rel="stylesheet" href="/styles/camagru.css">
    <style type="text/css">
    </style>
</head>
<?php include(ROOT . '/images/icons_sprite.svg')?>
<body class="has-navbar-fixed-top Site">
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
        <div class="hero-body Site-content">
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
                    <h3 class="title has-text-grey">Login</h3>
                    <p class="subtitle has-text-grey">Please login to proceed.</p>
                    <div class="box">
                        <form  action="/login" method="post">
                            <div class="field">
                                <div class="control">
                                    <input class="input is-large" type="text" name="username" placeholder="Your Login" autofocus="">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input class="input is-large" type="password" name="pass" placeholder="Your Password">
                                </div>
                            </div>
                            <button class="button is-block is-info is-large is-fullwidth">Login</button>
                        </form>
                    </div>
                    <p class="has-text-grey">
                        <a href="/signup">Sign Up</a> &nbsp;·&nbsp;
                        <a href="/resetpass">Forgot Password</a>
                    </p>
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
<script src="/scripts/login_script.js"></script>
<script src="/scripts/request_queries.js"></script>
</html>