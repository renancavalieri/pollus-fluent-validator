<?php declare(strict_types=1);

/**
 * Fluent Validator
 * @license https://opensource.org/licenses/MIT MIT
 * @author Renan Cavalieri <renan@tecdicas.com>
 */

namespace Pollus\Validator\Translator;

/**
 * Classe base do tradutor
 */
abstract class BaseTranslator implements TranslatorInterface
{
    protected $messages = [];

    /**
     * {@inheritDoc}
     */
    public function getMessage(int $code, array $context = [], ?string $custom_message = null) : string
    {
        $error_message = $custom_message ?? $this->messages[$code] ?? "Falha ao validar o campo {{field}}";
        foreach($context as $placeholder => $value)
        {
            $error_message = str_replace("{{" . $placeholder . "}}", $value, $error_message);
        }
        return $error_message;
    }

    /**
     * {@inheritDoc}
     */
    public function setMessage(int $code, string $message): void 
    {
        $this->messages[$code] = $message;
    }

}
