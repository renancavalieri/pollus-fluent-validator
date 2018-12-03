<?php declare(strict_types=1);

/**
 * Fluent Validator
 * @license https://opensource.org/licenses/MIT MIT
 * @author Renan Cavalieri <renan@tecdicas.com>
 */

namespace Pollus\Validator\Rules;

/**
 * Classe de validação para números inteiros
 */
class IntegerRule extends BaseRule
{   
     // Quando um número não for positivo
    const POSITIVE_ERROR = 10001;
    
    // Quando um número não for negativo
    const NEGATIVE_ERROR = 10002;
    
    // Quando um número não for maior que outro
    const HIGHER_ERROR = 10003;
    
    // Quando um número não for maior ou igual a outro
    const HIGHER_OR_EQUAL_ERROR = 10004;
    
    // Quando um número não for igual ao outro
    const EQUAL_ERROR = 10005;
    
    // Quando um número não for diferente de determinado número
    const NOT_EQUAL_ERROR = 10006;
    
    // Quando um número não for menor que outro
    const LOWER_ERROR = 10007;
    
    // Quando um número não for menor ou igual a outro
    const LOWER_OR_EQUAL_ERROR = 10008;
    
    // Quando um número não estiver entre dois valores
    const BETWEEN_ERROR = 10009;
    
    // Quando um número está em um intervalo não permitido
    const NOT_BETWEEN_ERROR = 10010;
    
    // Quando um número não for impar
    const ODD_ERROR = 10011;
    
    // Quando um número não for par
    const EVEN_ERROR = 10012;
    
    // Quando um número não estiver em um intervalo de números
    const IN_ERROR = 10013;
    
    // Quando um número estiver em um invervalo de números não permitidos
    const NOT_IN_ERROR = 10014;    
    
    /**
     * Verifica se um número é positivo
     * @return $this;
     * @throws InternalValidationException
     */
    public function positive() : IntegerRule
    {
        if ($this->nullableCheck() && ($this->value > 0) === false)
        {
            $this->raiseError(self::POSITIVE_ERROR, $this->context);
        }
        return $this;
    }
    
    /**
     * Verifica se o valor é negativo
     * @return $this;
     * @throws InternalValidationException
     */
    public function negative() : IntegerRule
    {
        if ($this->nullableCheck() && ($this->value < 0) === false)
        {
            $this->raiseError(self::NEGATIVE_ERROR, $this->context);
        }
        return $this;
    }
    
    /**
     * Determina se o valor é maior que outro
     * @param int $value
     * @return $this;
     * @throws InternalValidationException
     */
    public function higher(int $value) : IntegerRule
    {
        if ($this->nullableCheck() && ($this->value > $value) === false)
        {
            $this->raiseError(self::HIGHER_ERROR, array_merge($this->context, 
            [
                "value" => $value,
            ]));
        }
        return $this;
    }
    
    /**
     * Valida se um número é maior ou igual
     * 
     * @param int $value
     * @return $this;
     * @throws InternalValidationException
     */
    public function higherEqual(int $value) : IntegerRule
    {
        if ($this->nullableCheck() && ($this->value >= $value) === false)
        {
            $this->raiseError(self::HIGHER_OR_EQUAL_ERROR, array_merge($this->context, 
            [
                "value" => $value
            ]));
        }
        return $this;
    }
    
    
    /**
     * Valida se o número é igual
     * 
     * @param int $value
     * @return $this;
     * @throws InternalValidationException
     */
    public function equal(int $value) : IntegerRule
    {
        if ($this->nullableCheck() && ($this->value === $value) === false)
        {
            $this->raiseError(self::EQUAL_ERROR, array_merge($this->context, 
            [
                "value" => $value
            ]));
        }
        return $this;
    }
    
