<?php
namespace GetSky\ParserExpressions;

class Context
{
    protected $string;

    protected $cursor = 0;

    public function __construct($string)
    {
        $this->string = $string;
    }

    public function value($size = 1)
    {
        if ($this->cursor + $size > strlen($this->string)) {
            return false;
        }
        $value = substr($this->string, $this->cursor, $size);
        $this->cursor += $size;
        return $value;
    }

    public function setCursor($position)
    {
        if ($position < 0) {
            throw new \Exception('Cursor i');
        }
        $this->cursor = $position;
    }

    public function getCursor()
    {
        return $this->cursor;
    }
}
