<?php declare(strict_types=1);

/**
 * Fluent Validator
 * @license https://opensource.org/licenses/MIT MIT
 * @author Renan Cavalieri <renan@tecdicas.com>
 */

namespace Pollus\Validator\Rules;

/**
 * Classe de validação para strings
 */
class StringRule extends BaseRule
{   
    // Quando o tamanho da string não está entre o mínimo e o máximo
    const LENGTH_BETWEEN_ERROR = 20001;
    
    // Quando o tamanho é menor que o mínimo
    const LENGTH_MIN_ERROR = 20002;
    
    // Quando o tamanho é maior que o máximo
    const LENGTH_MAX_ERROR = 20003;
    
    // Quando a string não é igual ao valor comparado
    const EQUAL_ERROR = 20004;
    
    // Quando a string é igual ao valor comparado;
    const NOT_EQUAL_ERROR = 20005;
    
    // Quando a string não é um CPF válido
    const CPF_ERROR = 20006;
    
    // Quando a string não é um CNPJ válido
    const CNPJ_ERROR = 20008;
    
    // Quando a string não contém apenas números
    const NUMERIC_ERROR = 20009;
    
    // Quando a string contém caracteres além de a-Z 0-9
    const ALPHANUMERIC_ERROR = 20010;
    
    // Quando a string contém caractéres além de a-Z
    const ALPHA_ERROR = 20011;
    
    // Quando a string coincide com determinado padrão
    const PATTERN_ERROR = 20012;
    
    // Quando a string não contém determinado valor
    const CONTAINS_ERROR = 20014;
  
    // Quando contem valores inaceitáveis
    const NOT_CONTAINS_ERROR = 20017;
    
    // Quando a string não é um endereço de e-mail
    const EMAIL_ERROR = 20018;
    
    // Quando a string não é um endereço de IP (v4 ou v6)
    const IP_ERROR = 20019;
    
    // Quando a string não é um endereço IPv4
    const IPV4_ERROR = 20020;
    
    // Quando a string não é um endereço IPv6
    const IPV6_ERROR = 20021;
    
    // Quando a string não é uma URL
    const URL_ERROR = 20022;
    
    // Quando a string não é um número de telefone fixo válido (formato Brasileiro)
    const PHONE_NUMBER_ERROR = 20023;
    
    // Quando a string não é um número de celular válido (formato Brasileiro)
    const MOBILE_PHONE_NUMBER_ERROR = 20024;
    
    // Quando não é um CEP válido (formato brasileiro)
    const CEP_ERROR = 20025;
    
    // Quando a string não conter ao menos 1 número
    const AT_LEAST_ONE_NUMBER_ERROR = 20026;
    
    // Quando a string não conter ao menos 1 letra maiuscula
    const AT_LEAST_ONE_UPPERCASE_ERROR = 20027;
    
    // Quando a string não conter ao menos 1 letra minuscula
    const AT_LEAST_ONE_LOWERCASE_ERROR = 20028;
    
    /**
     * Valida se a string é um CEP
     * @return $this;
     */
    public function cep() : StringRule
    {
        if ($this->nullableCheck() && (!preg_match("/^[0-9]{5}-[0-9]{3}$/", $this->value)))
        {
            $this->raiseError(self::CEP_ERROR, $this->context);
        }
        return $this;
    }
    
    /**
     * Valida se a string está dentro do tamanho mínimo e máximo
     * @param int $min
     * @param int $max
     * @return $this
     */
    public function lenghtBetween(int $min, int $max) : StringRule
    {
        if ($this->nullableCheck() && (strlen($this->value) >= $min && strlen($this->value) <= $max) === false)
        {
            $this->raiseError(self::LENGTH_BETWEEN_ERROR, array_merge($this->context, 
            [
                "min" => $min,
                "max" => $max
            ]));
        }
        return $this;
    }
    
    /**
     * Valida se é um número de telefone móvel
     * Esta implementação verifica apenas números brasileiros, como no exemplo:
     * - 18996547847
     * @return $this
     */
    public function mobilePhoneNumber() : StringRule
    {
        if ($this->nullableCheck() && (strlen($this->value) !== 11 || (!preg_match('/^[0-9]+$/i', $this->value))))
        {
            $this->raiseError(self::MOBILE_PHONE_NUMBER_ERROR, $this->context);
        }
        return $this;
    }
    
    /**
     * Valida se é um número de telefone fixo.
     * Esta implementação verifica apenas números brasileiros, como no exemplo:
     * - 1838881125
     * @return $this
     */
    public function phoneNumber() : StringRule
    {
        if ($this->nullableCheck() && (strlen($this->value) !== 10 || (!preg_match('/^[0-9]+$/i', $this->value))))
        {
            $this->raiseError(self::PHONE_NUMBER_ERROR, $this->context);
        }
        return $this;
    }
    
