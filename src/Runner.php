<?php
/**
 * @author  Alexander Getmanskii <alexander.get87@gmail.com>
 * @package GetSky\ParserExpressions
 */
namespace GetSky\ParserExpressions;

class Runner
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var RuleInterface
     */
    protected $rule;

    /**
     * @var ErrorCollectionInterface
     */
    protected $errors;

    /**
     * @param RuleInterface $rule
     * @param Context $context
     * @param ErrorCollectionInterface $errors
     */
    public function __construct(RuleInterface $rule, Context $context = null, ErrorCollectionInterface $errors = null)
    {
        $this->rule = $rule;
        $this->errors = !$errors ? new ErrorCollection() : $errors;
        $this->context = !$context ? new Context($this->errors) : $context;
    }

    /**
     * @param string $string
     * @return bool|Result
     */
    public function run($string)
    {
        $this->context->setString($string);

        return $this->rule->scan($this->context);
    }

    /**
     * @return bool|ParsingErrorInterface
     */
    public function hasError()
    {
        $error = $this->errors->findMaxErrors();
        if ($error) {
            return $error;
        }

        return false;
    }
}
