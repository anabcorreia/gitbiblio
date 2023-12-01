<?php
class UserModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Model para criar Users
    public function criarUser($nome, $email, $senha) {
        try {
            $sql = "INSERT INTO users (nome, email, senha, tipo_usuario) VALUES (?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$nome, $email, $senha, 2]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
