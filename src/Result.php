<?php
namespace GetSky\ParserExpressions;


/**
 * Result class is used to store the result of the parse/.
 *
 * @package GetSky\ParserExpressions
 */
class Result implements \Iterator
{

    protected $key;

    protected $name;

    protected $value;

    protected $start;

    protected $end;

    protected $children;

    public function __construct($name)
    {
        $this->name = $name;
    }


    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @param integer $start
     */
    public function setValue($value, $start)
    {
        $this->value = $value;
        $this->start = $start;
        $this->end = $start + strlen($value);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    public function addChild(Result $child)
    {
        $this->children[] = $child;
    }

    public function current()
    {
        $this->children[$this->key];
    }

    public function next()
    {
        ++$this->key;
    }

    public function key()
    {
        return $this->key;
    }

    public function valid()
    {
        return isset($this->children[$this->key]);
    }

    public function rewind()
    {
        $this->key = 0;
    }

    public function toArray()
    {
        $array = [
            'name' => $this->name,
            'value' => $this->value,
            'start' => $this->start,
            'end' => $this->end,
        ];

        if ($this->children) {
            foreach($this->children as $rule) {
                $array['children'][] = $rule->toArray();
            }
        }

        return $array;
    }
}