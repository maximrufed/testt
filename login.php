<?php
include 'auto.php';
if (isset($_SESSION['login'])) {
    header('Location: index.php');
    exit();
}
$errors = array();
if (isset($_POST['login'], $_POST['pass'])) {
    if ($_POST['login'] != '' && $_POST['pass'] != '') {
        $mysql = new mysqli('localhost', 'root', 'usbw', 'tictac');
        $z = "SELECT * FROM users where login = '" . $_POST['login'] . "' and pass = '" . $_POST['pass'] ."' limit 1";
        $res = $mysql->query($z, MYSQLI_STORE_RESULT);
        $cnt = 0;
        while($row = mysqli_fetch_array($res)) {
            $cnt++;
        }
        if ($cnt == 0) {
            array_push($errors, "Login or password are incorrect");
        } else {
            $_SESSION['login'] = $_POST['login'];
            $_SESSION['pass'] = $_POST['pass'];
            header("Location: index.php");
            exit();
        }
    } else {
        array_push($errors, "Some values are empty");
    }
}
?>

<!DOCTYPE html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Tic-tac-toe</title>
    <!--    <script src="jquery.js"></script>-->
    <!--    <script src="index.js"></script>-->
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class = "frame">
    <form action="login.php" method="post">
        <p>Войти : </p>
        <p>Логин : <input name="login"></p>
        <p>Пароль : <input name="pass"></p>
        <p><input type="submit" value="Войти"></p>
        <?php
        foreach ($errors as $error) {
            echo "<div>" . $error . "</div>";
        }
        ?>
    </form>
</div>
<div class="frame">
    <form action="reg.php" method="post">
        <p><input type="submit" value = "Register"></p>
    </form>
</div>
</body>