    /**
     * Valida se o número é diferente
     * 
     * @param int $value
     * @return $this;
     * @throws InternalValidationException
     */
    public function notEqual(int $value) : IntegerRule
    {
        if ($this->nullableCheck() && ($this->value !== $value) === false)
        {
            $this->raiseError(self::NOT_EQUAL_ERROR, array_merge($this->context, 
            [
                "value" => $value
            ]));
        }
        return $this;
    }
    
    /**
     * Valida se o número é menor
     * 
     * @param int $value
     * @return $this;
     * @throws InternalValidationException
     */
    public function lower(int $value) : IntegerRule
    {
        if ($this->nullableCheck() && ($this->value < $value) === false)
        {
            $this->raiseError(self::LOWER_ERROR, array_merge($this->context, 
            [
                "value" => $value
            ]));
        }
        return $this;
    }
    
    /**
     * Valida se o número é menor igual
     * 
     * @param int $value
     * @return $this;
     * @throws InternalValidationException
     */
    public function lowerEqual(int $value) : IntegerRule
    {
        if ($this->nullableCheck() && ($this->value <= $value) === false)
        {
            $this->raiseError(self::LOWER_OR_EQUAL_ERROR, array_merge($this->context, 
            [
                "value" => $value
            ]));
        }
        return $this;
    }
    
    
    /**
     * Verifica se o valor está entre dois números
     * @param int $min
     * @param int $max
     * @return $this;
     * @throws InternalValidationException
     */
    public function between(int $min, int $max) : IntegerRule
    {
        if ($this->nullableCheck() && ($this->value >= $min && $this->value <= $max) === false)
        {
            $this->raiseError(self::BETWEEN_ERROR, array_merge($this->context, 
            [
                "min" => $min,
                "max" => $max
            ]));
        }
        return $this;
    }
    
    
    /**
     * Verifica se o valor não está entre o intervalo
     * 
     * @param int $min
     * @param int $max
     * @return $this
     */
    public function notBetween(int $min, int $max)
    {
        if ($this->nullableCheck() && ($this->value >= $min && $this->value <= $max))
        {
            $this->raiseError(self::NOT_BETWEEN_ERROR, array_merge($this->context, 
            [
                "min" => $min,
                "max" => $max
            ]));
        }
        return $this;
    }
    
    
    /**
     * Verifica se o número é par
     * 
     * @return $this
     */
    public function even()
    {
        if ($this->nullableCheck() && ($this->value % 2 === 0) === false)
        {
            $this->raiseError(self::EVEN_ERROR, $this->context);
        }
        return $this;
    }
    
    /**
     *  Verifica se o número é impar
     * 
     * @return $this
     */
    public function odd()
    {
        if ($this->nullableCheck() && ($this->value % 2 === 0))
        {
            $this->raiseError(self::ODD_ERROR, $this->context);
        }
        return $this;
    }
    
    /**
     * Verifica se o número é um dos seguintes valores
     * 
     * @param int $values
     * @return $this
     */
    public function in(int ...$values)
    {
        if ($this->nullableCheck() && (in_array($this->value, $values)) === false)
        {
            $this->raiseError(self::IN_ERROR, array_merge($this->context, 
            [
                "values" => implode(", ", $values)
            ]));
        }
        return $this;
    }
    
    /**
     * Verifica se o número não está entre os seguintes valores
     * 
     * @param type $values
     * @return $this
     */
    public function notIn(int ...$values)
    {
        if ($this->nullableCheck() && (in_array($this->value, $values)))
        {
            $this->raiseError(self::IN_ERROR, array_merge($this->context, 
            [
                "values" => implode(", ", $values)
            ]));
        }
        return $this;
    }

    
    /**
     * Alias do método higher
     * 
     * @param int $value
     * @return $this;
     */
    public function min(int $value)
    {
        return $this->higher($value);
    }
    
    /**
     * Alias do método Lower
     * 
     * @param int $value
     * @return $this
     */
    public function max(int $value)
    {
        return $this->lower($value);
    } 
}

