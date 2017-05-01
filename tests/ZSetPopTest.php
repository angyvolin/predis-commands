<?php

namespace Angyvolin\Predis\Command\Tests;

use Angyvolin\Predis\Command\ZSetPop;
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
        return ZSetPop::class;
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

    /**
     * @group disconnected
     */
    public function testPopsTheFirstElementFromZSet()
    {
        $redis = $this->getClient();

        $redis->zadd('letters', 1, 'a', 2.5, 'b');
        $this->assertSame(['b', '2.5'], $redis->zpop('letters'));
        $this->assertSame(['a', '1'], $redis->zpop('letters'));
    }

    /**
     * @group disconnected
     */
    public function testReturnsEmptyArrayOnEmptyZSet()
    {
        $this->assertSame([], $this->getClient()->zpop('letters'));
    }

    /**
     * @group disconnected
     * @expectedException \Predis\Response\ServerException
     * @expectedExceptionMessage Operation against a key holding the wrong kind of value
     */
    public function testThrowsExceptionOnWrongType()
    {
        $redis = $this->getClient();

        $redis->set('foo', 'bar');
        $redis->zpop('foo');
    }

    /**
     * {@inheritdoc}
     */
    public function getClient($flushDb = true)
    {
        $redis = parent::getClient($flushDb);
        $redis->getProfile()->defineCommand('zpop', ZSetPop::class);

        return $redis;
    }
}
