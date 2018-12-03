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
     * @var int
     */
    protected $mode;

    /**
     * Loga somente o ultimo erro de validação
     */
    const MODE_LAST_ERROR = 0;
    
    /**
     * Loga somente o primeiro erro de validação
     */
    const MODE_FIRST_ERROR = 1;
    
    /**
     * @param int $mode
     */
    public function __construct(int $mode = 1)
    {
        $this->mode = $mode;
    }
    
    /**
     * Adiciona um novo erro na coleção
     * 
     * @param string $input
     * @param \Pollus\Validator\Models\Error $error
     */
    public function add(string $input, Error $error) : void
    {
        if ($this->mode === self::MODE_FIRST_ERROR && !isset($this->errors[$input]))
        {
            $this->errors[$input] = $error;
        }
        else if (self::MODE_LAST_ERROR)
        {
            $this->errors[$input] = $error;
        }
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
    
    /**
     * @return bool
     */
    public function clear() : bool
    {
        $this->errors = [];
        return true;
    }
}
