<?php
namespace GetSky\ParserExpressions;

/**
 * It is a wrapper for parsing string.
 *
 * @package GetSky\ParserExpressions
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

    protected $result;

    /**
     * @param $string string Parsing string
     */
    public function __construct($string)
    {
        $this->string = $string;
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
     * Returns the current value of the cursor.
     *
     * @return int
     */
    public function getCursor()
    {
        return $this->cursor;
    }

    public function addResult($name, $value, $start, $end)
    {

        $this->result[][$name] = [
            'value' => $value,
            'start' => $start,
            'end' => $end
            ];
    }

    public function result()
    {
        return $this->result;
    }
}

