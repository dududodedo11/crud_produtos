<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $view->callHeader("basic") ?>
    <title>Erro 500</title>
</head>

<body>
    <?php $view->component("navbar") ?>

    <h1 class="text-danger">Erro 500 - Erro Interno do Servidor</h1>

    <?php $view->component("bootstrapjs") ?>
</body>

</html>