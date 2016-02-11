<?php
/**
 * @package GetSky\ParserExpressions\Rules
 * @author  Alexander Getmansky <getmansk_y@yandex.ru>
 */
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;

/**
 * The rule matching a single character out of a given characters set.
 */
class AnyOf extends AbstractRule
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
     * @param callable $action
     */
    public function __construct($rule, $name = "AnyOf", callable $action = null)
    {
        $this->rule = (string) $rule;
        $this->name = (string) $name;
        $this->action = $action;
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
                $this->action();

                return $result;
            }
        };

        $context->setCursor($index);
        $context->error($this, $index);
        return false;
    }
}
