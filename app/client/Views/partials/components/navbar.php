<?php

// Usar os métodos padrões da View.
use Client\Views\Services\View;
$view = new View;

?>

<ul>
    <li><a href="<?php echo $view->linkPage("home") ?>">Página Inicial</a></li>
    <li><a href="<?php echo $view->linkPage("cadastrar-usuario") ?>">Cadastrar Usuário</a></li>
    <li><a href="<?php echo $view->linkPage("produtos") ?>">Produtos</a></li>
</ul>