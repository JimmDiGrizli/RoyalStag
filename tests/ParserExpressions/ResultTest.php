<?php

use GetSky\ParserExpressions\Context;
use GetSky\ParserExpressions\Error;
use GetSky\ParserExpressions\ErrorCollectionInterface;
use GetSky\ParserExpressions\ErrorInterface;
use GetSky\ParserExpressions\Result;

class ResultTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider providerName
     * @param $name
     */
    public function testCreateResult($name)
    {
        $result = new Result($name);
        $this->assertSame($name, $result->getName());
    }

    /**
     * @dataProvider providerResult
     * @param $results
     */
    public function testForeachResult($results)
    {
        $testResult = new Result('Root');
        $this->assertSame(0, $testResult->key());
        $this->assertSame(false, $testResult->valid());

        foreach ($results as $result) {
            $testResult->addChild($result);
        }

        foreach ($testResult as $key => $child) {
            $this->assertSame(true, $testResult->valid());
            $this->assertSame($results[$key], $testResult->current());
            $this->assertSame($key, $testResult->key());
        }

        $this->assertSame(count($results), $testResult->key());
        $this->assertSame(false, $testResult->valid());
        $testResult->rewind();
        $this->assertSame(0, $testResult->key());
        $testResult->next();
        $this->assertSame(1, $testResult->key());
    }

    /**
     * @dataProvider providerArray
     * @param $results
     * @param $array
     */
    public function testToArray($results, $array)
    {
        $testResult = new Result('Root');

        foreach ($results as $result) {
            $testResult->addChild($result);
        }

        $this->assertSame($array, $testResult->toArray());
    }

    /**
     * @dataProvider providerFind
     * @param $results
     * @param $find
     * @param $founded
     */
    public function testFind($results, $find, $founded)
    {
        $testResult = new Result('Root');
        foreach ($results as $result) {
            $testResult->addChild($result);
        }
       if ($founded === null) {
            $this->assertSame(null, $testResult->find($find));
       } else {
            $this->assertSame($results[$founded], $testResult->find($find));
       }


    }

    /**
     * @dataProvider providerFindAll
     * @param $results
     * @param $find
     * @param $founded
     */
    public function testFindAll($results, $find, $founded)
    {
        $testResult = new Result('Root');
        foreach ($results as $result) {
            $testResult->addChild($result);
        }
        if ($founded === []) {
            $this->assertSame([], $testResult->findAll($find));
       } else {
            $this->assertSame([$results[$founded]], $testResult->findAll($find));
       }


    }

    public function providerName()
    {
        return [['FirstOf'], ['MyTestName']];
    }

    public function providerResult()
    {
        return [
            [[new Result('FirstOf'), new Result('Any'), new Result('EOI')]],
            [[new Result('FirstOf')]],
            [[new Result('FirstOf'), new Result('Any'), new Result('EOI'), new Result('Test')]],
            [[]],
        ];
    }

    public function providerArray()
    {
        return [
            [
                [new Result('FirstOf'), new Result('Any'), new Result('EOI')],
                [
                'name'=>'Root',
                'value'=>null,
                'start'=>null,
                'end'=>null,
                'children'=>[
                    [
                        'name'=>'FirstOf',
                        'value'=>null,
                        'start'=>null,
                        'end'=>null
                    ],
                    [
                        'name'=>'Any',
                        'value'=>null,
                        'start'=>null,
                        'end'=>null
                    ],
                    [
                        'name'=>'EOI',
                        'value'=>null,
                        'start'=>null,
                        'end'=>null
                    ],
                ]
                ]
            ],
            [
                [new Result('FirstOf')],
                [
                    'name'=>'Root',
                    'value'=>null,
                    'start'=>null,
                    'end'=>null,
                    'children'=>[
                        [
                            'name'=>'FirstOf',
                            'value'=>null,
                            'start'=>null,
                            'end'=>null
                        ]
                    ]
                ]
            ],
            [
                [new Result('FirstOf'), new Result('Any'), new Result('EOI'), new Result('Test')],
                [
                    'name'=>'Root',
                    'value'=>null,
                    'start'=>null,
                    'end'=>null,
                    'children'=>[
                        [
                            'name'=>'FirstOf',
                            'value'=>null,
                            'start'=>null,
                            'end'=>null
                        ],
                        [
                            'name'=>'Any',
                            'value'=>null,
                            'start'=>null,
                            'end'=>null
                        ],
                        [
                            'name'=>'EOI',
                            'value'=>null,
                            'start'=>null,
                            'end'=>null
                        ],
                        [
                            'name'=>'Test',
                            'value'=>null,
                            'start'=>null,
                            'end'=>null
                        ],
                    ]
                ]
            ],
            [
                [],
                [
                    'name'=>'Root',
                    'value'=>null,
                    'start'=>null,
                    'end'=>null
                ]
            ]
        ];
    }

    public function providerFind()
    {
        return [
            [
                [new Result('FirstOf'), new Result('Any'), new Result('EOI')],
                'Any',
                1
            ],
            [
                [new Result('FirstOf')],
                'Last',
                null
            ],
            [
                [new Result('FirstOf'), new Result('Any'), new Result('EOI'), new Result('Test')],
                'EOI',
                2
            ],
            [
                [],
                'FirstOf',
                null
            ]
        ];
    }

    public function providerFindAll()
    {
        return [
            [
                [new Result('FirstOf'), new Result('Any'), new Result('EOI')],
                'Any',
                1
            ],
            [
                [new Result('FirstOf')],
                'Last',
                []
            ],
            [
                [new Result('FirstOf'), new Result('Any'), new Result('EOI'), new Result('Test')],
                'EOI',
                2
            ],
            [
                [],
                'FirstOf',
                []
            ]
        ];
    }
}
