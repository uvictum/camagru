<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hello Bulma!</title>
    <link rel="stylesheet" href="/styles/bulma.min.css">
    <link rel="stylesheet" href="/styles/camagru.css">
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
    <div class="container Site-content">
    <form>
        <div class="column is-half is-offset-3">
            <div class="field">
                <label for="login" class="label">Change Username</label>
                <div class="control">
                    <input id="login" name="Login" class="input" type="text" value="<?php echo $this->user->Login ?>">
                </div>
            </div>
            <div class="field">
                <label for="email" class="label">Change Email</label>
                <div class="control">
                    <input id="email" name="Email" class="input" type="email" value="<?php echo $this->user->Email ?>">
                </div>
            </div>
            <div class="field">
                <label for="pass" class="label">Change Password</label>
                <div class="control">
                    <input id="pass" name="Pass" class="input" type="password">
                </div>
            </div>
            <div class="field">
                <label for="passrepeat" class="label">Repeat Password</label>
                <div class="control">
                    <input id="passrepeat" class="input" type="password">
                </div>
            </div>
            <div class="field">
                <label for="notify" class="label">Notify about new comments?</label>
                <div class="control">
                        <select id="notify" name="Notify">
                            <?php if($this->user->Notify == 1) :?>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                            <?php else :?>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                            <?php endif; ?>
                        </select>
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
        </form>
    </div>
    <footer class="footer is-fixed-bottom">
        <div class="content has-text-centered">
            &copy; 2018 <span class="has-text-weight-semibold">by vmorguno</span> at UNIT Factory</br>
            All questions to vmorguno@student.unit.ua
        </div>
    </footer>
</body>
<script src="/scripts/cabinet_script.js"></script>
<script src="/scripts/request_queries.js"></script>
</html>