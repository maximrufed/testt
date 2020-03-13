<?php
session_start();

function check($a, $b, $n) {
    return ($a >= 0 && $b >= 0 && $a < $n && $b < $n);
}

if (isset($_POST['x'], $_POST['y'], $_POST['id'])) {
    $x = intval($_POST['x']);
    $y = intval($_POST['y']);
    $id = strval($_POST['id']);
    if ($x < 0 || $y < 0 || $id == '') {
        echo -1;
        exit;
    }
    $mysql = new mysqli('localhost', 'root', 'usbw', 'tictac');
    if ($mysql->connect_error) die('Connect error (' . $mysql->connect_errno . ')' . $mysql->connect_error);
    $z = 'SELECT * FROM games where id = \'' . $id . '\'  limit 1';
    $res = $mysql->query($z, MYSQLI_STORE_RESULT);
    $cnt = 0;
    $p1= '';
    $p2 = '';
    $cash = '';
    while($row = mysqli_fetch_array($res)) {
        $cnt++;
        $p1 = $row['p1'];
        $p2 = $row['p2'];
        $cash = $row['cash'];
        $turn = intval($row['turn']);
    }
    $json = json_decode($cash);
    $map = $json->{'map'};
    $json->{'msg'} = '';
    $n = intval($json->{'n'});
    $k = intval($json->{'k'});

    if ($cnt == 1) {
        if ($_SESSION['login'] == $p1 && $turn == 0) {
            echo "FIRST";
//            exit;
            if ($map[$x][$y] == 0) {
                $map[$x][$y] = 1;
                $json->{'map'} = $map;
                $cash = json_encode($json);
                $z = "DELETE FROM games where id = '" . $id . "'";
                mysqli_query($mysql, $z);
                $z = "INSERT INTO `tictac`.`games` (`id`, `p1`, `p2`, `time`, `cash`, `turn`) VALUES ('" . $id . "', '" . $p1 . "', '" . $p2 . "', '', '" . $cash . "', '" . '1' . "')";
                mysqli_query($mysql, $z);
//                exit;
            }
        }
        if ($_SESSION['login'] == $p2 && $turn == 1) {
            echo "second";
//            exit;
            if ($map[$x][$y] == 0) {
                $map[$x][$y] = 2;
                $json->{'map'} = $map;
                $cash = json_encode($json);
                $z = "DELETE FROM games where id = '" . $id . "'";
                mysqli_query($mysql, $z);
                $z = "INSERT INTO `tictac`.`games` (`id`, `p1`, `p2`, `time`, `cash`, `turn`) VALUES ('" . $id . "', '" . $p1 . "', '" . $p2 . "', '', '" . $cash . "', '" . '0' . "')";
                mysqli_query($mysql, $z);
//                exit;
            }
        }
    } else {
        echo -1;
        exit;
    }

    if ($turn == 3 || $turn == 4) exit;
//    exit;
    $ansx = array(-1, -1, -1, -1);
    $ansy = array(-1, -1, -1, -1);
    $dx = array(1, 1, 1, 0, 0, -1, -1, -1);
    $dy = array(-1, 0, 1, 1, -1, -1, 0, 1);
    for ($i = 0; $i < 8; $i++) {
        $xn = $x;
        $yn = $y;
        while (check($xn, $yn, $n) && $map[$xn][$yn] == 1) {
            $ansx[$i % 4]++;
            $xn += $dx[$i];
            $yn += $dy[$i];
        }
    }
    for ($i = 0; $i < 8; $i++) {
        $xn = $x;
        $yn = $y;
        while (check($xn, $yn, $n) && $map[$xn][$yn] == 2) {
            $ansy[$i % 4]++;
            $xn += $dx[$i];
            $yn += $dy[$i];
        }
    }
    for ($i = 0; $i < 4; $i++) {
        if ($ansx[$i] >= $k) {
            echo 'XXX wins';
//            $turn = 3;
            $cash = json_encode($json);
            $z = "DELETE FROM games where id = '" . $id . "'";
            mysqli_query($mysql, $z);
            $z = "INSERT INTO `tictac`.`games` (`id`, `p1`, `p2`, `time`, `cash`, `turn`) VALUES ('" . $id . "', '" . $p1 . "', '" . $p2 . "', '', '" . $cash . "', '" . '3' . "')";
            mysqli_query($mysql, $z);
            exit;
        }
        if ($ansx[$i] >= $k) {
            echo 'OOO wins';
//            $turn = 3;
            $cash = json_encode($json);
            $z = "DELETE FROM games where id = '" . $id . "'";
            mysqli_query($mysql, $z);
            $z = "INSERT INTO `tictac`.`games` (`id`, `p1`, `p2`, `time`, `cash`, `turn`) VALUES ('" . $id . "', '" . $p1 . "', '" . $p2 . "', '', '" . $cash . "', '" . '4' . "')";
            mysqli_query($mysql, $z);
            exit;
        }

    }

}

?>