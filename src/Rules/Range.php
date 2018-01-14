<?php
/**
 * @author  Alexander Getmanskii <alexander.get87@gmail.com>
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
     * @param callable $action
     */
    public function __construct($left, $right, $name = "Range", callable $action = null)
    {
        $this->left = (string) $left;
        $this->right = (string) $right;
        $this->name = (string) $name;
        $this->action = $action;
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
            $this->action($result);

            return $result;
        }

        $context->setCursor($index);
        $context->error($this, $index);
        return false;
    }
}
