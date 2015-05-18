<?php
/**
 * @author  Alexander Getmansky <getmansk_y@yandex.ru>
 * @package GetSky\ParserExpressions
 */
namespace GetSky\ParserExpressions;

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
     * @var int This is the farthest character where the error occurred.
     */
    protected $maxErrorCursor;

    /**
     * @var array The array of errors.
     */
    protected $error = [];

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
        if ($errorPrototype != null) {
            $this->errorPrototype = $errorPrototype;
        } else {
            $this->errorPrototype = new Error();
        }
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
        $this->error = [];
        $this->maxErrorCursor = null;
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
     * @throws \Exception
     */
    public function setCursor($position)
    {
        if ($position < 0) {
            throw new \Exception('The cursor can\'t be negative.');
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
        $this->error[$index][] = [$error];

        if ($this->maxErrorCursor < $index) {
            $this->maxErrorCursor = $index;
        }
    }

    /**
     * @return ErrorInterface
     */
    public function getError()
    {
        return $this->error[$this->maxErrorCursor];
    }

    /**
     * @return array
     */
    public function getAllErrors()
    {
        return $this->error;
    }
}
