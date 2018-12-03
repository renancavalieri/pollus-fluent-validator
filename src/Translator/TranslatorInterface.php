<?php declare(strict_types=1);

/**
 * Fluent Validator
 * @license https://opensource.org/licenses/MIT MIT
 * @author Renan Cavalieri <renan@tecdicas.com>
 */

namespace Pollus\Validator\Translator;

/**
 * Todas as traduções devem implementar esta interface
 */
interface TranslatorInterface
{
    /**
     * Retorna uma mensagem de erro
     * @param int $code
     * @param array $context
     * @param string|null $custom_message
     * @return string
     */
    public function getMessage(int $code, array $context = [], ?string $custom_message = null) : string;
    
    /**
     * Permite a sobrescrita de alguma mensagem de erro.
     * 
     * @param int $code
     * @param string $message
     * @return void
     */
    public function setMessage(int $code, string $message): void;
}
