<?php
// Essa view corresponde à página produtos/index do site.
?>

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
        foreach($data['products'] as $product) {
            ?>
            <p>ID: <?php echo $product['id']; ?></p>
            <p>ID do Usuário: <?php echo $product['user_id']; ?></p>
            <p>Nome: <?php echo $product['name']; ?></p>
            <p>Código: <?php echo $product['code']; ?></p>
            <p>Quantidade: <?php echo $product['quantity']; ?></p>
            <hr>
            <?php
        }
    ?>

    <p>Total de <?php echo count($data['products']); ?> produtos!</p>
</body>
</html>