<?php

namespace Client\Controllers\Services;

use Client\Models\Services\UniqueRule;
use Rakit\Validation\Rule;

/**
 * Classe em que cria a validação unique no rakit Validation.
 */
class UniqueRuleRakit extends Rule {
    /**
     * Guarda a mensagem padrão a ser usada quando o valor já estiver sido usado.
     *
     * @var string
     */
    protected $message = "O :attribute :value já está em uso.";

    // Atributo do Rakit validation para a verificação unique.
    protected $fillableParams = ['table', 'column'];

    /**
     * Função para checar se o valor já foi usado.
     *
     * @param [type] $value Guarda o valor a ser consultado.
     * @return boolean Retorna: Existe = false, Não existe = true.
     */
    public function check($value):bool {
        // Esses códigos abaixo são do Rakit Validation para receber os parâmetros da verificação unique.
        $this->requireParameters(['table', 'column']);

        $column = $this->parameter('column');
        $table = $this->parameter('table');

        // Instanciar a Service Model que checa o valor no DB.
        $validateUniqueRule = new UniqueRule;

        // Retornar true para não usada e false para usada.
        return $validateUniqueRule->getRecord($table, $column, $value);
    }
}