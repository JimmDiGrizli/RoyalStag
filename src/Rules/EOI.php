<?php
namespace GetSky\ParserExpressions\Rules;


use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\RuleInterface;

class EOI implements RuleInterface {

    protected $name = 'EOI';

    /**
     * {@inheritdoc}
     */
    public function scan(Context $context)
    {
        $index = $context->getCursor();
        $value = $context->value();
        if ($value !== false) {
            $context->setCursor($index);
            return false;
        }

        return true;
    }
}
