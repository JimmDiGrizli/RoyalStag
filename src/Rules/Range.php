<?php
/**
 * @author  Alexander Getmansky <getmansk_y@yandex.ru>
 * @package GetSky\ParserExpressions\Rules
 */
namespace GetSky\ParserExpressions\Rules;

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Result;

/**
 * This rule verifying a character out of a given range of characters.
 */
class Range extends AbstractRule
{
    /**
     * @var string
     */
    protected $left;

    /**
     * @var string
     */
    protected $right;

    /**
     * @param string $left First character of characters.
     * @param string $right Second character of characters.
     * @param string $name
     */
    public function __construct($left, $right, $name = "Range")
    {
        $this->left = (string)$left;
        $this->right = (string)$right;
        $this->name = (string)$name;
    }

    /**
     * {@inheritdoc}
     */
    public function scan(Context $context)
    {
        $index = $context->getCursor();
        $string = $context->value();

        if (is_string($string) && ($string >= $this->left && $string <= $this->right)) {
            $result = new Result($this->name);
            $result->setValue($string, $index);
            return $result;
        }
        $context->setCursor($index);
        return false;
    }
}
