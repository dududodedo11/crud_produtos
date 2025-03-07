<?php

// Usar os métodos padrões da View.
use Client\Views\Services\View;

$view = new View;

?>

<link rel="shortcut icon" href="<?php echo $view->linkAsset("img/logo.png") ?>" type="image/x-icon">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script>
    const APP_URL = "<?php echo $_ENV['APP_URL'] ?>";
</script>