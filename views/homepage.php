<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hello Bulma!</title>
    <link rel="stylesheet" href="/styles/bulma.min.css">
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
                        echo '<a class="navbar-item" id="logout">logout</a>';
                    }?>
                </div>
                <div class="navbar-end"></div>
            </div>
        </div>
    <div class="container">
        <?php
                $i = 0;
                foreach($this->photos as $img) {
                    if ($i % 3 == 0) {
                        if ($i != 0) {
                            echo '</div>';
                        }
                        echo '<div class="columns is-multiline">';
                    }
                    $i++;
                    include ROOT . '/views/tpls/main_photo.tpl.php';
                }
            ?>
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
<script src="/scripts/like_script.js"></script>
<script src="/scripts/gallery_script.js"></script>
</html>
