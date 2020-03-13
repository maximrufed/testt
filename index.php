<?php
include "auto.php";
if (!isset($_SESSION['login'], $_SESSION['pass'])) {
    header('Location: reg.php');
    exit();
}

$n = 0;
$k = 0;
$id = '';
$mess = array();
if (isset($POST['id'], $POST['k'], $POST['n'])) {
    $n = intval($_POST['n']);
    $k = intval($_POST['k']);
    $id = strval($_POST['id']);
    if ($n > 0 && $n < 10 && $k > 0 && $k <= $n && ($id != '')) {
        $map = array();
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $map[$i][$j] = 0;
            }
        }
        $obj = array(
            "map" => $map,
            "n" => $n,
            "k" => $k
        );
        $json = json_encode($obj);
        $mysql = new mysqli('localhost', 'root', 'usbw', 'tictac');
        if ($mysql->connect_error) die('Connect error (' . $mysql->connect_errno . ')' . $mysql->connect_error);
        $z = "INSERT INTO `tictac`.`games` (`id`, `p1`, `p2`, `time`, `cash`, `turn`) VALUES ('" . $_POST['id'] . "', '', '', '', '" . $json . "', '1')";
        if (mysqli_query($mysql, $z)) {
            array_push($mess, "Map has done successful");
        }
    } else {
        array_push($mess, "incorrect values");
    }
} else {
//    array_push($mess, "not enough values");
}
?>

<?php
//include "auto.php";
$errors_join = array();
if (isset($_POST['game_id'])) {
    array_push($errors_join, "in");
    $mysql = new mysqli('localhost', 'root', 'usbw', 'tictac');
    if ($mysql->connect_error) die('Connect error (' . $mysql->connect_errno . ')' . $mysql->connect_error);
    $id = strval($_POST['game_id']);
    $z = "SELECT * FROM games where id = '" . $id . "' limit 1";
//    echo $z;
    $res = $mysql->query($z, MYSQLI_STORE_RESULT);
    while($row = mysqli_fetch_array($res)) {
        if (($row['p1'] == $_SESSION['login']) || ($row['p2'] == $_SESSION['login'])) {
            header("Location: play.php?id=" . $_POST['game_id']);
            exit;
        }

        $p1 = $row['p1'];
        $p2 = $row['p2'];
        $cash = $row['cash'];
        $turn = $row['turn'];
//        echo $id;
        if ($row['p1'] == '') {
            $z = "DELETE FROM games where id = '" . $id . "'";
            mysqli_query($mysql, $z);
            $z = "INSERT INTO `tictac`.`games` (`id`, `p1`, `p2`, `time`, `cash`, `turn`) VALUES ('" . $_POST['game_id'] . "', '" . $_SESSION['login'] . "', '" . $p2 . "', '', '" . $cash . "', '" . $turn . "')";
            mysqli_query($mysql, $z);
            header("Location: play.php?id=" . $id);
            exit;
        }
        if ($row['p2'] == '') {
            $z = "DELETE FROM games where id = '" . $id . "'";
            mysqli_query($mysql, $z);
            $z = "INSERT INTO `tictac`.`games` (`id`, `p1`, `p2`, `time`, `cash`, `turn`) VALUES ('" . $_POST['game_id'] . "', '" . $p1 . "', '" . $_SESSION['login'] . "', '', '" . $cash . "', '" . $turn . "')";
            mysqli_query($mysql, $z);
            header("Location: play.php?id=" . $id);
            exit;
        }
        header("Location: play.php?id=" . $id);
        exit;
    }
    array_push($errors_join, "Game not found");
//    header("Location: index.php");
//    exit;
} else {
//    array_push($errors_join, "No");
//    header("Location: index.php");
//    exit;
}

?>

<!DOCTYPE html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Tic-tac-toe</title>
    <script src="jquery.js"></script>
    <script src="index.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class = "frame">
    <p>Мы рады вас снова видеть,
        <?php
            echo $name;
        ?>
    </p>
</div>
<div class = "frame">
    <form action="make.php" method="post">
        <p>Новая игра:</p>
        <p>Map size: <input name="n"></p>
        <p>In-raw to win: <input name="k"></p>
        <p>Id: <input name="id"></p>
        <p><input type="submit" value = "Create map"></p>
    </form>
    <?php
    foreach ($mess as $me) {
        echo "<div>" . $me . "</div>";
    }
    ?>
</div>
<div class = "frame">
    <form action="logout.php" method="post">
        <p><input type="submit" value = "Log out"></p>
    </form>
</div>
<div class="frame">
    <p>Присоединиться к играм:</p>
    <?php
    $mysql = new mysqli('localhost', 'root', 'usbw', 'tictac');
    if ($mysql->connect_error) {
        die('Connect error (' . $mysql->connect_errno . ')' . $mysql->connect_error);
    }
    $z = 'SELECT * FROM games where 1';
    $res = $mysql->query($z, MYSQLI_STORE_RESULT);
    while($row = mysqli_fetch_array($res)) {
        if ($row['p1'] == '' || $row['p2'] == '')
            echo $row['id'] . '<br>';
    }
    ?>
</div>
<div class="frame">
    <p>Наблюдать за играми:</p>
    <?php
    $mysql = new mysqli('localhost', 'root', 'usbw', 'tictac');
    if ($mysql->connect_error) die('Connect error (' . $mysql->connect_errno . ')' . $mysql->connect_error);
    $z = 'SELECT * FROM games where 1';
    $res = $mysql->query($z, MYSQLI_STORE_RESULT);
    while($row = mysqli_fetch_array($res)) {
        if (!($row['p1'] == '' || $row['p2'] == ''))
            echo $row['id'] . '<br>';
    }
    ?>
</div>
<div class="frame">
    <form action="index.php" method="post">
        <p>Присоединиться:</p>
        <p>Game id: <input name="game_id"></p>
        <p><input type="submit" value = "Join"></p>
        <?php
        foreach ($errors_join as $me) {
            echo "<div>" . $me . "</div>";
        }
        ?>
    </form>
</div>
</body>
