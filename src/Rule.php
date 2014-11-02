<?php
namespace GetSky\ParserExpressions;

interface Rule {
    public function scan(Context $context);
}
