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

    /**
     * Guarda o array de parâmetros da regra Unique.
     *
     * @var array
     */
    protected $fillableParams = ['table', 'column', 'except_id'];

    /**
     * Função para checar se o valor já foi usado.
     *
     * @param [type] $value Guarda o valor a ser consultado.
     * @return boolean Retorna: Existe = false, Não existe = true.
     */
    public function check($value):bool {
        $this->requireParameters(['table', 'column']);

        $column = $this->parameter('column');
        $table = $this->parameter('table');
        $exceptId = $this->parameter('except_id');
        
        $validateUniqueRule = new UniqueRule;
        return $validateUniqueRule->getRecord($table, $column, $value, $exceptId);
    }
}