    /**
     * Valida se a string é uma URL
     * @return $this
     */
    public function url() : StringRule
    {
        if ($this->nullableCheck() && (filter_var($this->value, FILTER_VALIDATE_URL) === false))
        {
            $this->raiseError(self::URL_ERROR, $this->context);
        }
        return $this;
    }
    
    /**
     * Valida se a string é um endereço IPV4
     * @return $this
     */
    public function ipv4() : StringRule
    {
        if ($this->nullableCheck() && (filter_var($this->value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false))
        {
            $this->raiseError(self::IPV4_ERROR, $this->context);
        }
        return $this;
    }
    
    /**
     * Valida se a string é um endereço IPV6
     * @return $this
     */
    public function ipv6() : StringRule
    {
        if ($this->nullableCheck() && (filter_var($this->value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false))
        {
            $this->raiseError(self::IPV6_ERROR, $this->context);
        }
        return $this;
    }
    
    /**
     * Verifica se a string é um endereço IPV4 ou IPV6
     * @return $this
     */
    public function ip() : StringRule
    {
        if ($this->nullableCheck() && (filter_var($this->value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6|FILTER_FLAG_IPV4) === false))
        {
            $this->raiseError(self::IP_ERROR, $this->context);
        }
        return $this;
    }
    
    /**
     * Valida se a string é um endereço de email
     * @return $this
     */
    public function email() : StringRule
    {
        if ($this->nullableCheck() && (filter_var($this->value, FILTER_VALIDATE_EMAIL) === false))
        {
            $this->raiseError(self::EMAIL_ERROR, $this->context);
        }
        return $this;
    }
    
    /**
     * Valida o tamanho mínimo da string
     * @param int $min
     * @return $this
     */
    public function minLenght(int $min) : StringRule
    {
        if ($this->nullableCheck() && (strlen($this->value) >= $min) === false)
        {
            $this->raiseError(self::LENGTH_MIN_ERROR, array_merge($this->context, 
            [
                "min" => $min,
            ]));
        }
        return $this;
    }
    
    /**
     * Valida o tamanho máximo da string
     * @param int $max
     * @return $this
     */
    public function maxLenght(int $max) : StringRule
    {
        if ($this->nullableCheck() && (strlen($this->value) <= $max) === false)
        {
            $this->raiseError(self::LENGTH_MAX_ERROR, array_merge($this->context, 
            [
                "max" => $max,
            ]));
        }
        return $this;
    }
    
    /**
     * Valida se a string é igual ao valor fornecido
     * @param string $value
     * @return $this
     */
    public function equal(string $value) : StringRule
    {
        if ($this->nullableCheck() && ($this->value === $value) === false)
        {
            $this->raiseError(self::EQUAL_ERROR, array_merge($this->context, 
            [
                "value" => $value,
            ]));
        }
        return $this;
    }
    
    /**
     * Valida se a string é diferente do valor fornecido
     * @param string $value
     * @return $this
     */
    public function notEqual(string $value) : StringRule
    {
        if ($this->nullableCheck() && ($this->value !== $value) === false)
        {
            $this->raiseError(self::NOT_EQUAL_ERROR, array_merge($this->context, 
            [
                "value" => $value,
            ]));
        }
        return $this;
    }

    /**
     * Valida um CPF
     * @link https://gist.github.com/rafael-neri/ab3e58803a08cb4def059fce4e3c0e40
     * @return $this
     */
    public function cpf(): StringRule 
    {
        if ($this->nullableCheck()) 
        {
            $error = false;
            
            $cpf = $this->value;
            
            if (strlen($cpf) !== 11 || (preg_match('/(\d)\1{10}/', $cpf))) 
            {
                $error = true;
            }
            if ($error === false)
            {
                for ($t = 9; $t < 11; $t++) 
                {
                    for ($d = 0, $c = 0; $c < $t; $c++) 
                    {
                        $d += $cpf{$c} * (($t + 1) - $c);
                    }
                    $d = ((10 * $d) % 11) % 10;
                    
                    if ($cpf{$c} != $d) 
                    {
                        $error = true;
                    }
                }
            }
            if ($error === true) 
            {
                $this->raiseError(self::CPF_ERROR, $this->context);
            }
        }
        return $this;
    }
    
    
    /**
     * Valida um CNPJ
     * @link https://gist.github.com/guisehn/3276302
     * @return $this
     */
    public function cnpj() : StringRule
    {
        if ($this->nullableCheck()) 
        {
            $error = false;

            $cnpj = $this->value;

            if (strlen($cnpj) === 14)
            {
                for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) 
                {
                    $soma += $cnpj{$i} * $j;
                    $j = ($j == 2) ? 9 : $j - 1;
                }
                $resto = $soma % 11;
                if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
                {
                    $error = true;
                }

                if ($error === false)
                {
                    for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) 
                    {
                        $soma += $cnpj{$i} * $j;
                        $j = ($j == 2) ? 9 : $j - 1;
                    }
                    $resto = $soma % 11;
                    $error = !($cnpj{13} == ($resto < 2 ? 0 : 11 - $resto));
                }
            }
            else
            {
                $error = true;
            }
            if ($error === true) 
            {
                $this->raiseError(self::CNPJ_ERROR, $this->context);
            }
        }
        return $this;
    }
    
