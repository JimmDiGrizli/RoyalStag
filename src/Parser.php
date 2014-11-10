<?php
namespace GetSky\ParserExpressions;

class Parser {

    protected $context;

    public function run($string)
    {
        $this->context = new Context($string);
    }
}
