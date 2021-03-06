<?php

declare(strict_types=1);

namespace Clouding\Presto\Tests\Collector;

use Clouding\Presto\Collectors\AssocCollector;
use PHPUnit\Framework\TestCase;

class AssocCollectorTest extends TestCase
{
    public function testGet()
    {
        $collector = new AssocCollector();

        $this->assertEmpty($collector->get());
    }

    public function testCollect()
    {
        $object1 = (object) [
            'columns' => [
                ['name' => 'id'],
                ['name' => 'title'],
            ],
            'data' => [
                [1, 'Go to school']
            ]
        ];

        $object2 = (object) [
            'columns' => [
                ['name' => 'id'],
                ['name' => 'title'],
            ],
            'data' => [
                [2, 'Go to store']
            ]
        ];

        $collector = new AssocCollector();
        $collector->collect($object1);
        $collector->collect($object2);

        $expected = [
            ['id' => 1, 'title' => 'Go to school'],
            ['id' => 2, 'title' => 'Go to store']
        ];
        $this->assertSame($expected, $collector->get());
    }

    public function testCollectNothing()
    {
        $collector = new AssocCollector();
        $collector->collect((object) ['apple']);

        $this->assertEmpty($collector->get());
    }
}
