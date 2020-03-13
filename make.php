<div class = "frame">
    <form action="index.php">
        <p><input type="submit" value="Main menu"></p>
    </form>
</div>

<?php
$n = 0;
$k = 0;
$id = '';
if (isset($_POST['id'], $_POST['n'], $_POST['k'])) {
    $n = intval($_POST['n']);
    $k = intval($_POST['k']);
    $id = strval($_POST['id']);
    if ($n > 0 && $n <= 10 && $k > 0 && $k <= $n && $id != "") {

        $mysql = new mysqli('localhost', 'root', 'usbw', 'tictac');
        $cnt = 0;
        $z = "select * from games where id = '" . $id . "' limit 1";
        $res = $mysql->query($z, MYSQLI_STORE_RESULT);
        while($row = mysqli_fetch_array($res)) {
            $cnt++;
        }
        if ($cnt == 1) {
            echo "This id is already taken";
            exit;
        }
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

        $z = "INSERT INTO `tictac`.`games` (`id`, `p1`, `p2`, `time`, `cash`, `turn`) VALUES ('" . $_POST['id'] . "', '', '', '', '" . $json . "', '0')";
        if (mysqli_query($mysql, $z)) {
            echo "Map has done sucsessful<br>";
            header('Location: index.php');
            exit;
        } else {
            echo 'error, try one more time';
        }
    } else {
        echo "incorrect values";
    }
} else {
    echo "not enough values";
}

?>
