<?php
/**
 * @package GetSky\ParserExpressions
 * @author  Alexander Getmansky <getmansk_y@yandex.ru>
 */
namespace GetSky\ParserExpressions;

/**
 * Result class is used to store the result of the parse.
 */
class Result implements \Iterator, ResultInterface
{

    /**
     * @var string Result string
     */
    protected $name;
    /**
     * @var string Result string
     */
    protected $value;
    /**
     * @var integer Start position
     */
    protected $start;
    /**
     * @var integer Final position
     */
    protected $end;
    /**
     * @var Result[]
     */
    protected $children = [];
    /**
     * @var integer
     */
    private $key = 0;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
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
        $this->value = (string)$value;
        $this->start = $start;
        $this->end = $start + strlen($value);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Added child result
     *
     * @param Result $child
     */
    public function addChild(Result $child)
    {
        $this->children[] = $child;
    }

    /**
     * @return Result
     */
    public function current()
    {
        return $this->children[$this->key];
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        ++$this->key;
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return isset($this->children[$this->key]);
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->key = 0;
    }

    /**
     * Outstanding results in an array.
     *
     * @return array
     */
    public function toArray()
    {
        $array = [
            'name' => $this->name,
            'value' => $this->value,
            'start' => $this->start,
            'end' => $this->end,
        ];

        foreach ($this->children as $rule) {
            $array['children'][] = $rule->toArray();
        }

        return $array;
    }

    /**
     * Search for the first result by name.
     *
     * @param $ruleName
     * @return Result|null
     */
    public function find($ruleName)
    {

        foreach ($this->children as $rule) {
            if ($rule->getName() == $ruleName) {
                return $rule;
            }

            $child = $rule->find($ruleName);
            if ($child !== null) {
                return $child;
            }
        }

        return null;
    }

    /**
     * Search results by name.
     *
     * @param $ruleName
     * @return Result|null
     */
    public function findAll($ruleName)
    {

        $result = [];

        foreach ($this->children as $rule) {
            if ($rule->getName() == $ruleName) {
                $result[] = $rule;
            }

            $child = $rule->findAll($ruleName);
            if ($child !== null) {
                $result = array_merge($result, $child);
            }
        }

        return $result;
    }
}
