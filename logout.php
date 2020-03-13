<?php
session_start();
setcookie(session_name(), session_id(), time() - 3600);
session_destroy();
header('Location: reg.php');
exit();
?>