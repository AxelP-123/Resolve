<?php
session_start();
session_destroy();
header("Location: pre.php");
exit();
?>