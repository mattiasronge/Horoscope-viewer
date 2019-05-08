<?php

session_start();
$_SESSION["id"] = $_POST['id'];
echo $_SESSION["id"];
?>