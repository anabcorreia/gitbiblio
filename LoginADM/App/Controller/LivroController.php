<?php
require_once 'App/Model/LivroModel.php';


class LivroController {
    private $livroModel;

    public function __construct($pdo) {
        $this->livroModel = new LivroModel($pdo);
    }

    public function criarLivro($nome, $categoria, $quantidade, $imagem, $categoria_id) {
        $this->livroModel->criarLivro($nome, $categoria, $quantidade, $imagem, $categoria_id);
    }

    public function listarLivros() {
        return $this->livroModel->listarLivros();
    }

    public function exibirListaLivros() {
        $livros = $this->livroModel->listarLivros();
        include 'App/View/Livros/lista.php';
    }
}
?>