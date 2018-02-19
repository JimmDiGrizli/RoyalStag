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
    public function add(RuleInterface $rule, $index, $depth)
    {
        $this->errors[$depth][] = new ParsingError($rule, $index, $depth);
    }

    /**
     * {@inheritdoc}
     */
    public function findMaxErrors()
    {
        ksort($this->errors);
        return reset($this->errors);
    }

    public function clear()
    {
        $this->errors = [];
    }
}
