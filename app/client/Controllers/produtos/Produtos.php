<?php

namespace Client\Controllers\produtos;

use Client\Controllers\Services\Controller;
use Client\Controllers\Services\UniqueRuleRakit;
use Client\Helpers\CSRF;
use Client\Helpers\ErrorPage;
use Client\Helpers\GenerateLog;
use Client\Helpers\ReceiveUrlParameters;
use Client\Middlewares\VerifyLogin;
use Client\Models\Product;
use Rakit\Validation\Validator;

final class Produtos extends Controller
{
    public function __construct()
    {
        // Fazer a verificação de login e caso não houver, redirecionar para a página de login.
        $url = $_ENV['APP_URL'] . filter_input(INPUT_GET, "url", FILTER_SANITIZE_URL);
        VerifyLogin::redirect($url);
    }

    /**
     * Função correspondente a produtos/index ou produtos/{id}.
     * Apresenta a lista de produtos ou um produto específico.
     *
     * @param string|null $parameter É o ID que pode vir na URL.
     * @return void
     */
    public function index(string|null $parameter)
    {
        // Se um parâmetro (id) for passado, apresentar o produto específico.
        if ($parameter) {
            $parameter = filter_var($parameter, FILTER_SANITIZE_NUMBER_INT);

            $productModel = new Product;
            $product = $productModel->getById($parameter);

            if ($product) {
                // Carregar a view de produtos/index com o produto específico.
                $this->view("produtos.product", ['product' => $product]);
            } else {
                GenerateLog::generateLog("notice", "Sem resposta da Model para buscar produto em produtos/{$parameter}", ["product_id" => $parameter, "uri" => $_SERVER['REQUEST_URI'], "user_id" => $_SESSION['user_logged']['user_id']]);

                // Redirecionar para página de erro 404.
                ErrorPage::error404("Página não encontrada");
            }
        } else {
            $page = ReceiveUrlParameters::receiveUrlParameters()["page"] ?? 1;
            $limit = 12;

            $productModel = new Product;
            $products = $productModel->paginate($page, $limit);

            $totalProducts = count($productModel->all());
            $totalPages = ceil($totalProducts / $limit);

            // Carregar a view de produtos/index com a lista de produtos.
            $this->view(
                "produtos.index",
                [
                    'products' => $products,
                    'totalPages' => $totalPages,
                    'currentPage' => $page,
                    'totalProducts' => $totalProducts,
                ]
            );
        }
    }

    /**
     * Função correspondente a produtos/create.
     * Apresenta a view de criar produto ou cria um produto, dependendo do método.
     *
     * @param string|null $parameter É o ID que pode vir na URL.
     * @return void
     */
    public function create(string|null $parameter)
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            // Se for POST, é criar para criar um produto.

