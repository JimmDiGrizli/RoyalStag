<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Rule;

/**
 * It's rule that only succeeds if all of its subrule succeed, one after the
 * other.
 *
 * @package GetSky\ParserExpressions\Rules
 */
class Sequence implements Rule
{

    /**
     * @var array Array with subrules
     */
    protected $rules;

    /**
     * @param array $rules Array with subrules
     */
    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    /**
     * Checks the rules for transmission $context. If at least one rule is not
     * satisfied, then rolls back the cursor to initial position.
     *
     * @param Context $context
     */
    public function scan(Context $context)
    {
        $index = $context->getCursor();
        $error = false;

        foreach ($this->rules as $rule) {
            $string = $context->value(strlen($rule));
            if ($string !== $rule) {
                $error = true;
                break;
            }
        }

        if ($error !== false) {
            $context->setCursor($index);
        }
    }
}
