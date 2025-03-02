<?php

// Usar os métodos padrões da View.
use Client\Views\Services\View;

$view = new View;

?>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <div class="navbar-brand">
            <img src="<?php echo $_ENV['APP_LOGO_PATH'] ?>" alt="Logo do site" width="35" height="35">
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $view->linkPage("home") ?>">Página Inicial</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo $view->linkPage("produtos") ?>">Produtos</a>
                </li>
                <?php
                if (!isset($_SESSION['user_logged'])) {
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $view->linkPage("cadastrar-usuario") ?>">Cadastrar Usuário</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $view->linkPage("login") ?>">Login</a>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <form action="<?php echo $_ENV['APP_URL'] ?>login/delete" method="POST" class="float-end border border-1 rounded d-inline">
            <button type="submit" class="btn text-white d-inline" style="font-size: 17px;"><i class="fa-solid fa-arrow-left"></i> Sair</button>
        </form>
    </div>
</nav>