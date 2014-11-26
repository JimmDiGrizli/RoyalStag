<?php
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;
use GetSky\ParserExpressions\RuleInterface;

/**
 * It rule consumes any character in the string.
 *
 * @package GetSky\ParserExpressions\Rules
 * @author  Alexander Getmansky <getmansk_y@yandex.ru>
 */
class Any implements RuleInterface
{

    protected $name = 'ANY';

    /**
     * {@inheritdoc}
     */
    public function scan(Context $context)
    {
        $index = $context->getCursor();
        $value = $context->value();

        if ($value === false) {
            return false;
        }

        $result = new Result($this->name);
        $result->setValue($value, $index);

        return $result;
    }
}
