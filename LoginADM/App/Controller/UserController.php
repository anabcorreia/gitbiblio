<?php
require_once 'App\Model\UserModel.php';


class UserController {
    private $userModel;

    public function __construct($pdo) {

        $this->userModel = new UserModel($pdo);
    }

    public function criarUser($nome, $email, $senha, $tipo_usuario) {
        $this->userModel->criarUser($nome, $email, $senha, $tipo_usuario);
    }

    public function listarUsers() {
        return $this->userModel->listarUsers();
    }

    public function exibirListaUsers() {
        $users = $this->userModel->listarUsers();
        include 'App/View/Usuarios/lista.php';
    }

    public function atualizarUser($id, $nome, $email, $senha, $tipo_usuario) {
        $this->userModel->atualizarUser($id, $nome, $email, $senha, $tipo_usuario);
    }
    
    public function excluirUser ($id) {
        $this->userModel->excluirUser($id);
    }
}
?>