<?php
include "auto.php";
$errors_join = array();
if (isset($_POST['game_id'])) {
    $mysql = new mysqli('localhost', 'root', 'usbw', 'tictac');
    if ($mysql->connect_error) die('Connect error (' . $mysql->connect_errno . ')' . $mysql->connect_error);
    $z = "SELECT * FROM games where id = '" . $_POST['game_id'] . "' limit 1";
    $res = $mysql->query($z, MYSQLI_STORE_RESULT);
    while($row = mysqli_fetch_array($res)) {
        if (($row['p1'] == $_SESSION['login']) || ($row['p2'] == $_SESSION['login'])) {
            header("Location: play.php?id=" . $_POST['game_id']);
            exit;
        }
        $id = strval($_POST['game_id']);
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
        header("Location: play.php?id=" . $_POST['game_id']);
        exit;
    }
    array_push($errors_join, "Game not found");
//    header("Location: index.php");
//    exit;
} else {
//    header("Location: index.php");
//    exit;
}

?>