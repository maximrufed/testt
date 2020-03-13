<?php
include 'auto.php';
if (isset($_SESSION['login'])) {
    header('Location: index.php');
    exit();
}
$errors = array();
if (isset($_POST['login']) && isset($_POST['pass']) && isset($_POST['name'])) {
    if ($_POST['login'] != '' && $_POST['pass'] != '' && $_POST['name'] != '') {
        $mysql = new mysqli('localhost', 'root', 'usbw', 'tictac');
        $z = "SELECT * FROM users where login = '" . $_POST['login'] . "' limit 1";
//        echo $z;
//        exit();
        $res = $mysql->query($z, MYSQLI_STORE_RESULT);
        $cnt = 0;
        while($row = mysqli_fetch_array($res)) {
            $cnt++;
        }
        if ($cnt == 0) {
            $z = "INSERT INTO `tictac`.`users` (`login`, `pass`, `name`) VALUES ('" . $_POST['login'] . "', '" . $_POST['pass'] . "', '" . $_POST['name'] . "');";
            if (mysqli_query($mysql, $z)) {
                $_SESSION['login'] = $_POST['login'];
                $_SESSION['pass'] = $_POST['pass'];
//                echo "New record created successfully";
                header('Location: index.php');
                exit();
            } else {
                array_push($errors, "Error, try one more time'");
            }
        } else {
            array_push($errors, "This login is already taken");
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
    <form action="reg.php" method="post">
        <p>Регистрация : </p>
        <p>Логин : <input name="login"></p>
        <p>Пароль : <input name="pass"></p>
        <p>Имя : <input name="name"></p>
        <p><input type="submit" value="Зарегистрироваться"></p>
        <?php
        foreach ($errors as $error) {
            echo "<div>" . $error . "</div>";
        }
        ?>
    </form>
</div>
<div class="frame">
    <form action="login.php" method="post">
        <p><input type="submit" value = "Sing in"></p>
    </form>
</div>
</body>
