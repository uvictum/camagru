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
            <a class="navbar-item" href="/logout">logout</a>
        </div>
        <div class="navbar-end"></div>
    </div>
    </div>
    <div class="columns body-columns">
        <div class="column is-one-third-desktop is-offset-one-third-desktop">
            <div class="card">
                <div class="card-image">
                    <figure class="image is-4by3">
                        <img id="<?php echo $photo['ID']?>" src="<?php echo $photo['Link'] ?>">
                    </figure>
                </div>
                <div class="card-content">
                    <div class="media">
                        <div class="media-content">
                            <p class="title is-4"><?php echo $photo['Login'] ?></p>
                        </div>
                        <nav class="level is-mobile">
                            <div class="level-left">
                                <p class="level-item">
                                    Likes: <?php echo $photo['Likes']?>
                                </p>
                                <a class="level-item">
                                    <span class="icon is-small">
                                        <svg class="icon like<?php if ($liked > 0) { echo 'd'; }?>_symbol" id="img_<?php echo $photo['ID']?>">
                                            <use xlink:href="#heart<?php if ($liked == 0) { echo '-1'; }?>" />
                                        </svg>
                                    </span>
                                </a>
                                <p class="level-item">
                                    Comments: <?php echo $photo['Comments']?>
                                </p>
                                <a class="level-item">
                                    <span class="icon is-small">
                                        <svg class="icon">
                                            <use xlink:href="#comment" />
                                        </svg>
                                    </span>
                                </a>
                                <?php if($_SESSION['login'] == $photo['Login']) :?>
                                    <p class="level-item">
                                        Delete image
                                    </p>
                                    <a class="level-item" id="deleteBtn">
                                        <span class="icon is-small">
                                            <svg class="icon">
                                                <use xlink:href="#close" />
                                            </svg>
                                        </span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </nav>
                    </div>
                    <div class="content">
                        <time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time>
                    </div>
                    <?php
                    if (!empty($comments)) {
                        foreach ($comments as $comment) {
                            include (ROOT .'/views/tpls/comment.tpl.php');
                        }
                    }
                    if (!empty($_SESSION['logged_user'])) :?>
                    <div id="comment_field" class="field">
                        <article class="media">
                            <div class="media-content">
                                <div class="field">
                                    <p class="control">
                                        <textarea id="commentText" class="textarea" placeholder="Add a comment..."></textarea>
                                    </p>
                                    <p class="help is-danger is-hidden" id="commentHelper"></p>
                                </div>
                                <nav class="level">
                                    <div class="level-left">
                                        <div class="level-item">
                                            <a class="button is-info" id="commentBtn">Submit</a>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </article>
                    </div>
                    <?php endif; ?>
                </div>
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
<script src="/scripts/comment_script.js"></script>
<script src="/scripts/like_script.js"></script>
</html>