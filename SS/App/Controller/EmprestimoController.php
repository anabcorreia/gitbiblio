<?php
require_once 'App\Model\EmprestimoModel.php';

class EmprestimoController {
    private $emprestimoModel;

    public function __construct($pdo) {
        $this->emprestimoModel = new EmprestimoModel($pdo);
    }

    public function emprestarLivro($livroID, $livroNome, $usuarioNome) {
        if ($this->emprestimoModel->emprestarLivro($livroID, $livroNome, $usuarioNome)) {
            header('Location: book.php');
            exit();
        } else {
            echo "Não foi possível realizar o empréstimo.";
        }
    }

    public function devolverLivro($livroID) {
        if ($this->emprestimoModel->devolverLivro($livroID)) {
            header('Location: book.php');
            exit();
        } else {
            echo "Não foi possível realizar a devolução.";
        }
    }
    public function listarLivrosEmprestados($usuarioNome) {
        return $this->emprestimoModel->listarLivrosEmprestados($usuarioNome);
    }
}
?>
