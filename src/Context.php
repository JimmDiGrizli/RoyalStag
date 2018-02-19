<?php
/**
 * @author  Alexander Getmanskii <alexander.get87@gmail.com>
 * @package GetSky\ParserExpressions
 */
namespace GetSky\ParserExpressions;

use Exception;

/**
 * It is a wrapper for parsing string.
 */
class Context
{
    /**
     * @var string Parsing string.
     */
    protected $string;

    /**
     * @var int The number of the current position.
     */
    protected $cursor = 0;

    /**
     * @var int The current depth of immersion in the rules tree.
     */
    protected $depth = 0;

    /**
     * @var ErrorCollectionInterface
     */
    protected $errors;

    /**
     * @param ErrorCollectionInterface $errorCollection
     */
    public function __construct(ErrorCollectionInterface $errorCollection)
    {
        $this->errors = $errorCollection;
    }

    /**
     * Set new string and reset cursor.
     *
     * @param string $string
     * @return void
     */
    public function setString($string)
    {
        $this->string = (string) $string;
        $this->cursor = 0;
        $this->depth = 0;
        $this->errors->clear();
    }

    /**
     * Returns the characters from the current position with the given $size.
     *
     * @param int $size
     * @return bool|string
     */
    public function value($size = 1)
    {
        if ($this->cursor + $size > strlen($this->string)) {
            return false;
        }
        $value = substr($this->string, $this->cursor, $size);
        $this->cursor += $size;

        return $value;
    }

    /**
     * Returns the current value of the cursor.
     *
     * @return int
     */
    public function getCursor()
    {
        return $this->cursor;
    }

    /**
     * Sets a new value for the cursor.
     *
     * @param int $position
     * @throws Exception
     */
    public function setCursor($position)
    {
        if ($position < 0) {
            throw new Exception('The cursor can\'t be negative.');
        }
        $this->cursor = $position;
    }

    /**
     * Increase the depth by one.
     *
     * @throws Exception
     */
    public function increaseDepth()
    {
        $this->depth++;
    }

    /**
     * Decrease the depth by one.
     *
     * @throws Exception
     */
    public function decreaseDepth()
    {
        if ($this->depth == 0) {
            throw new Exception('The depth can\'t be negative.');
        }
        $this->depth--;
    }

    /**
     * @param RuleInterface $rule
     * @param int $index
     */
    public function error(RuleInterface $rule, $index)
    {
        $this->errors->add($rule, $index, $this->depth);
    }
}
