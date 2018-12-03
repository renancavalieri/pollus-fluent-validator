<?php declare(strict_types=1);

/**
 * Fluent Validator
 * @license https://opensource.org/licenses/MIT MIT
 * @author Renan Cavalieri <renan@tecdicas.com>
 */

namespace Pollus\Validator\Exceptions;

use Pollus\Validator\Models\ErrorCollection;

class ValidationException extends \Exception
{
    /**
     * @var array;
     */
    protected $collection = null;
    
    public function __construct(ErrorCollection $collection) 
    {
        $this->collection = $collection;
        parent::__construct("Validation Exception");
    }
    
    public function getErrors()
    {
        return $this->collection->getErrors();
    }
}
