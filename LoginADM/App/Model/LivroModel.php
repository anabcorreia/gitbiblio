<?php
class LivroModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Model para criar Livros
    public function criarLivro($nome, $categoria, $quantidade, $imagem, $categoria_id) {
        $sql = "INSERT INTO livros (nome, categoria, quantidade, imagem, categoria_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$nome, $categoria, $quantidade, $imagem, $categoria_id]);
    }

    // Model para listar Livros
    public function listarLivros() {
        $sql = "SELECT L.*, CL.nome AS categoria_nome FROM livros L 
                INNER JOIN categoria_livros CL ON L.categoria_id = CL.id 
                ORDER BY CL.id ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>