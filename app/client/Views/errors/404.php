<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $view->callHeader("basic") ?>
    <title>Erro 404</title>
</head>

<body>
    <?php $view->component("navbar") ?>

    <h1 class="text-danger">Erro 404 - Página não encontrada</h1>
    <p>Detalhes do erro: <?php echo $data['message'] ?? "A página não existe" ?></p>


    <?php $view->component("bootstrapjs") ?>
</body>

</html>