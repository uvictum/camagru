<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style type="text/css">
    </style>
</head>
<body>
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
</body>