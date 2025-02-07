<?php

namespace Client\Views\Services;

/**
 * Classe usada para criar funcões muito usadas na maioria das views.
 */
class View {
    /**
     * Inclui um cabeçalho em uma parte da página.
     *
     * @param string $header Recebe o nome do cabeçalho desejado.
     * @return void
     */
    public function callHeader(string $header):void {
        $pathHeader = "app/client/Views/partials/headers/{$header}.php";

        include $pathHeader;
    }

    /**
     * Inclui um componente em uma parte da página.
     *
     * @param string $component Recebe o nome do componente desejado.
     * @return void
     */
    public function component(string $component):void {
        $pathComponent = "app/client/Views/partials/components/{$component}.php";

        include $pathComponent;
    }

    /**
     * Usada para obter o link de uma página.
     *
     * @param string $page Recebe o caminho/URL da página.
     * @return string Retorna o link absoluto.
     */
    public function linkPage(string $page):string {
        $urlPage = $_ENV['APP_URL'] . $page;

        return $urlPage;
    }
}