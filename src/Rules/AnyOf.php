<?php
/**
 * @package GetSky\ParserExpressions\Rules
 * @author  Alexander Getmansky <getmansk_y@yandex.ru>
 */
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;
use GetSky\ParserExpressions\RuleInterface;

/**
 * The rule matching a single character out of a given characters set.
 */
class AnyOf implements RuleInterface
{

    /**
     * @var string String with characters.
     */
    protected $rule;

    /**
     * @var string
     */

    protected $name;

    /**
     * @param string $rule String with characters.
     * @param string $name Label for rule.
     */
    public function __construct($rule, $name = "AnyOf")
    {
        $this->rule = (string)$rule;
        $this->name = (string)$name;
    }

    /**
     * {@inheritdoc}
     */
    public function scan(Context $context)
    {
        $index = $context->getCursor();
        $len = strlen($this->rule);
        $char = $context->value();
        for ($i = 0; $i < $len; ++$i) {
            if ($char === $this->rule{$i}) {
                $result = new Result($this->name);
                $result->setValue($char, $index);
                return $result;
            }
        };

        $context->setCursor($index);
        return false;
    }
}
