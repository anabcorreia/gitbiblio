<!DOCTYPE html>
<html>
<head>
    <title>Lista de Livros</title>
</head>
<body>
    <fieldset>
        <legend><h1>Lista de Livros</h1></legend>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Categoria</th>
                    </tr>
                </thead>
                <?php foreach ($livros as $livro): ?>
                    <tbody>
                        <tr>
                            <td><?php echo $livro['livro_id']; ?></td>
                            <td><?php echo $livro['nome']; ?></td>
                            <td><?php echo $livro['categoria']; ?></td>
                        </tr>
                <?php endforeach; ?>
                <tbody>
            </table>
    </fieldset>
</body>
</html>