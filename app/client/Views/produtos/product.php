<?php
// View conrespondente à página produto/index/{id}

use Client\Helpers\CSRF;

?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $view->callHeader("basic") ?>
    <title>Produto - <?php echo $data['product']['name'] ?></title>
</head>

<body class="bg-body-tertiary">
    <?php $view->component("navbar") ?>
    <main class="container">
        <div class="card">
            <div class="card-header">
                <div class="float-end">
                    <a href="<?php echo $_ENV['APP_URL'] . "produtos/update/" . $data['product']['id'] ?>" class="btn btn-primary mx-1">Editar</a>
                    <form action="<?php echo $_ENV['APP_URL'] ?>produtos/delete" method="post" class="d-inline">
                        <input type="hidden" name="csrf_token" value="<?php echo CSRF::generateCSRFToken("form_delete_product"); ?>">
                        <input type="hidden" name="product_id" value="<?php echo $data['product']['id']; ?>">
                        <button class="btn btn-danger" type="submit">Deletar</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <form>
                    <div class="">
                        <div class="mb-3">
                            <label for="idProduct">ID do produto:</label>
                            <input type="number" name="id" id="idProduct" class="form-control" value="<?php echo $data['product']['id'] ?>" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="nameProduct">Nome:</label>
                            <input type="text" name="name" id="nameProduct" class="form-control" value="<?php echo $data['product']['name'] ?>" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="quantityProduct">Quantidade (estoque):</label>
                            <input type="number" name="quantity" id="quantityProduct" class="form-control" value="<?php echo $data['product']['quantity'] ?>" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="codeProduct">Código do produto:</label>
                            <input type="text" name="code" id="codeProduct" class="form-control" value="<?php echo $data['product']['code'] ?>" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="descriptionProduct">Descrição/Observação:</label>
                            <textarea name="description" id="descriptionProduct" class="form-control" rows="3" disabled><?php echo empty($data['product']['description']) ? "Sem descrição" : $data['product']['description']; ?></textarea>
                        </div>
                    </div>
                </form>

                <p class="text-success mt-1 text-center">
                    <?php echo $_SESSION['update_product_response_success'] ?? "" ?>
                </p>
            </div>
        </div>
    </main>

    <?php $view->component("bootstrapjs") ?>
    <?php
    unset($_SESSION['update_product_response_success']);
    ?>
</body>

</html>