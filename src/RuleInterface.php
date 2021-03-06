<?php
/**
 * @author  Alexander Getmanskii <alexander.get87@gmail.com>
 * @package GetSky\ParserExpressions
 */
namespace GetSky\ParserExpressions;

/**
 * Interface for parsing rules.
 */
interface RuleInterface
{
    /**
     * It analyzes the rules for the transmission of context.
     * If the rule is true, it returns an object of class Result or boolean true.
     * If the rule is not feasible, then the boolean false.
     *
     * @param Context $context
     * @return Result|boolean
     * @throws \Exception
     */
    public function scan(Context $context);
}
