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
    public function __construct(TranslatorInterface $translator) 
    {
        $this->translator = $translator;
    }

    /**
     * @param string $input_name
     * @param string $field
     * @param string|null $value
     * @return StringRule
     */
    public function addString(string $input_name, string $field, ?string $value) : StringRule
    {
        $this->inputs[$input_name] = new StringRule($field, $value);
        return $this->inputs[$input_name];
    }
    
    /**
     * @param string $input_name
     * @param string $field
     * @param int|null $value
     * @return IntegerRule
     */
    public function addInteger(string $input_name, string $field, ?int $value) : IntegerRule
    {
        $this->inputs[$input_name] = new IntegerRule($field, $value);
        return $this->inputs[$input_name];
    }
    
    
    /**
     * @param bool $raise_exception
     * @return ErrorCollection
     * @throws ValidationException
     */
    public function validate(bool $raise_exception = true) : ErrorCollection
    {
        $collection = new ErrorCollection();
        
        foreach($this->inputs as $input_name => $object)
        {
            if ($object->hasErrors() === true)
            {
                $errors = $object->getErrors();
                
                foreach($errors as $error_code => $context)
                {
                    $message = $this->translator->getMessage($error_code, $context, 
                            ($object->messages[$error_code]) ?? null);
                    
                    $collection->add($input_name, new Error($error_code, $message));   
                }
            }
        }
        
        if ($collection->hasErrors() === true && $raise_exception === true)
        {
            throw new ValidationException($collection);
        }
        
        return $collection;
    }
    
    /**
     * Limpa todas as regras de validação
     * @return $this
     */
    public function clear() : self
    {
        $this->inputs = [];
        return $this;
    }
}
