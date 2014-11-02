<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Rule;

class Sequence implements Rule
{

    protected $rules;

    public function __construct($rules)
    {
        $this->rules = $rules;
    }

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