<?php 
session_start();
include '../Config/config.php';

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $query = "SELECT * FROM users WHERE (email = :email or nome = :email) AND senha = :senha";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
    $stmt->execute();

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        $_SESSION['usuarioId'] = $resultado['id'];
        $_SESSION['usuarioEmail'] = $resultado['email'];
        $_SESSION['usuarioNomedeUsuario'] = $resultado['nome'];
        $_SESSION['usuarioNiveisAcessoId'] = $resultado['tipo_usuario'];

        
        if ($_SESSION['usuarioNiveisAcessoId'] == "1") {
            header("Location: ../LoginADM/index.php");
        } elseif ($_SESSION['usuarioNiveisAcessoId'] == "2") {
            header("Location: ../SS/index.php");
        }
    } else {
        $_SESSION['nao_autenticado'] = true;
        header('Location: login.php');
        exit();
    }
} 
?>
