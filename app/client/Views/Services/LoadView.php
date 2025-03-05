<?php

namespace Client\Views\Services;

use Client\Helpers\ErrorPage;
use Client\Helpers\GenerateLog;
use Client\Views\Services\View;

/**
 * Classe que chama as views e repassa os dados da controller.
 */
class LoadView {
    /** Recebe o caminho/path da view chamada. @var string */
    private string $pathView;

    /** Recebe o nome da view chamada. @var string */
    private string $nameView;

    /** Recebe os dados que serão repassados à view. @var array|string|null */
    private array|string|null $data;

    /**
     * Define os atributos da classe com os dados recebidos e define o path completo da view.
     *
     * @param string $nameView Recebe o nome da view desejada.
     * @param array|string|null $data Recebe os dados que serão enviados à view.
     */
    public function __construct(string $nameView, array|string|null $data) {
        // Faz a definição de atributos com os dados recebidos da controller.
        $this->nameView = $nameView;
        $this->data = $data;

        // Troca os pontos (".") do nome por barras ("/");
        $this->nameView = str_replace(".", "/", $this->nameView);

        // Define o path completo da view desejada.
        $this->pathView = "app/client/Views/{$this->nameView}.php";
    }

    /**
     * Inclui a view desejada na página.
     * - Também checa se a view existe no path.
     *
     * @return void
     */
    public function loadView() {
        // Se o caminho/view existir, inclua na página.
        if(file_exists($this->pathView)) {
            // Define a variável que será usada para acessar os dados na view (fiz isso para não precisar usar o "$this->" dentro de uma view).
            $data = $this->data;

            // Instancia a classe View para poder usar seus métodos dentro da view em si.
            $view = new View;

            // Incluir a view dentro da página/requisição.
            include $this->pathView;
        } else {
            // Caso o caminho/view não existir, gerar um log bem sério, porque a página em si existe, mas o caminho está incorreto.
            GenerateLog::generateLog("critical", "View não encontrada", ['nameView' => $this->nameView, 'pathView' => $this->pathView]);

            // Redirecionar para a página de erro 500.
            ErrorPage::error500("Erro interno do servidor");
        }
    }
}