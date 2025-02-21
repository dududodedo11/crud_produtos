<?php
// Essa view corresponde à página produtos/create do site.

use Client\Helpers\CSRF;

?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $view->callHeader("basic") ?>
    <title>Produtos - Novo Produto</title>
</head>

<body class="bg-body-tertiary">
    <?php $view->component("navbar") ?>

    <main class="container">
        <div class="mx-2">
            <h1>Criar novo Produto</h1>

            <div class="card mb-4">
                <div class="card-header">
                    <span id="title-card-product">Novo produto</span>
                </div>
                <div class="card-body">
                    <p class="fw-bold">Os campos que tem <span class="text-danger">*</span> são obrigatórios.</p>
                    <form action="" method="post">
                        <input type="hidden" name="csrf_token" value="<?php echo CSRF::generateCSRFToken("form_create_product") ?>">

                        <div class="">
                            <div class="mb-3">
                                <label for="nameProduct"><span class="text-danger">*</span>Nome:</label>
                                <input type="text" name="name" id="nameProduct" class="form-control <?php echo isset($_SESSION['create_product_response_invalid_form']['errors']['name']) ? 'is-invalid' : '' ?>" placeholder="Insira o nome do produto" value="<?php echo $_SESSION['create_product_response_invalid_form']['form']['name'] ?? "" ?>">
                                <div class="invalid-feedback">
                                    <?php echo $_SESSION['create_product_response_invalid_form']['errors']['name'] ?? "" ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="quantityProduct"><span class="text-danger">*</span>Quantidade (estoque):</label>
                                <input type="number" name="quantity" id="quantityProduct" class="form-control <?php echo isset($_SESSION['create_product_response_invalid_form']['errors']['quantity']) ? 'is-invalid' : '' ?>" placeholder="Insira a quantidade do produto em estoque" value="<?php echo $_SESSION['create_product_response_invalid_form']['form']['quantity'] ?? "" ?>">
                                <div class="invalid-feedback">
                                    <?php echo $_SESSION['create_product_response_invalid_form']['errors']['quantity'] ?? "" ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="codeProduct">Código do produto:</label>
                                <input type="text" name="code" id="codeProduct" class="form-control <?php echo isset($_SESSION['create_product_response_invalid_form']['errors']['code']) ? 'is-invalid' : '' ?>" placeholder="Insira o código do produto" value="<?php echo $_SESSION['create_product_response_invalid_form']['form']['code'] ?? "" ?>">
                                <div class="invalid-feedback">
                                    <?php echo $_SESSION['create_product_response_invalid_form']['errors']['code'] ?? "" ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="descriptionProduct">Descrição/Observação:</label>
                                <textarea name="description" id="descriptionProduct" class="form-control <?php echo isset($_SESSION['create_product_response_invalid_form']['errors']['description']) ? 'is-invalid' : '' ?>" placeholder="Insira uma descrição/observação do produto" rows="3"><?php echo $_SESSION['create_product_response_invalid_form']['form']['description'] ?? "" ?></textarea>
                                <div class="invalid-feedback">
                                    <?php echo $_SESSION['create_product_response_invalid_form']['errors']['description'] ?? "" ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary w-100">Criar produto</button>
                            </div>
                        </div>
                    </form>

                    <p class="text-danger mt-1 text-center">
                        <?php echo $_SESSION['create_product_response_incorrect_form'] ?? "" ?>
                    </p>

                    <p class="text-success mt-1 text-center">
                        <?php echo $_SESSION['create_product_response_success'] ?? "" ?>
                    </p>
                </div>
            </div>
        </div>
    </main>

    <?php
    unset($_SESSION['create_product_response_invalid_form']);
    unset($_SESSION['create_product_response_incorrect_form']);
    unset($_SESSION['create_product_response_success']);
    ?>

    <?php $view->component("bootstrapjs") ?>
    <script src="<?php echo $view->linkAsset("js/produtos/create.js") ?>"></script>
</body>

</html>