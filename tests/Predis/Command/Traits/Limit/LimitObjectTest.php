<?php

/*
 * This file is part of the Predis package.
 *
 * (c) 2009-2020 Daniele Alessandri
 * (c) 2021-2023 Till Krüss
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Command\Traits\Limit;

use Predis\Command\Argument\Server\LimitOffsetCount;
use Predis\Command\Command as RedisCommand;
use PredisTestCase;

class LimitObjectTest extends PredisTestCase
{
    private $testClass;

    protected function setUp(): void
    {
        parent::setUp();

        $this->testClass = new class extends RedisCommand {
            use LimitObject;

            public function getId()
            {
                return 'test';
            }
        };
    }

    /**
     * @dataProvider argumentsProvider
     * @param  array $actualArguments
     * @param  array $expectedArguments
     * @return void
     */
    public function testReturnsCorrectArguments(array $actualArguments, array $expectedArguments): void
    {
        $this->testClass->setArguments($actualArguments);

        $this->assertSame($expectedArguments, $this->testClass->getArguments());
    }

    public function argumentsProvider(): array
    {
        return [
            'with non-existing LimitInterface' => [
                ['value'],
                ['value'],
            ],
            'with existing LimitInterface' => [
                [new LimitOffsetCount(0, 1)],
                ['LIMIT', 0, 1],
            ],
        ];
    }
}
