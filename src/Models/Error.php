<?php declare(strict_types=1);

/**
 * Fluent Validator
 * @license https://opensource.org/licenses/MIT MIT
 * @author Renan Cavalieri <renan@tecdicas.com>
 */

namespace Pollus\Validator\Models;

/**
 * Este objeto armazena as informações individuais de cada erro
 */
class Error 
{
    public $message;
    public $code;
    
    public function __construct(int $code, string $message) 
    {
        $this->code = $code;
        $this->message = $message;
    }
    
    /**
     * Retorna o código do erro
     * 
     * @return int
     */
    public function getCode() : int
    {
        return $this->code;
    }
    
    /**
     * Retorna a mensagem do erro
     * 
     * @return string
     */
    public function getMessage() : string
    {
        return $this->message;
    }
}
