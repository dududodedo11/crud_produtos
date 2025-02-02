<?php

namespace Client\Controllers\produtos;

use Client\Controllers\Services\Controller;
use Client\Models\Product;

final class Produtos extends Controller {
    /**
     * Função correspondente a produtos/index ou produtos/{id}.
     *
     * @param string|null $parameter É o ID que pode vir na URL.
     * @return void
     */
    public function index(string|null $parameter) {
        // Se um parâmetro (id) for passado, apresentar o produto específico.
        if($parameter) {

        } else {
            $productModel = new Product;
            $products = $productModel->all();
    
            // Carregar a view de produtos/index com a lista de produtos.
            $this->view("produtos.index", ['products' => $products]);
        }

    }

    /**
     * Função correspondente a produtos/create.
     *
     * @param string|null $parameter É o ID que pode vir na URL.
     * @return void
     */
    public function create(string|null $parameter) {
        echo "Criar produto";
    }

    public function update(string|null $parameter) {
        echo "Atualizar produto específico";
    }

    public function delete(string|null $parameter) {
        echo "Deletar produto específico";
    }
}