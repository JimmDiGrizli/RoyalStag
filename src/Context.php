<?php
/**
 * @author  Alexander Getmansky <getmansk_y@yandex.ru>
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
     * @var array The array of errors.
     */
    protected $errors = [];

    /**
     * @var ErrorInterface Error handler.
     */
    protected $errorPrototype;

    /**
     * @param ErrorInterface $errorPrototype
     * @param string $string Parsing string
     */
    public function __construct(ErrorInterface $errorPrototype = null, $string = null)
    {
        $this->string = (string)$string;
        $this->errorPrototype = $errorPrototype == null ? new Error() : $errorPrototype;
    }

    /**
     * Set new string and reset cursor.
     *
     * @param string $string
     * @return string
     */
    public function setString($string)
    {
        $this->string = (string)$string;
        $this->cursor = 0;
        $this->errors = [];
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
        $value = mb_substr($this->string, $this->cursor, $size, 'utf8');
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
     * @param RuleInterface $rule
     * @param int $index
     */
    public function error(RuleInterface $rule, $index)
    {
        $error = clone $this->errorPrototype;
        $error->update($rule, $index);
        $this->errors[$index][] = $error;
    }

    /**
     * @return ErrorInterface
     */
    public function getError()
    {
        ksort($this->errors);
        return end($this->errors);
    }

    /**
     * @return array
     */
    public function getAllErrors()
    {
        return $this->errors;
    }
}
