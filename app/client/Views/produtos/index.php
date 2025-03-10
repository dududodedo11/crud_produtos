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
                <div class="card-header d-flex align-items-center">
                    <a href="<?php echo $view->linkPage("produtos/create") ?>" class="btn btn-primary" style="margin-right: 10px">Novo Produto</a>
                    <select name="products_limit" id="ProductsLimit" class="form-control" style="display: inline !important; width: min-content">
                        <option value="12" <?php echo ($data['limit'] == 12) ? "selected" : "" ?>>12 p/ página</option>
                        <option value="15" <?php echo ($data['limit'] == 15) ? "selected" : "" ?>>15 p/ página</option>
                        <option value="20" <?php echo ($data['limit'] == 20) ? "selected" : "" ?>>20 p/ página</option>
                    </select>
                </div>
                <div class="card-body" id="ProductsTable">

                    <form action="" class="w-100  d-flex align-items-center justify-content-center mb-3" method="get" id="formSearchProduct">
                        <input type="text" name="search" id="SearchNameProduct" class="form-control" placeholder="Pesquisar produto pelo nome" style="width: 350px; margin-right: 10px;" value="<?php echo $data['search'] ?? "" ?>">

                        <button type="submit" class="btn btn-primary" style="width: 70px;" title="Pesquisar"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>

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
                            <?php foreach ($data['products'] as $product): ?>
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
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <nav aria-label="Page navigation" class="">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?php echo $data['currentPage'] == 1 ? 'disabled' : ''; ?>">
                                <a href="<?php echo $_ENV['APP_URL'] . "produtos?page=" . ($data['currentPage'] - 1) . "&limit=" . ($data['limit']) . "&search=" . $data['search'] . "#ProductsTable"; ?>" class="page-link">Anterior</a>
                            </li>

                            <?php for ($i = 1; $i <= $data['totalPages']; $i++): ?>
                                <li class="page-item <?php echo $data['currentPage'] == $i ? 'active' : ''; ?>">
                                    <a class="page-link" href="<?php echo $_ENV['APP_URL'] . "produtos?page=" . $i . "&limit=" . ($data['limit']) . "&search=" . $data['search'] . "#ProductsTable"; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <li class="page-item <?php echo $data['currentPage'] == $data['totalPages'] ? 'disabled' : ''; ?>">
                                <a href="<?php echo $_ENV['APP_URL'] . "produtos?page=" . ($data['currentPage'] + 1) . "&limit=" . $data['limit'] . "&search=" . $data['search'] . "#ProductsTable"; ?>" class="page-link">Próximo</a>
                            </li>
                        </ul>
                    </nav>
                    <p class="text-center text-info"><?php echo $data['search'] == "" ? "Você tem um total de {$data['totalProducts']} produto(s)." : "Foi encontrado um total de {$data['totalProducts']} produto(s)." ?></p>
                </div>
            </div>
        </div>
    </main>


    <?php $view->component("bootstrapjs") ?>
    <script src="<?php echo $view->linkAsset("js/produtos/index.js") ?>"></script>
    <?php
    unset($_SESSION['delete_product_response_success']);
    ?>
</body>

</html>