    /**
     * Valida se a string contém apenas números
     * @return $this
     */
    public function numeric() : StringRule
    {
        if ($this->nullableCheck() && (!preg_match("/^[0-9]+$/", $this->value))) 
        {
            $this->raiseError(self::NUMERIC_ERROR, $this->context);
        }
        return $this;
    }
    
    /**
     * Valida se a string contém apenas caracteres alfanuméricos
     * @return $this
     */
    public function alphaNumeric() : StringRule
    {
        if ($this->nullableCheck() && (!preg_match("/^[a-zA-Z0-9]+$/", $this->value))) 
        {
            $this->raiseError(self::ALPHANUMERIC_ERROR, $this->context);
        }
        return $this;
    }
    
    /**
     * Valida se a string contém apenas letras
     * @return $this
     */
    public function alpha() : StringRule
    {
        if ($this->nullableCheck() && (!preg_match("/^[a-zA-Z]+$/", $this->value))) 
        {
            $this->raiseError(self::ALPHA_ERROR, $this->context);
        }
        return $this;
    }
    
    /**
     * Valida se a string possui os valores fornecidos
     * @param string $values
     * @return $this
     */
    public function contains(string ...$values) : StringRule
    {
        if ($this->nullableCheck())
        {
            $error = true;

            foreach($values as $v)
            {
                $result = strpos($this->value, $v);

                if ($result !== false)
                {
                    $error = false;
                    break;
                }
            }
            if ($error === true)
            {
                $this->raiseError(self::CONTAINS_ERROR, array_merge($this->context, 
                [
                    "value" => implode(", ", $values)
                ]));
            }
        }
        return $this;
    }
    
    /**
     * Valida se a string não possui os valores fornecidos
     * 
     * @param type $values
     * @return $this
     */
    public function notContains(string ...$values) : StringRule
    {
        if ($this->nullableCheck())
        {
            $error = false;

            foreach($values as $v)
            {
                $result = strpos($this->value, $v);

                if ($result !== false)
                {
                    $error = true;
                    break;
                }
            }
            if ($error === true)
            {
                $this->raiseError(self::NOT_CONTAINS_ERROR, array_merge($this->context, 
                [
                    "value" => implode(", ", $values)
                ]));
            }
        }
        return $this;
    }
    
    /**
     * Valida uma regex
     * @param string $regex
     * @return $this
     */
    public function pattern(string $regex) : StringRule
    {
        if ($this->nullableCheck() && preg_match($regex, $this->value) === false)
        {
            $this->raiseError(self::NOT_EQUAL_ERROR, array_merge($this->context, 
            [
                "pattern" => $regex,
            ]));
        }
    }
    
    
    /**
     * Verifica se contém ao menos 1 número
     * @return $this
     */
    public function atLeastOneNumber() : StringRule
    {
        if ($this->nullableCheck() && (!preg_match('/[0-9]/', $this->value))) 
        {
            $this->raiseError(self::AT_LEAST_ONE_NUMBER_ERROR, $this->context);
        }
        return $this;
    }
    
    /**
     * Verifica se contém ao menos 1 letra maiuscula
     * @return $this
     */
    public function atLeastOneUppercase() : StringRule
    {
        if ($this->nullableCheck() && (!preg_match('/[A-Z]/', $this->value))) 
        {
            $this->raiseError(self::AT_LEAST_ONE_UPPERCASE_ERROR, $this->context);
        }
        return $this;
    }
    
    /**
     * Verifica se contém ao menos 1 letra minuscula
     * @return $this
     */
    public function atLeastOneLowercase() : StringRule
    {
        if ($this->nullableCheck() && (!preg_match('/[a-z]/', $this->value))) 
        {
            $this->raiseError(self::AT_LEAST_ONE_LOWERCASE_ERROR, $this->context);
        }
        return $this;
    }
    
    /**
     * Exige que o campo não seja NULL ou em branco
     * 
     * @param bool $status
     * @return $this
     */
    protected function nullableCheck()
    {
        if ( ($this->value === null || $this->value === "" ) && $this->required === false )
        {
            return false;
        }
        else if (($this->value === null || $this->value === "" ) && $this->required === true)
        {
            $this->raiseError(self::NULL_ERROR);
        }
        
        return true;
    }
}

