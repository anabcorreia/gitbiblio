<!DOCTYPE html>
<html>
<head>
    <title>Lista de Livros</title>
</head>
<body>
    <?php
    $livrosPorCategoria = [];
    foreach ($livros as $livro) {
        $categoria = $livro['categoria'];
        if (!isset($livrosPorCategoria[$categoria])) {
            $livrosPorCategoria[$categoria] = [];
        }
        $livrosPorCategoria[$categoria][] = $livro;
    }
    ?>

    <h1>Lista de Livros</h1>
    
    <?php foreach ($livrosPorCategoria as $categoria => $livrosNaCategoria): ?>
        <div class="categoria">
            <h2><?php echo $categoria; ?></h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>Imagem</th>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Quantidade</th>
                        <th>Categoria_id</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($livrosNaCategoria as $livro): ?>
                        <tr>
                            <td>
                                <?php
                                if (!empty($livro['imagem'])) {
                                    echo '<img src="' . $livro['imagem'] . '" alt="Imagem do Livro" width="100">';
                                } else {
                                    echo 'Sem Imagem';
                                }
                                ?>
                            </td>
                            <td><?php echo $livro['livro_id']; ?></td>
                            <td><?php echo $livro['nome']; ?></td>
                            <td><?php echo $livro['quantidade']; ?></td>
                            <td><?php echo $livro['categoria_id']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>
</body>
</html>