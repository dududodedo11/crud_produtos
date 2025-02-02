<?php

namespace Client\Views\Services;

use Client\Helpers\GenerateLog;

class LoadView {
    private string $pathView;
    private string $nameView;
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
        $this->pathView = "app/client/Views/$this->nameView.php";
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

            // Incluir a view dentro da página/requisição.
            include $this->pathView;
        } else {
            // Caso o caminho/view não existir, gerar um log bem sério, porque a página em si existe, mas o caminho está incorreto.
            GenerateLog::generateLog("critical", "View não encontrada", ['nameView' => $this->nameView, 'pathView' => $this->pathView]);
        }
    }
}