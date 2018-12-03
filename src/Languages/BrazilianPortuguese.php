<?php declare(strict_types=1);

/**
 * Fluent Validator
 * @license https://opensource.org/licenses/MIT MIT
 * @author Renan Cavalieri <renan@tecdicas.com>
 */

namespace Pollus\Validator\Languages;

use Pollus\Validator\Rules\IntegerRule as EX_INT;
use Pollus\Validator\Rules\BaseRule as EX_BASE;
use Pollus\Validator\Rules\StringRule as EX_STR;
use Pollus\Validator\Translator\BaseTranslator;
use Pollus\Validator\Translator\TranslatorInterface;

/**
 * Tradução brasileira
 * 
 * @author Renan Cavalieri <renan@tecdicas.com>
 */
class BrazilianPortuguese extends BaseTranslator implements TranslatorInterface
{
    protected $messages =
    [
        /**
         * Int
         */
        EX_INT::BETWEEN_ERROR          => "{{field}} deve ser um valor entre {{min}} e {{max}}",
        EX_INT::EQUAL_ERROR            => "{{field}} deve ser igual à {{value}}",
        EX_INT::EVEN_ERROR             => "{{field}} deve ser um número par",
        EX_INT::HIGHER_ERROR           => "{{field}} deve ser maior que {{value}}",
        EX_INT::HIGHER_OR_EQUAL_ERROR  => "{{field}} deve ser um número maior ou igual à {{value}}",
        EX_INT::IN_ERROR               => "{{field}} deve ser igual à um dos seguintes valores: {{values}}",
        EX_INT::LOWER_ERROR            => "{{field}} deve ser menor que {{value}}",
        EX_INT::LOWER_OR_EQUAL_ERROR   => "{{field}} deve ser menor ou igual à {{value}}",
        EX_INT::NEGATIVE_ERROR         => "{{field}} deve ser um valor negativo",
        EX_INT::NOT_BETWEEN_ERROR      => "{{field}} não pode estar entre {{min}} e {{max}}",
        EX_INT::NOT_EQUAL_ERROR        => "{{field}} não pode ser {{value}}",
        EX_INT::NOT_IN_ERROR           => "{{field}} não pode ser nenhum dos seguintes valores: {{values}}",
        EX_INT::ODD_ERROR              => "{{field}} não pode ser um número impar",
        EX_INT::POSITIVE_ERROR         => "{{field}} deve ser um valor positivo",

        /**
         * String
         */
        EX_STR::ALPHANUMERIC_ERROR     => "{{field}} deve conter somente letras e números",
        EX_STR::ALPHA_ERROR            => "{{field}} deve conter somente letras",
        EX_STR::NUMERIC_ERROR          => "{{field}} deve conter somente números",
        EX_STR::CEP_ERROR              => "{{field}} deve ser CEP válido",
        EX_STR::CNPJ_ERROR             => "{{field}} deve ser CNPJ válido",
        EX_STR::CONTAINS_ERROR         => "{{field}} deve conter um dos seguintes valores: ({{values}})",
        EX_STR::CPF_ERROR              => "{{field}} deve ser um CPF válido",
        EX_STR::EMAIL_ERROR            => "{{field}} deve ser um endereço de e-mail válido",
        EX_STR::EQUAL_ERROR            => "{{field}} deve ser igual à {{value}}",
        EX_STR::IPV4_ERROR             => "{{field}} deve ser um endereço de IPv4 válido",
        EX_STR::IPV6_ERROR             => "{{field}} deve ser um endereço de IPv6 válido",
        EX_STR::IP_ERROR               => "{{field}} deve ser um endereço IP válido",
        EX_STR::LENGTH_BETWEEN_ERROR   => "{{field}} deve conter entre {{min}} e {{max}} caracteres",
        EX_STR::LENGTH_MAX_ERROR       => "{{field}} deve conter no máximo {{max}} caracteres",
        EX_STR::LENGTH_MIN_ERROR       => "{{field}} deve conter no mínimo {{min}} caracteres",
        EX_STR::MOBILE_PHONE_NUMBER_ERROR => "{{field}} deve ser um número de telefone móvel (com área)",
        EX_STR::NOT_CONTAINS_ERROR     => "{{field}} não deve conter os seguintes valores: {{values}}",
        EX_STR::NOT_EQUAL_ERROR        => "{{field}} não deve ser igual à {{value}}",
        EX_STR::NULL_ERROR             => "{{field}} não deve ficar em branco",
        EX_STR::PATTERN_ERROR          => "{{field}} deve corresponder ao padrão {{pattern}}",
        EX_STR::PHONE_NUMBER_ERROR     => "{{field}} deve ser um número de telefone fixo (com área)",
        EX_STR::URL_ERROR              => "{{field}} deve ser uma URL",
        
        /**
         * Traduções de validação para todos os tipos
         */
        EX_BASE::NULL_ERROR             => "{{field}} não pode ser nulo",
    ];
}