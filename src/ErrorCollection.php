<?php
/**
 * @author  Alexander Getmanskii <alexander.get87@gmail.com>
 * @package GetSky\ParserExpressions
 */
namespace GetSky\ParserExpressions;

/**
 * It is a collection of errors.
 */
class ErrorCollection implements ErrorCollectionInterface
{
    /**
     * @var array The array of errors.
     */
    protected $errors = [];

    /**
     * {@inheritdoc}
     */
    public function add(RuleInterface $rule, $index)
    {
        $this->errors[$index][] = new ParsingError($rule, $index);
    }

    /**
     * {@inheritdoc}
     */
    public function findMaxErrors()
    {
        ksort($this->errors);
        return end($this->errors);
    }

    public function clear()
    {
        $this->errors = [];
    }
}
