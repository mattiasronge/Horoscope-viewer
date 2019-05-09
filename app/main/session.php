<?php

session_start();
$_SESSION["id"] = $_POST['no'];
echo $_SESSION["id"];
?>