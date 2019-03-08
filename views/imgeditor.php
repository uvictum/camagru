<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hello Bulma!</title>
    <link rel="stylesheet" href="/styles/bulma.min.css">
    <link rel="stylesheet" href="/styles/camagru.css">
    <link rel="stylesheet" href="/styles/editor.css">
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
            <a class="navbar-item" href="/logout">logout</a>
        </div>
        <div class="navbar-end"></div>
    </div>
</div>
    <div class="Site-content">
        <div class="container box">
            <div class="columns is-mobile">
                <div class="column is-three-fifths-mobile is-narrow-desktop box" id="webcam">
                    <div class="file has-name is-boxed" id="fileInput">
                        <label class="file-label">
                            <input class="file-input" type="file" name="resume" style="display: none">
                            <span class="file-cta">
                                <span class="file-icon">
                                    <i class="fas fa-upload"></i>
                                </span>
                                <span class="file-label">
                                    Choose a file…
                                </span>
                            </span>
                            <span class="file-name">
                                Screen Shot 2017-07-29 at 15.54.25.png
                            </span>
                        </label>
                        <button id="preview" style="display: none">Upload photo</button>
                    </div>
                    <video id="video"></video>
                    <canvas id="canvas" width="640" height="480" style="display: none"></canvas>
                    <canvas id="viewport" width="640" height="480" style="display: none;"></canvas>
                </div>
                <div class="column box" id="previousPhotos">
                    <?php foreach ($photos as $photo) :?>
                        <div class="image">
                            <img src="<?php echo $photo['Link']?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="columns is-mobile box masksSelect">
                <?php foreach($masks as $msk) {
                    echo '<div class="column"><figure class="image is-128x128"><label>';
                    echo '<input type="radio" name="test" value="small"  class="masksPng" checked>';
                    echo'<img src="'.$msk['Link'].'">';
                    echo '</label></figure></div>';
                }
                ?>
            </div>
            <div class="columns is-centered">
                <div class="column has-text-centered">
                    <button id="changeSource" class="button" >Change Source</button>
                    <button id="snap" class="button" disabled>Take Photo</button>
                    <button id="retakePhoto" class="button" style="display: none">Retake Photo</button>
                    <button id="uploadPhoto" class="button is-primary" style="display: none">Upload Photo</button>
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
<script src="/scripts/editor_script.js"></script>
</html>