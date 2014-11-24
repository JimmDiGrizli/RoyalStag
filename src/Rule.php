<?php
namespace GetSky\ParserExpressions;

/**
 * Interface for parsing rules.
 *
 * @package GetSky\ParserExpressions
 * @author  Alexander Getmansky <getmansk_y@yandex.ru>
 */
interface Rule
{
    /**
     * It analyzes the rules for the transmission of context.
     * If the rule is true, it returns an object of class Result or boolean true.
     * If the rule is not feasible, then the boolean false.
     *
     * @param Context $context
     * @return Result|boolean
     */
    public function scan(Context $context);
}
