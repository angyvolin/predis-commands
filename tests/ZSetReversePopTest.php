<?php

namespace Angyvolin\Predis\Command\Tests;

use Predis\Command\PredisCommandTestCase;

/**
 * @group commands
 * @group realm-z
 */
class ZSetReversePopTest extends PredisCommandTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getExpectedCommand()
    {
        return 'Angyvolin\Predis\Command\ZSetReversePop';
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

        $this->assertSame(['77d83487b1ff942c692a299a6b0365dfb09ae500', 1, 'key'], $command->getArguments());
    }

    /**
     * @group disconnected
     */
    public function testParseResponse()
    {
        $this->assertSame(1, $this->getCommand()->parseResponse(1));
    }
}