            // Receber e limpar os dados do formulário.
            $dataForm = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            // Verificar se o token CSRF é válido.
            if (isset($dataForm['csrf_token']) && CSRF::validateCSRFToken("form_create_product", $dataForm['csrf_token'] ?? [])) {
                // Instanciar a classe de validação.
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

                    // Criar um array de dados para enviar à Model.
                    $dataProduct = [
                        "user_id" => $_SESSION['user_logged']['id'],
                        "name" => $dataForm['name'],
                        "quantity" => $dataForm['quantity'],
                        "code" => $dataForm['code'],
                        "description" => $dataForm['description'],
                    ];

                    // Criar o produto.
                    $response = $product->create($dataProduct);

                    if ($response) {
                        // Se houver resposta, a criação deu certo.

                        // Criar resposta de sucesso.
                        $_SESSION['create_product_response_success'] = "Produto criado com sucesso!";

                        // Redirecionar para a página de criar produto.
                        header("Location: {$_ENV['APP_URL']}produtos/create");
                    } else {
                        // Caso não houver resposta, houve algum erro.

                        // Criar resposta de erro + fomulário.
                        $_SESSION['create_product_response_incorrect_form'] = "Erro na criação de novo produto, por favor, tente novamente maais tarde.";
                        $_SESSION['create_product_response_invalid_form']['form'] = $dataForm;

                        GenerateLog::generateLog("notice", "Erro na criação de novo produto (Model sem resposta)", ['form' => $dataForm, 'user_id' => $_SESSION['user_logged']['id'], 'uri' => $_SERVER['REQUEST_URI']]);

                        // Redirecionar novamente à página criar produto.
                        header("Location: {$_ENV['APP_URL']}produtos/create");
                    }
                } else {
                    // Validação falhou.

                    // Retornar uma Sessão com o formulário + erros.
                    $_SESSION['create_product_response_invalid_form'] = ["form" => $dataForm, "errors" => $validation->errors()->firstOfAll()];

                    // Gerar log "debug".
                    GenerateLog::generateLog("debug", "Validação Rakit de formulário de criação de produto falhou", ["form" => $dataForm, "errors" => $validation->errors()->firstOfAll(), "user-id" => $_SESSION['user_logged']['id']]);

                    // Redirecionar novamente à página criar produto.
                    header("Location: {$_ENV['APP_URL']}produtos/create");
                }
            } else {
                // Token CSRF inválido.

                // Retornar resposta de erro + formulário.
                $_SESSION['create_product_response_incorrect_form'] = "Erro de segurança do formulário, por favor, recarregue a página e tente novamente";
                $_SESSION['create_product_response_invalid_form']['form'] = $dataForm;

                // Gerar log "info".
                GenerateLog::generateLog("info", "Token CSRF inválido em produtos/create", ["form" => $dataForm, "user-id" => $_SESSION['user_logged']['id']]);

                // Redirecionar novamente à página criar produto.
                header("Location: {$_ENV['APP_URL']}produtos/create");
            }
        } else if ($_SERVER['REQUEST_METHOD'] == "GET") {
            // Se for GET, apresentar a view de criar produto.
            $this->view("produtos.create", null);
        } else {
            // Método não suportado.

            // Gerar log "info".
            GenerateLog::generateLog("info", "Método não suportado em produtos/create", ["method" => $_SERVER['REQUEST_METHOD'], "user_id" => $_SESSION['user_logged']['id']]);

            // Redirecionar para página de erro 404.
            ErrorPage::error404("Página não encontrada");
        }
    }

    /**
     * Função correspondente a produtos/update.
     * Apresenta a view de atualizar produto ou realiza a atualização, dependendo do método.
     *
     * @param string|null $parameter É o ID que pode vir na URL.
     * @return void
     */
    public function update(string|null $parameter)
    {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            // Receber e limpar o ID do produto.
            $productId = filter_var($parameter, FILTER_SANITIZE_NUMBER_INT);

            if (!empty($productId)) {
                // Caso o Id não esteja vazio, buscar o produto.

                // Instanciar a Model de produtos.
                $product = new Product;

                // Buscar o produto pelo ID.
                $productData = $product->getById($productId);

                if ($productData) {
                    // Se o produto foi encontrado, apresentar a view de atualizar produto.
                    $this->view("produtos.update", ['product' => $productData]);
                } else {
                    // Produto não encontrado.

                    // Gerar log de "notice".
                    GenerateLog::generateLog("notice", "Sem resposta da Model para buscar produto em produtos/update/{$parameter}", ["product_id" => $productId, "uri" => $_SERVER['REQUEST_URI'], "user_id" => $_SESSION['user_logged']['user_id']]);

                    // Redirecionar para a página de erro 404.
                    ErrorPage::error404("Página não encontrada");
                }
            } else {
                ErrorPage::error404("Página não encontrada");
            }
        } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
            // Receber os dados do formulário.
            $dataForm = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            // Verificar se o token CSRF é válido.
            if (isset($dataForm['csrf_token']) && CSRF::validateCSRFToken("form_update_product", $dataForm['csrf_token'] ?? [])) {
                // Token CSRF válido.

                // Instanciar a classe de validação.
                $validator = new Validator();

                // Adicionar a regra Unique às opções.
                $validator->addValidator("unique", new UniqueRuleRakit);

                // Mudar linguagem das mensagens para português.
                $validator->setMessages(require "lang/pt.php");

                // Criar a validação.
                $validation = $validator->make($dataForm, [
                    "name" => "required",
                    "quantity" => "required|integer|min:0",
                    "code" => "required|unique:products,code,{$dataForm['id']}",
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
                    // A validação NÃO falhou.

                    // Instanciar a Model de produto.
                    $product = new Product;

                    // Atualizar o produto.
                    $response = $product->update($dataForm);

                    if ($response) {
                        // Houve resposta da Model, o produto foi atualizado.

                        // Retornar uma Sessão com mensagem de sucesso.
                        $_SESSION['update_product_response_success'] = "Produto atualizado com sucesso!";

                        // Redirecionar para a página de visuzalizar produto.
                        header("Location: {$_ENV['APP_URL']}produtos/index/{$dataForm['id']}");
                    } else {
                        // Não houve resposta da Model.

                        // Retornar uma Sessão com formulário + mensagem de erro.
                        $_SESSION['update_product_response_incorrect_form'] = "Erro na atualização do produto, por favor, tente novamente maais tarde.";
                        $_SESSION['update_product_response_invalid_form']['form'] = $dataForm;

                        // Gerar log "notice".
                        GenerateLog::generateLog("notice", "Sem resposta da Model para atualização de produtos em produtos/update/{$parameter}", ["form" => $dataForm, "uri" => $_SERVER['REQUEST_URI'], "user_id" => $_SESSION['user_logged']['user_id']]);

                        // Redirecionar novamente à página de atualizar produto.
                        header("Location: {$_ENV['APP_URL']}produtos/update/{$dataForm['id']}");
                    }
                } else {
                    // Validação falhou.

                    // Retornar uma Sessão com as informções de formulário e erros.
                    $_SESSION['update_product_response_invalid_form'] = ["form" => $dataForm, "errors" => $validation->errors()->firstOfAll()];

                    // Gerar Log "debug".
                    GenerateLog::generateLog("debug", "Validação Rakit em produtos/update/{$parameter} falhou", ["form" => $dataForm, "uri" => $_SERVER['REQUEST_URI'], "user_id" => $_SESSION['user_logged']['user_id'], "errors" => $validation->errors()->firstOfAll()]);

                    // Redirecionar novamente à página atualizar produto.
                    header("Location: {$_ENV['APP_URL']}produtos/update/{$dataForm['id']}");
                }
            } else {
                // Token CSRF inválido.

                // Retornar a mensagem de erro + o formulário.
                $_SESSION['update_product_response_incorrect_form'] = "Erro de segurança do formulário, por favor, recarregue a página e tente novamente";
                $_SESSION['update_product_response_invalid_form']['form'] = $dataForm;

                // Gerar Log "info".
                GenerateLog::generateLog("info", "Acesso ao produtos/update/{$parameter} com Token CSRF inválido", ["csrf_token" => $dataForm['csrf_token'] ?? null, "uri" => $_SERVER['REQUEST_URI'], "user_id" => $_SESSION['user_logged']['user_id']]);

                // Redirecionar novamente à página criar atualizar produto.
                header("Location: {$_ENV['APP_URL']}produtos/update/{$dataForm['id']}");
            }
        } else {
            // Método não suportado.

            // Gerar Log "info".
            GenerateLog::generateLog("info", "Acesso ao produtos/update/{$parameter} com método não suportado", ["method" => $_SERVER['REQUEST_METHOD'], "uri" => $_SERVER['REQUEST_URI'], "user_id" => $_SESSION['user_logged']['user_id']]);

            // Redirecionar para página de erro 404.
            ErrorPage::error404("Página não encontrada");
        }
    }

    /**
     * Função correspondente a produtos/delete.
     * Só pode ser acessado via POST, pois não é uma página de visualização.
     *
     * @param string|null $parameter É o ID que pode vir na URL.
     * @return void
     */
    public function delete(string|null $parameter)
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            // Receber os dados do formulário (CSRF e ID a ser deletado).
            $dataForm = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            if (isset($dataForm['csrf_token']) && CSRF::validateCSRFToken("form_delete_product", $dataForm['csrf_token'] ?? [])) {
                // Instanciar a classe de validação.
                $validator = new Validator();

                // Adicionar a regra Unique às opções.
                $validator->addValidator("unique", new UniqueRuleRakit);

                // Mudar linguagem das mensagens para português.
                $validator->setMessages(require "lang/pt.php");

                // Criar a validação.
                $validation = $validator->make($dataForm, [
                    "product_id" => "required|integer|min:1",
                ]);

                // Executar a validação.
                $validation->validate();

                if (!$validation->fails()) {
                    // Validação não falhou.

                    // Instanciar a Model de produtos.
                    $product = new Product;

                    // Deletar o produto.
                    $response = $product->delete($dataForm['product_id']);

                    if ($response) {
                        // Produto deletado com sucesso.

                        // Criar resposta de sucesso.
                        $_SESSION['delete_product_response_success'] = "Produto deletado com sucesso!";

                        // Redirecionar para a página de produtos.
                        header("Location: {$_ENV['APP_URL']}produtos");
                    } else {
                        // Não houve resposta da Model: Falha no DELETE.

                        // Gerar Log "notice".
                        GenerateLog::generateLog("notice", "Sem resposta da Model para deletar produto em produtos/delete/{$parameter}", ["form" => $dataForm, "uri" => $_SERVER['REQUEST_URI'], "user_id" => $_SESSION['user_logged']['user_id']]);

                        // Redirecionar para página de erro 500.
                        ErrorPage::error500();
                    }
                } else {
                    // Validação falhou.

                    // Gerar um Log "debug".
                    GenerateLog::generateLog("debug", "Validação Rakit em produtos/delete falhou", ["form" => $dataForm, "uri" => $_SERVER['REQUEST_URI'], "user_id" => $_SESSION['user_logged']['user_id']]);

                    // Redirecionar para página de erro 500.
                    ErrorPage::error500();
                }
            } else {
                // Token CSRF inválido.

                // Gerar Log "info".
                GenerateLog::generateLog("info", "Acesso ao produtos/delete com Token CSRF inválido", ["csrf_token" => $dataForm['csrf_token'] ?? null, "uri" => $_SERVER['REQUEST_URI'], "user_id" => $_SESSION['user_logged']['user_id']]);

                // Redirecionar para página de erro 500.
                ErrorPage::error500();
            }
        } else {
            // Método não suportado.

            // Gerar Log "info".
            GenerateLog::generateLog("info", "Acesso ao produtos/delete com método não suportado", ["method" => $_SERVER['REQUEST_METHOD'], "uri" => $_SERVER['REQUEST_URI'], "user_id" => $_SESSION['user_logged']['user_id']]);

            // Redirecionar para página de erro 404.
            ErrorPage::error404("Página não encontrada");
        }
    }
}
