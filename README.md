ParserExpressions
=================

Parsing expression grammar, or PEG, is a type of analytic formal grammar.


```php
class MyParser {
   
    public function rule() 
    {
        return new Sequences($this->sOrD(), new Optional('ab'), 'cd');
    }
  
    public function sOrD()
    {
        return new FirstOf('s','d');
    }
}

$runner = new ParserRunner((new MyParser())->rule());

$result = $runner->run('dabcd');

print_r($result->toArray());
/**
 * [ "Sequences" => ["FirstOf" => "d", "Optional" => "ab", "String" => "cd"]]
 */
```
