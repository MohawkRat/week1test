<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
        <input type="text" name="email">
        <input type="submit">
    </form>
</body>
</html>
<?php

include_once('sql.php');

/// Initial start up
$sql = new sql();


//Check email doesnt exist

if (isset($_POST['email'])) {
    if ($sql->checkEmail($_POST['email']) == "email exists") {
        echo "email exists please use a different email";
    }
}
