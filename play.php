<?php
//exit;
session_start();
$reg = 0;
if (isset($_SESSION['login']) && isset($_SESSION['pass'])) {
    $mysql = new mysqli('localhost', 'root', 'usbw', 'tictac');
    if ($mysql->connect_error) die('Connect error (' . $mysql->connect_errno . ')' . $mysql->connect_error);
    $z = 'SELECT * FROM users where login = \'' . $_SESSION['login'] . '\' and pass = \'' . $_SESSION['pass'] . '\'';
    $res = $mysql->query($z, MYSQLI_STORE_RESULT);
    $cnt = 0;
    while($row = mysqli_fetch_array($res)) {
        $cnt++;
    }
    if ($cnt >= 1) {
        $reg = 1;
    } else {
        setcookie(session_name(), session_id(), time() - 3600);
        session_destroy();
        header('Location: reg.php');
        exit;
    }
}

$id = strval($_GET['id']);


if (isset($_GET['id'])) {
//    $id = strval($_GET['id']);
    $mysql = new mysqli('localhost', 'root', 'usbw', 'tictac');
    if ($mysql->connect_error) die('Connect error (' . $mysql->connect_errno . ')' . $mysql->connect_error);
    $z = "SELECT * FROM games where id = '" . $id . "' limit 1";
    $res = $mysql->query($z, MYSQLI_STORE_RESULT);
    $cnt = 0;
    while ($row = mysqli_fetch_array($res)) {
        $cnt++;
        $p1 = $row['p1'];
        $p2 = $row['p2'];
//        if ($p1 == $_SESSION['login'] || $p2 == $_SESSION['login']) {
            echo "Your game is " . $id . "<br>";
            echo $p1 . " vs " .  $p2 . "<br>";
//        } else {
//            header("Location: index.php");
//            exit;
//        }
    }
    if ($cnt >= 1) {

    } else {
        header("Location: index.php");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}

echo('<script>');
echo('id = \'' . strval($id) . '\'');
echo('</script>');

?>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Usbwebserver</title>
    <script src="jquery.js"></script>
    <script src="play.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div id="msg" class="frame">
    Game is in process...<br>
</div>
<br>
<br>
<br>
<div id="mapid" class = "map">
    Map:
</div>
<div class="back" >
    <form action="index.php"
    <p style="end_f"><input type="submit" value="Main Menu"></p>
    </form>
</div>

</body>
