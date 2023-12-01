<?php 
session_start();
unset($_SESSION['usuarioEmail']);
header('Location: login.php');
exit();