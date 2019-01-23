<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hello Bulma!</title>
    <link rel="stylesheet" href="/styles/bulma.min.css">
</head>
<body class="has-navbar-fixed-top">
<div id="navigate" class="navbar is-fixed-top has-shadow">
    <div id="logo" class="navbar-brand">
        <a href="/"><img src="/images/logo.png"></a>
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
<div class="column is-half is-offset-3">
    <div class="field">
        <label class="label">Change Username</label>
        <div class="control">
            <input class="input" type="text" placeholder="<?php echo $_SESSION['login']?>">
        </div>
    </div>

    <div class="field">
        <label class="label">Change Email</label>
        <div class="control">
            <input class="input" type="email" placeholder="Email input">
        </div>
    </div>

    <div class="field">
        <label class="label">Change Password</label>
        <div class="control">
            <input class="input" type="password">
        </div>
    </div>

    <div class="field">
        <label class="label">Notify about new comments?</label>
        <div class="control">
            <div class="select">
                <select>
                    <option>Yes</option>
                    <option>No</option>
                </select>
            </div>
        </div>
    </div>

    <div class="field is-grouped">
        <div class="control">
            <button class="button is-link">Submit</button>
        </div>
        <div class="control">
            <button class="button is-text">Cancel</button>
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
<script src="/scripts/editor_script.js"></script>
</html>