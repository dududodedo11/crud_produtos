<?php
// Essa view corresponde à página produtos/index do site.
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
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-primary float-right">Novo Produto</button>
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
                                        <button class="btn btn-primary">Ação 1</button>
                                        <button class="btn btn-secondary">Ação 2</button>
                                        <button class="btn btn-danger">Ação 3</button>
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
</body>

</html>