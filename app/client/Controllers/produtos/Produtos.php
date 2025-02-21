<?php

namespace Client\Controllers\produtos;

use Client\Controllers\Services\Controller;
use Client\Controllers\Services\UniqueRuleRakit;
use Client\Helpers\CSRF;
use Client\Helpers\ErrorPage;
use Client\Middlewares\VerifyLogin;
use Client\Models\Product;
use Rakit\Validation\Validator;

final class Produtos extends Controller
{
    public function __construct()
    {
        $url = $_ENV['APP_URL'] . filter_input(INPUT_GET, "url", FILTER_SANITIZE_URL);
        VerifyLogin::redirect($url);
    }

    /**
     * Função correspondente a produtos/index ou produtos/{id}.
     *
     * @param string|null $parameter É o ID que pode vir na URL.
     * @return void
     */
    public function index(string|null $parameter)
    {
        // Se um parâmetro (id) for passado, apresentar o produto específico.
        if ($parameter) {
            // !!
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
    public function create(string|null $parameter)
    {
        // Se for POST, é criar um produto.
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if (isset($dataForm['csrf_token']) && CSRF::validateCSRFToken("form_create_product", $dataForm['csrf_token'] ?? [])) {
                $validator = new Validator();

                // Adicionar a regra Unique às opções.
                $validator->addValidator("unique", new UniqueRuleRakit);

                // Mudar linguagem das mensagens para português.
                $validator->setMessages(require "lang/pt.php");

                // Criar a validação.
                $validation = $validator->make($dataForm, [
                    "name" => "required",
                    "quantity" => "required|integer|min:0",
                    "code" => "required|unique:products,code",
                ]);

                // Mudar o nome dos campos.
                $validation->setAliases([
                    "name" => "nome",
                    "quantity" => "quantidade",
                    "code" => "código",
                ]);

                // Executar a validação.
                $validation->validate();

                if (!$validation->fails()) {
                    // Instanciar a Model de produtos.
                    $product = new Product;

                    $dataProduct = [
                        "user_id" => $_SESSION['user_logged']['id'],
                        "name" => $dataForm['name'],
                        "quantity" => $dataForm['quantity'],
                        "code" => $dataForm['code'],
                        "description" => $dataForm['description'],
                    ];

                    // Criar o produto.
                    $response = $product->create($dataProduct);

                    // Se houver resposta, a criação deu certo.
                    if ($response) {
                        // Criar resposta de sucesso.
                        $_SESSION['create_product_response_success'] = "Produto criado com sucesso!";

                        // Redirecionar para a página de criar produto.
                        header("Location: {$_ENV['APP_URL']}produtos/create");
                    } else {
                        // Caso não houver resposta, houve algum erro
                        $_SESSION['create_product_response_incorrect_form'] = "Erro na criação de novo produto, por favor, tente novamente maais tarde.";
                        $_SESSION['create_product_response_invalid_form']['form'] = $dataForm;

                        // Redirecionar novamente à página criar produto.
                        header("Location: {$_ENV['APP_URL']}produtos/create");
                    }
                } else {
                    // Se a validação falhou, crie uma Sessão com as informções de formulário e erros.
                    $_SESSION['create_product_response_invalid_form'] = ["form" => $dataForm, "errors" => $validation->errors()->firstOfAll()];

                    // Redirecionar novamente à página criar produto.
                    header("Location: {$_ENV['APP_URL']}produtos/create");
                }
            } else {
                // Token CSRF inválido.
                $_SESSION['create_product_response_incorrect_form'] = "Erro de segurança do formulário, por favor, recarregue a página e tente novamente";
                $_SESSION['create_product_response_invalid_form']['form'] = $dataForm;

                // Redirecionar novamente à página criar produto.
                header("Location: {$_ENV['APP_URL']}produtos/create");
            }
        } else if ($_SERVER['REQUEST_METHOD'] == "GET") {
            // Se for GET, apresentar a view de criar produto.
            $this->view("produtos.create", null);
        } else {
            // Redirecionar para página de erro 404.
            ErrorPage::error404("Página não encontrada");
        }
    }

    public function update(string|null $parameter)
    {
        echo "Atualizar produto específico";
    }

    public function delete(string|null $parameter)
    {
        echo "Deletar produto específico";
    }
}
