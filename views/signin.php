<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="/styles/camagru.css">
    <style type="text/css">
    </style>
</head>
<body>
    <header>
    <div id="navigate">
        <div id="logo">
            <a href="/"><img src="/images/logo.png"></a>
        </div>
        <div>
            <?php if (isset($_SESSION['logged_user'])) {
                echo '<a href="/cabinet">Hello, ' . $_SESSION['login'] . '</a>';
            } else {
                echo '<a href="/login">login</a>';
            }?>
            <a href="/editor">editor</a>
            <a href="/logout">logout</a>
        </div>
    </div>
</header>
    <div class="wrapper">
        <div class="main_content">
            <form  action="/login" method="post">
                Username: <input type="text" name="username" value=""><br>
                Password: <input type="password" name="pass" value=""><br>
                <input type="submit" name="submit" value="signin">
            </form>
            <a href="/resetpass">Forgot your password?</a>
        </div>
        <div class="push"></div>
    </div>
    <footer>
        <div>
            &copy; 2018 <span>by vmorguno</span> at UNIT Factory</br>
            All questions to vmorguno@student.unit.ua
        </div>
    </footer>
</body>