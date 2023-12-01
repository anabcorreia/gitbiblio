<?php

require_once '../Config/config.php';
require_once 'App/Controller/LivroController.php';
require_once 'App/Controller/UserController.php';
require_once 'App/Controller/emprestimoController.php';

$emprestimoController = new emprestimoController($pdo);
$emprestimos = $emprestimoController->listarHistorico();

$userController = new UserController($pdo);
$users = $userController->listarUsers();

$livroController = new LivroController($pdo);
$livros = $livroController->listarLivros();


$html = '<h2>Lista de Usuário</h2>
<ul>';
foreach ($users as $user) {
    $html .= '<li>' . $user['id'] . ' - ' . $user['nome'] . ' Anos - ' . $user['email'] . ' - ' . $user['senha'] . ' - ' . $user['tipo_usuario'] . '</li>';
}
$html .= '</ul>

<h2>Lista de Livro</h2>
<ul>';
foreach ($livros as $livro) {
    $html .= '<li>' . $livro['livro_id'] . ' - ' . $livro['nome'] . ' Anos - ' . $livro['quantidade'] . ' - ' . $livro['categoria_id'] . '</li>';
}
$html .= '</ul>

<h2>Histórico</h2>
<ul>';
foreach ($emprestimos as $emprestimo) {
    $html .= '<li><strong>Livro: </strong>' . $emprestimo['nome_livro'] . ';<br> <strong>Usuário:</strong> ' . $emprestimo['nome_aluno'] . '<br> <strong>Horário da devolução:</strong> ' . $emprestimo['hora'] . '<br><br></li>';
}
$html .= '</ul>';

require_once '../vendor/autoload.php';

// referenciando o namespace do dompdf
use Dompdf\Dompdf;

// instanciando o dompdf
$dompdf = new Dompdf();

// inserindo o HTML que queremos converter
$dompdf->loadHtml($html);

// Definindo o papel e a orientação
$dompdf->setPaper('A4', 'landscape');

// Renderizando o HTML como PDF
$dompdf->render();

// Enviando o PDF para o browser
$dompdf->stream();

?>
