<?php
require_once '../Config/config.php';
require_once 'App/Controller/LivroController.php';
require_once 'App/Controller/EmprestimoController.php';

session_start();

$livroController = new LivroController($pdo);
$emprestimoController = new EmprestimoController($pdo);

$livros = $livroController->listarLivros();

$livrosPorCategoria = [];
foreach ($livros as $livro) {
    $categoria = $livro['categoria'];
    if (!isset($livrosPorCategoria[$categoria])) {
        $livrosPorCategoria[$categoria] = [];
    }
    $livrosPorCategoria[$categoria][] = $livro;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['emprestar'])) {
    $livroID = $_POST['livro_id'];
    $livroNome = $_POST['nome'];
    $usuarioNome = $_SESSION['usuarioNomedeUsuario'];

    $emprestimoController->emprestarLivro($livroID, $livroNome, $usuarioNome);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['devolver'])) {
    $livroID = $_POST['livro_id'];

    $emprestimoController->devolverLivro($livroID);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Euphoria+Script&display=swap">
    <link rel="shortcut icon" href="Public/Assets/_31554896-b491-466e-b129-d77e088c3b0c-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="Public/Css/style.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="Public/Js/script.js"></script>
    <link rel="stylesheet" href="Public/Css/style_index.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="estilo.css">
    <title></title>
</head>
<body style="background-color: whitesmoke;"> 

    <header>


   
        <h2>Book</h2>
        <div class="links">
            <a href="index.php">
                <ion-icon name="home-outline"></ion-icon>
                <span class="text">Home</span>
            </a>
            <a href="book.php">
                <ion-icon name="book-outline"></ion-icon>
                <span class="text">Acervo</span>
            </a>
        </div>
   
        <div class="user-icon" id="user-icon" onclick="showUserInfo()">
            <img class="user" src="Public/Assets/perfil.png">
        </div>
        <div class="user-info" id="user-info">
        <?php
            include '../Login/verifica_login.php'
        ?>
        <h3>Olá <?php echo $_SESSION['usuarioNomedeUsuario'] , "!"; ?> </h3><br>
        <h4>Livros Emprestados</h4><br>
            <ul>
                <?php $livrosEmprestados = $emprestimoController->listarLivrosEmprestados($_SESSION['usuarioNomedeUsuario']); ?>
                <?php foreach ($livrosEmprestados as $emprestimo): ?>
                    <li>
                        <?php echo "<strong>ID do Livro: </strong>" . $emprestimo['livro_emprestimo']; ?> <br>
                        <?php echo "<strong>Livro: </strong>" . $emprestimo['nome_livro']; ?> <br>
                        <?php echo "<strong>Nome do Usuário: </strong>" . $emprestimo['aluno_emprestimo']; ?>
                        <form method="post" action="book.php">
                            <input type="hidden" name="livro_id" value="<?php echo $emprestimo['emprestimo_id']; ?>">
                            <button type="submit" name="devolver">Devolver</button><br><br>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <button id="log" onclick="logout()"><ion-icon name="log-out-outline"></ion-icon></button></div>
    </header>
    <section>
        <div class="banner">
            
            <img src="Public/Assets/Sob o luar sereno da noite sábia Na biblioteca silente, a luz inicia, Páginas sussurram segredos guardados O sereno dança nos livros encantados.png">

        </div>
       
        <div class="bioO">
            <img src="Public/Assets/loogo.png" alt="Oscar">
            <div class="lineBio"></div>
            <div class="desc"><p>A Biblioteca Virtual Book é um oásis para amantes da leitura e ávidos por conhecimento. Com acesso a uma vasta coleção de livros digitais de diferentes gêneros e temas, essa plataforma foi cuidadosamente projetada para oferecer uma experiência única de imersão no universo da leitura. 

Os usuários da Biblioteca Virtual Book têm a oportunidade de explorar uma ampla variedade de obras, desde clássicos intemporais até os mais recentes best-sellers.  

A Biblioteca Virtual Book é mais do que um repositório de livros; é um portal que conecta pessoas ao poder transformador da informação e do entretenimento literário. Seja para aprender, se aventurar por mundos fictícios ou simplesmente relaxar com uma boa leitura, a Book é o destino ideal para quem busca mergulhar no mar infinito de histórias e conhecimento. </p></div>
        </div>
        <div class="pub">
            <div class="cub"></div>
            <div class="pubtext"><a href="book.php">
             <div class="acervo"><h1>Acervo</h1></div></a> </div>
        </div>
    </section>
    <footer>
        <p></p>
    </footer>
</body>
</html>