<?php
// View conrespondente à página produto/{id}
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
                <span class=""><?php echo $data['product']['name'] ?></span>
                <button class="float-end btn btn-info">Atualizar</button>
            </div>
            <div class="card-body">
                <form action="">
                    <div class="mb-3">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis hic quis accusamus voluptatem, repudiandae nostrum modi necessitatibus incidunt quam in maiores dolore a rem quasi debitis veritatis, natus, dolorem porro.</p>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php $view->component("bootstrapjs") ?>
</body>

</html>