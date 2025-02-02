<?php

namespace Client\Controllers\produtos;

use Client\Controllers\Services\Controller;
use Client\Models\Product;

final class Produtos extends Controller {
    public function index(string|null $parameter) {
        if($parameter) {

        } else {
            $productModel = new Product;
            $products = $productModel->all();
    
            $this->view("produtos.index", ['products' => $products]);
        }

    }

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