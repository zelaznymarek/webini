<?php

namespace tests\Task;

use PHPUnit\Framework\TestCase;
use Task\TextManipulator;
use Task\Task;

/**
 * @covers \Task\TextManipulator
 */
class TextManipulatorTest extends TestCase
{
    /**
     * @test
     * @dataProvider textProvider
     */
    public function willReturnProperAlphanumsNumber(string $text, int $result) : void
    {
        /** @var TextManipulator */
        $manipulator = new TextManipulator($text);

        $this->assertSame($result, $manipulator->countAlphanums());
    }

    /**
     * @test
     * @dataProvider wordsProvider
     */
    public function willReturnProperWordsNumber(string $text, int $result) : void
    {
        /** @var TextManipulator */
        $manipulator = new TextManipulator($text);

        $this->assertSame($result, $manipulator->countWords());
    }

    /**
     * @test
     * @dataProvider textToReplaceProvider
     */
    public function replace(string $text, string $result) : void
    {
        /** @var TextManipulator */
        $manipulator = new TextManipulator($text);

        $manipulator->replace('and', 'but');

        $this->assertSame($result, $manipulator->getText());
    }

    /**
     * @test
     * @dataProvider aggregateDataProvider
     */
    public function willAggregateWordsCorrectly(string $text, array $result) : void
    {
        /** @var TextManipulator */
        $manipulator = new TextManipulator($text);

        $this->assertSame($result, $manipulator->aggregateWords());
    }

    /**
     * @test
     * @dataProvider estimationDataProvider
     */
    public function willEstimateTimeCorrectly(string $text, int $result) : void
    {
        /** @var TextManipulator */
        $manipulator = new TextManipulator($text);

        $this->assertSame($result, $manipulator->estimateTime());
    }

    /********************* Data providers *********************/

    public function textProvider() : array
    {

        return [
            'data1' => [file_get_contents(__DIR__ . '/article.txt'), 84],
            'data2' => [file_get_contents(__DIR__ . '/textfile'), 36],
            'data3' => ['some text with 00000 whitespaces $peci@l sign$ & new lines', 45]
        ];
    }

    public function wordsProvider() : array
    {

        return [
            'data1' => [file_get_contents(__DIR__ . '/article.txt'), 14],
            'data2' => [file_get_contents(__DIR__ . '/textfile'), 8],
            'data3' => ['some text with ^^^^^ whitespaces special signs & new lines', 8]
        ];
    }

    public function textToReplaceProvider() : array
    {
        return [
            'data1' => [
                'I like food and drink and swimm andandand',
                'I like food but drink but swimm butbutbut'
            ]
        ];
    }

    public function aggregateDataProvider() : array
    {
        return [
            'data1' =>
            [
                '!Stuff aggregate  words,,,, and words   and other 
                stuff and all:::',
                [
                    'and' => 3,
                    'stuff' => 2,
                    'words' => 2,
                    'aggregate' => 1,
                    'other' => 1,
                    'all' => 1,
                ]
            ]
        ];
    }

    public function estimationDataProvider() : array
    {
        return [
            'data1' => [file_get_contents(__DIR__ . '/article.txt'), 3]
        ];
    }
}
