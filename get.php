<?php
if (isset($_POST['id'])) {
    $mysql = new mysqli('localhost', 'root', 'usbw', 'tictac');
    if ($mysql->connect_error) {
        die('Connect error (' . $mysql->connect_errno . ')' . $mysql->connect_error);
    }
    $z = 'SELECT * FROM games where id = \'' . $_POST['id'] . '\' limit 1';
    $res = $mysql->query($z, MYSQLI_STORE_RESULT);
    $cnt = 0;
    $json = '';
    while($row = mysqli_fetch_array($res)) {

        $cnt++;
        $json = $row['cash'];
        $obj = json_decode($json);
        $obj->{'turn'} = $row['turn'];
        $json = json_encode($obj);

    }
    if ($cnt == 1 && $json != '') {
        echo $json;
    } else {
        echo -1;
        exit;
    }
}
?>