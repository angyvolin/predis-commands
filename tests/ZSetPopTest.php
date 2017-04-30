<?php

namespace Angyvolin\Predis\Command\Tests;

use Predis\Command\PredisCommandTestCase;

/**
 * @group commands
 * @group realm-z
 */
class ZSetPopTest extends PredisCommandTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getExpectedCommand()
    {
        return 'Angyvolin\Predis\Command\ZSetPop';
    }

    /**
     * {@inheritdoc}
     */
    protected function getExpectedId()
    {
        return 'EVALSHA';
    }

    /**
     * @group disconnected
     */
    public function testFilterArguments()
    {
        $command = $this->getCommand();
        $command->setArguments(['key']);

        $this->assertSame(['a003dd1247fb1f3043a791c365380858f09dca26', 1, 'key'], $command->getArguments());
    }

    /**
     * @group disconnected
     */
    public function testParseResponse()
    {
        $this->assertSame(1, $this->getCommand()->parseResponse(1));
    }
}
