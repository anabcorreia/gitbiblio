<?php
class EmprestimoModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function emprestarLivro($livroID, $livroNome, $usuarioNome) {
        $consultaLivro = $this->pdo->prepare("SELECT quantidade FROM livros WHERE livro_id = ?");
        $consultaLivro->execute([$livroID]);
        $livro = $consultaLivro->fetch(PDO::FETCH_ASSOC);

        if ($livro && $livro['quantidade'] > 0) {
            $novaQuantidade = $livro['quantidade'] - 1;
            $this->atualizarQuantidade($livroID, $novaQuantidade);

            $inserirEmprestimo = $this->pdo->prepare("INSERT INTO emprestimos (livro_emprestimo, nome_livro, aluno_emprestimo, data_emprestimo) VALUES (?, ?, ?, NOW())");
            $inserirEmprestimo->execute([$livroID, $livroNome, $usuarioNome]);

            return true;
        }

        return false;
    }

    public function devolverLivro($emprestimoID) {
        $consultaEmprestimo = $this->pdo->prepare("SELECT livro_emprestimo, nome_livro, aluno_emprestimo FROM emprestimos WHERE emprestimo_id = ?");
        $consultaEmprestimo->execute([$emprestimoID]);
        $emprestimo = $consultaEmprestimo->fetch(PDO::FETCH_ASSOC);

        if ($emprestimo) {
            $livroID = $emprestimo['livro_emprestimo'];
            $livroNome = $emprestimo['nome_livro'];
            $usuarioNome = $emprestimo['aluno_emprestimo'];

            $consultaLivro = $this->pdo->prepare("SELECT quantidade FROM livros WHERE livro_id = ?");
            $consultaLivro->execute([$livroID]);
            $livro = $consultaLivro->fetch(PDO::FETCH_ASSOC);

            if ($livro) {
                $novaQuantidade = $livro['quantidade'] + 1;
                $this->atualizarQuantidade($livroID, $novaQuantidade);

                // Adicionar o código para inserir no histórico
                $this->registrarHistorico($emprestimoID, $livroID, $livroNome, $usuarioNome);

                // Remover o empréstimo da tabela emprestimos
                $excluirEmprestimo = $this->pdo->prepare("DELETE FROM emprestimos WHERE emprestimo_id = ?");
                $excluirEmprestimo->execute([$emprestimoID]);

                return true;
            }
        }

        return false;
    }

    private function atualizarQuantidade($livroID, $novaQuantidade) {
        $atualizarQuantidade = $this->pdo->prepare("UPDATE livros SET quantidade = ? WHERE livro_id = ?");
        $atualizarQuantidade->execute([$novaQuantidade, $livroID]);
    }
    public function listarLivrosEmprestados($usuarioNome) {
        $consultaLivrosEmprestados = $this->pdo->prepare("SELECT * FROM emprestimos WHERE aluno_emprestimo = ?");
        $consultaLivrosEmprestados->execute([$usuarioNome]);
    
        return $consultaLivrosEmprestados->fetchAll(PDO::FETCH_ASSOC);
    }
    private function registrarHistorico($emprestimoID, $livroID, $nomeLivro, $nomeUsuario) {
        $inserirHistorico = $this->pdo->prepare("INSERT INTO historico (emprestimo_id, livro_id, nome_livro, nome_aluno) VALUES (?, ?, ?, ?)");
        $inserirHistorico->execute([$emprestimoID, $livroID, $nomeLivro, $nomeUsuario]);
        $dataRegistrada = $this->pdo->query("SELECT hora FROM historico WHERE emprestimo_id = $emprestimoID")->fetchColumn();
    }  
    public function listarHistorico() {
        $sql = "SELECT * FROM historico";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
}
?>
