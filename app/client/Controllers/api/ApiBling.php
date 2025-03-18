<?php

namespace Client\Controllers\api;

use Client\Helpers\ReceiveUrlParameters;
use Client\Middlewares\VerifyLogin;

final class ApiBling
{
    public function __construct()
    {
        $userlogged = VerifyLogin::verify();
        if (!$userlogged) {
            http_response_code(401);
            echo json_encode(["error" => "Usuário não logado no sistema"]);
            exit;
        }

        if (!isset($_SESSION['bling_auth'])) {
            http_response_code(401);
            echo json_encode(["error" => "Usuário não authenticado na API Bling"]);
            exit;
        }
    }

    public function index()
    {
        echo "index";
    }

    public function getOrders()
    {
        $url_api = "https://api.bling.com.br/Api/v3/pedidos/vendas?limite=25";

        $idLoja = ReceiveUrlParameters::receiveUrlParameters("idLoja") ?? "not_found";
        $idSituacao = ReceiveUrlParameters::receiveUrlParameters("idSituacao") ?? "not_found";
        $pagina = ReceiveUrlParameters::receiveUrlParameters("pagina") ?? "not_found";

        if ($idLoja != "not_found") {
            $url_api .= "&idLoja={$idLoja}";
        }

        if ($idSituacao != "not_found") {
            $url_api .= "&idsSituacoes[]={$idSituacao}";
        }

        if ($pagina != "not_found") {
            $url_api .= "&pagina={$pagina}";
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url_api,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Authorization: Bearer ' . $_SESSION['bling_auth']['access_token'],
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $result = json_decode($response, true);

        $data = [];

        foreach ($result['data'] as $pedido) {
            $data[] = [
                "id" => $pedido['id'],
                "numero" => $pedido['numero'],
                "data" => $pedido['data'],
                "valor" => $pedido['total'],
                "cliente" => $pedido['contato']['nome'],
                "situacao" => $pedido['situacao']['id'],
                "loja" => $pedido['loja']['id'],
            ];
        }

        header("Content-Type: application/json");

        echo json_encode($data);
    }

    public function getProducts()
    {
        $url_api = "https://api.bling.com.br/Api/v3/pedidos/vendas/";

        $idOrder = ReceiveUrlParameters::receiveUrlParameters("idOrder") ?? "not_found";

        if ($idOrder == "not_found") {
            header("Content-Type: application/json");
            echo json_encode(["error" => "ID do pedido não informado"]);
        } else {
            $url_api .= $idOrder;
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url_api,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Authorization: Bearer ' . $_SESSION['bling_auth']['access_token'],
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $result = json_decode($response, true);
        $pedido = $result['data'];

        $data = [
            "id" => $pedido['id'],
            "numero" => $pedido['numero'],
            "data" => $pedido['data'],
            "cliente" => $pedido['contato']['nome'],
            "situacao" => $pedido['situacao']['id'],
            "loja" => $pedido['loja']['id'],
            "produtos" => [],
        ];

        foreach ($pedido['itens'] as $produto) {
            $data["produtos"][] = [
                "id" => $produto['id'],
                "codigo" => $produto['codigo'],
                "quantidade" => $produto['quantidade'],
                "unidade" =>  $produto['unidade'],
                "nome" => $produto['descricao'],
            ];
        }

        header("Content-Type: application/json");

        echo json_encode($data);
    }
}
