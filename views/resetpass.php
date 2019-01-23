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
    <div id="wrapper">
        <?php if (!array_key_exists('email', $_GET)) {
            echo '<form  action="/resetpass" method="post">
                Email or Username: <input type="text" name="username" value=""><br>
                <input type="submit" name="submit" value="reset">
                </form>';
        }
            elseif ($mode == 1) {
                echo '<form  action="/setpass" method="post">
                NewPassword: <input type="password" name="newpass" value=""><br>
                <input type="submit" name="submit" value="setpass">
                </form>';
            }
            else
            {
                echo "nothing to reset";
            }
        ?>
    </div>
</body>