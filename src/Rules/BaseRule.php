<?php declare(strict_types=1);

/**
 * Fluent Validator
 * @license https://opensource.org/licenses/MIT MIT
 * @author Renan Cavalieri <renan@tecdicas.com>
 */

namespace Pollus\Validator\Rules;

use Pollus\Validator\Translator\TranslatorInterface;

/**
 * Abstração das regras de validação
 */
abstract class BaseRule 
{
    const NULL_ERROR = 10000;
    
    /**
     * Valor
     * 
     * @var mixed
     */
    protected $value;

    /**
     * Nome do campo.
     * 
     * Ex: 
     * -- A idade
     * -- A altura
     * -- O número
     * 
     * @var string
     */
    protected $field;

    /**
     * Determina se um valor pode ser nulável.
     * 
     * Quando TRUE e o valor for NULL, nenhuma validação será relizada.
     * 
     * Defina como TRUE somente quando quiser que
     * um valor só seja validado caso não seja null
     * 
     * @var bool
     */
    protected $required = false;
       
    
    /**
     * @var int
     */
    protected $mode;
    
    /**
     * @var array
     */
    protected $errors = [];

    /**
     * Mensagens personalizadas
     * 
     * @var array
     */
    protected $custom_messages = [];
    
    /**
     * @var int
     */
    protected $num_rules = 0;
    
    public function __construct(string $field, $value)
    {
        $this->field = $field;
        $this->value = $value;
        $this->context = ["field" => $field];
    }

    /**
     * @param bool $status
     * @return $this
     */
    public function required(bool $status = true)
    {
        $this->required = $status;
        $this->nullableCheck();
        return $this;
    }
  
    /**
     * Adiciona uma mensagem personalizada para um ou vários erros, só terá
     * efeito antes de qualquer erro ter sido lançado.
     * 
     * @param string $message
     * @param int $code
     * @return $this
     */
    public function setMessage(string $message, int ...$codes)
    {
        foreach($codes as $code)
        {
            $this->custom_messages[$code] = $message;
        }
        return $this;
    }
    
    /**
     * Remove uma mensagem personalizada. Só pode ser realizado antes de
     * qualquer erro ter sido lançado.
     * 
     * @param int $code
     * @return $this
     */
    public function unsetMessage(int $code)
    {
        unset($this->custom_messages[$code]);
        return $this;
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
     * Retorna os erros
     * 
     * @return array
     */
    public function getErrors() : array
    {
        return $this->errors;
    }
    
    /**
     * Registra um erro de validação
     * @param int $code
     * @param array $context
     */
    protected function raiseError(int $code, array $context = [])
    {
        $this->errors[$code] = array_merge($this->context, $context);
    }
    
    /**
     * Verifica se o número é "nulável"
     */
    protected function nullableCheck()
    {
        if ($this->value === null && $this->required === false)
        {
            return false;
        }
        else if ($this->value === null && $this->required === true)
        {
            $this->raiseError(self::NULL_ERROR);
        }
        
        return true;
    }
    
    /**
     * Remove os erros de validação deste objeto
     * @return this
     */
    public function clearValidationErrors()
    {
        $this->errors = [];
        return $this;
    }
}
