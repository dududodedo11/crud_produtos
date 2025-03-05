<?php

namespace Client\Controllers\Services;

use Client\Views\Services\LoadView;

/**
 * Classe abstrata para guardar funções que serão usadas quase 100% das vezes por todas as controllers.
 * Todas as controllers herdam essa classe.
 */
abstract class Controller
{
    /**
     * Função para carregar uma view específica.
     * - Ele vai procurar a partir de "app/client/views/"
     *
     * @param string $nameView Recebe o caminho da view (insira pontos em vez de barras, e não insira ".php").
     * @param array|string|null $data Array de dados / String que será disponibilizado na view (caso não haja nenhum dado, é necessário espcificar inserindo null).
     * @return void
     */
    public function view(string $nameView, array|string|null $data)
    {
        // Instancia a classe que irá carregar a view.
        $view = new LoadView($nameView, $data);

        // Carrega a view.
        $view->loadView();
    }
}