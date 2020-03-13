<?php
session_start();
$reg = 0;
$name = '';
if (isset($_SESSION['login']) && isset($_SESSION['pass'])) {
    $mysql = new mysqli('localhost', 'root', 'usbw', 'tictac');
    $z = "SELECT * FROM users where login = '" . $_SESSION['login'] . "' and pass = '" . $_SESSION['pass'] . "' LIMIT 1";
    $res = $mysql->query($z, MYSQLI_STORE_RESULT);
    while($row = mysqli_fetch_array($res)) {
        $name = $row['name'];
    }
    if ($name == '') {
        setcookie(session_name(), session_id(), time() - 3600);
        session_destroy();
        header('Location: reg.php');
        exit();
    }
}
?>
