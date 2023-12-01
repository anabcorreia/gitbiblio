<?php
require_once 'App/Model/UserModel.php';

class UserController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new UserModel($pdo);
    }

    public function criarUser($nome, $email, $senha) {
        $result = $this->userModel->criarUser($nome, $email, $senha);

        if ($result) {
            $_SESSION['mensagem'] = 'Conta criada com sucesso';
        } else {
            $_SESSION['mensagem'] = 'Erro ao criar a conta';
        }
    }
}
?>
