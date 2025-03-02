<?php

use Client\Helpers\CSRF;
?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $view->callHeader("basic") ?>
    <title>Produtos - Atualizar Produto</title>
</head>

<body class="bg-body-tertiary">
    <?php $view->component("navbar") ?>

    <main class="container">
        <div class="mx-2">
            <h1>Atualizar Produto</h1>

            <div class="card mb-4">
                <div class="card-header">
                    <span id="title-card-product">Atualizar produto</span>
                </div>
                <div class="card-body">
                    <p class="fw-bold">Os campos que tem <span class="text-danger">*</span> são obrigatórios.</p>
                    <form action="<?php echo $_ENV['APP_URL'] . "produtos/update/" . $data['product']['id'] ?>" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo CSRF::generateCSRFToken("form_update_product") ?>">

                        <input type="hidden" name="id" value="<?php echo $data['product']['id'] ?>" class="form-control">

                        <div class="mb-3">
                            <label for="nameProduct"><span class="text-danger">*</span>Nome:</label>
                            <input type="text" name="name" id="nameProduct" class="form-control <?php echo isset($_SESSION['update_product_response_invalid_form']['errors']['name']) ? 'is-invalid' : '' ?>" value="<?php echo $_SESSION['update_product_response_invalid_form']['form']['name'] ?? $data['product']['name'] ?>" placeholder="Insira o nome do produto">
                            <div class="invalid-feedback">
                                <?php echo $_SESSION['update_product_response_invalid_form']['errors']['name'] ?? "" ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="quantityProduct"><span class="text-danger">*</span>Quantidade (estoque):</label>
                            <input type="number" name="quantity" id="quantityProduct" class="form-control <?php echo isset($_SESSION['update_product_response_invalid_form']['errors']['quantity']) ? 'is-invalid' : '' ?>" value="<?php echo $_SESSION['update_product_response_invalid_form']['form']['quantity'] ?? $data['product']['quantity'] ?>" placeholder="Insira a quantidade do produto em estoque">
                            <div class="invalid-feedback">
                                <?php echo $_SESSION['update_product_response_invalid_form']['errors']['quantity'] ?? "" ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="codeProduct">Código do produto:</label>
                            <input type="text" name="code" id="codeProduct" class="form-control <?php echo isset($_SESSION['update_product_response_invalid_form']['errors']['code']) ? 'is-invalid' : '' ?>" value="<?php echo $_SESSION['update_product_response_invalid_form']['form']['code'] ?? $data['product']['code'] ?>" placeholder="Insira o código do produto">
                            <div class="invalid-feedback">
                                <?php echo $_SESSION['update_product_response_invalid_form']['errors']['code'] ?? "" ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="descriptionProduct">Descrição/Observação</label>
                            <textarea name="description" id="descriptionProduct" class="form-control  <?php echo isset($_SESSION['update_product_response_invalid_form']['errors']['description']) ? 'is-invalid' : '' ?>" placeholder="Insira uma descrição ou observação do produto" rows="3"><?php echo $_SESSION['update_product_response_invalid_form']['form']['description'] ?? $data['product']['description'] ?></textarea>
                            <div class="invalid-feedback">
                                <?php echo $_SESSION['update_product_response_invalid_form']['errors']['description'] ?? "" ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <button type="submit" id="btnUpdate" class="btn btn-primary w-100">Salvar alterações</button>
                        </div>
                    </form>

                    <p class="text-danger mt-1 text-center">
                        <?php echo $_SESSION['update_product_response_incorrect_form'] ?? "" ?>
                    </p>
                </div>
            </div>
        </div>
    </main>

    <?php
    unset($_SESSION['update_product_response_invalid_form']);
    unset($_SESSION['update_product_response_incorrect_form']);
    unset($_SESSION['update_product_response_success']);
    ?>

    <?php $view->component("bootstrapjs") ?>
    <script src="<?php echo $view->linkAsset("js/produtos/update.js") ?>"></script>
</body>

</html>