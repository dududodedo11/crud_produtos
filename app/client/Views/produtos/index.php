<?php
// Essa view corresponde à página produtos/index do site.

use Client\Helpers\CSRF;

?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $view->callHeader("basic") ?>
    <title>Produtos - Início</title>
</head>

<body class="bg-body-tertiary">
    <?php $view->component("navbar") ?>
    <main class="container">
        <div class="container">
            <p class="text-center text-success"><?php echo $_SESSION['delete_product_response_success'] ?? "" ?></p>
            <h1>Lista de produtos</h1>
            <div class="card">
                <div class="card-header">
                    <a href="<?php echo $view->linkPage("produtos/create") ?>" class="btn btn-primary float-right">Novo Produto</a>
                </div>
                <div class="card-body">
                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Código</th>
                                <th scope="col">Quantidade</th>
                                <th scope="col">Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($data['products'] as $product) {
                            ?>
                                <tr scope="row">
                                    <td><?php echo $product['id']; ?></td>
                                    <td><?php echo $product['name']; ?></td>
                                    <td><?php echo $product['code']; ?></td>
                                    <td><?php echo $product['quantity']; ?></td>
                                    <td>
                                        <a href="<?php echo $_ENV['APP_URL'] . "produtos/index/" . $product['id'] ?>" class="btn btn-primary">Detalhes</a>
                                        <a href="<?php echo $_ENV['APP_URL'] . "produtos/update/" . $product['id'] ?>" class="btn btn-secondary">Editar</a>
                                        <form action="<?php echo $_ENV['APP_URL'] ?>produtos/delete" method="post" class="d-inline">
                                            <input type="hidden" name="csrf_token" value="<?php echo CSRF::generateCSRFToken("form_delete_product"); ?>">
                                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                            <button class="btn btn-danger" type="submit">Deletar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <p>Total de <?php echo count($data['products']); ?> produtos!</p>
                </div>
            </div>
        </div>
    </main>


    <?php $view->component("bootstrapjs") ?>
    <?php 
    unset($_SESSION['delete_product_response_success']);
    ?>
</body>
</html>