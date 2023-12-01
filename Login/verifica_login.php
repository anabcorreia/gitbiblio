<?php
if(!$_SESSION['usuarioEmail'] or !$_SESSION['usuarioNomedeUsuario']) {
    header('Location: ../Login/login.php');
    exit();
}