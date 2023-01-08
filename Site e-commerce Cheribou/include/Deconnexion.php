<?php
session_start();
header('location: ../Compte.php?acces=login');
$_SESSION['access'] = "non";
?>