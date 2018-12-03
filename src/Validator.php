<?php declare(strict_types=1);

/**
 * Fluent Validator
 * @license https://opensource.org/licenses/MIT MIT
 * @author Renan Cavalieri <renan@tecdicas.com>
 */

namespace Pollus\Validator;

use Pollus\Validator\Translator\TranslatorInterface;
use Pollus\Validator\Models\Error;
use Pollus\Validator\Models\ErrorCollection;
use Pollus\Validator\Rules\IntegerRule;
use Pollus\Validator\Exceptions\ValidationException;
use Pollus\Validator\Rules\StringRule;

/**
 * Classe de validação fluente
 */
class Validator
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;
    
    /**
     * @var ErrorCollection
     */
    protected $collection;
    
    /**
     * Contém os campos e as regras de validação
     * 
     * input_name => regra de validação
     * 
     * @var array
     */
    protected $inputs;
 
    /**
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator, ?ErrorCollection $error = null) 
    {
        $this->translator = $translator;
        
        if ($error === null)
        {
            $this->collection = new ErrorCollection();
        }
        else
        {
            $this->collection = $error;
        }
        
    }

    /**
     * @param string $input_name
     * @param string $field
     * @param string|null $value
     * @return StringRule
     */
    public function newString(string $input_name, string $field, ?string $value) : StringRule
    {
        return new StringRule($input_name, $field, $value, $this);
    }
    
    /**
     * @param string $input_name
     * @param string $field
     * @param int|null $value
     * @return IntegerRule
     */
    public function newInteger(string $input_name, string $field, ?int $value) : IntegerRule
    {
        return new IntegerRule($input_name, $field, $value, $this);
    }
    
    
    /**
     * @param bool $raise_exception
     * @return ErrorCollection
     * @throws ValidationException
     */
    public function validate(bool $raise_exception = true) : ErrorCollection
    {       
        if ($this->collection->hasErrors() === true && $raise_exception === true)
        {
            throw new ValidationException($this->collection);
        }
        
        return $this->collection;
    }
    
    /**
     * Traduz uma mensagem de erro
     * 
     * @param int $error_code
     * @param array $context
     * @param string|null $custom_message
     * @return string
     */
    public function translate(int $error_code, array $context = [], ?string $custom_message = null) : string
    {
        return $this->translator->getMessage($error_code, $context, $custom_message);
    }
    
    /**
     * Adiciona um novo erro
     * 
     * @param string $input_name
     * @param Error $error
     * 
     * @return Validator
     */
    public function addError(string $input_name, Error $error) : Validator
    {
        $this->collection->add($input_name, $error);   
        return $this;
    }
    
    /**
     * Limpa todas as regras de validação
     * @return $this
     */
    public function clear() : Validator
    {
        $this->collection = new ErrorCollection();
        $this->inputs = [];
        return $this;
    }
}
