<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;

/**
 * The sequence operator e1 e2 first invokes e1, and if e1 succeeds,
 * subsequently invokes e2 on the remainder of the input string leftc
 * unconsumed by e1, and returns the result. If either e1 or e2 fails,
 * then the sequence expression e1 e2 fails.
 *
 * @package GetSky\ParserExpressions\Rules
 * @author  Alexander Getmansky <getmansk_y@yandex.ru>
 */
class Sequence extends AbstractRule
{

    /**
     * @var \GetSky\ParserExpressions\Rule[] Array with subrules.
     */
    protected $rules;

    /**
     * @param array $rules Array with subrules
     * @param string $name
     */
    public function __construct(array $rules, $name = "Sequence")
    {
        foreach ($rules as $rule) {
            $this->rules[] = $this->toRule($rule);
        }
        $this->name = (string)$name;
    }

    /**
     * {@inheritdoc}
     */
    public function scan(Context $context)
    {
        $index = $context->getCursor();
        $string = '';
        $result = new Result($this->name);

        foreach ($this->rules as $rule) {
            $value = $rule->scan($context);
            if ($value === false) {
                $context->setCursor($index);
                return false;
            } elseif ($value === true) {
                $index = $context->getCursor();
            } elseif ($value instanceof Result) {
                $string .= $value->getValue();
                $result->addChild($value);
            }
        }

        $result->setValue($string, $index);

        return $result;
    }
}
