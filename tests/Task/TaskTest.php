<?php


namespace tests\Task;

use PHPUnit\Framework\TestCase;
use Task\Task;

/**
 * @covers \Task\Task
 */
class TaskTest extends TestCase
{
    /**
     * @test
     * @dataProvider validData
     */
    public function willReturnCorrectValue(string $text, int $result) : void
    {
        $task = new Task();

        $this->assertSame($result, $task->sameThreeLettersCount($text));
    }

    public function validData() : array
    {
        return [
            'text1' => ['', 0],
            'text2' => ['deoooxxa', 1],
            'text3' => ['sificccosaaae', 2],
            'text4' => ['ddddddddd', 7],
            'text5' => ['idlllpooogggrrffff', 5],
            'text6' => ['qwertyuu u', 0],
            'text7' => ['   ', 1],
            'text8' => ['ttt   999...', 4],
        ];
    }
}
