<?php declare(strict_types=1);

/**
 * Fluent Validator
 * @license https://opensource.org/licenses/MIT MIT
 * @author Renan Cavalieri <renan@tecdicas.com>
 */

namespace Pollus\Validator\Models;

/**
 * Esta classe armazena todos os erros de validação ocorridos no validador
 */
class ErrorCollection 
{
    /**
     * @var Error[]
     */
    protected $errors;
    
    /**
     * Adiciona um novo erro na coleção
     * 
     * @param string $input
     * @param \Pollus\Validator\Models\Error $error
     */
    public function add(string $input, Error $error) : void
    {
        $this->errors[$input] = $error;
    }
    
    /**
     * Verifica se há erros
     * 
     * @return bool
     */
    public function hasErrors() : bool
    {
        return (!empty($this->errors));
    }
    
    /**
     * Retorna todos os erros em um vetor
     * 
     * @return Erro[]
     */
    public function getErrors() : array
    {
        return $this->errors;
    }
}
