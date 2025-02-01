<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - Início</title>
</head>
<body>
    <h1>Lista de produtos:</h1>
    <?php

        foreach($dataInView['products'] as $product) {
            extract($product);
            ?>
            <p>ID: <?php echo $id; ?></p>
            <p>ID do Usuário: <?php echo $user_id; ?></p>
            <p>Nome: <?php echo $name; ?></p>
            <p>Código: <?php echo $code; ?></p>
            <p>Quantidade: <?php echo $quantity; ?></p>
            <hr>
            <?php
        }
    ?>

    <p>Total de <?php echo count($dataInView['products']); ?> produtos!</p>
</body>
</html>