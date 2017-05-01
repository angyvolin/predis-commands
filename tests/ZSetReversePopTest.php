<?php

namespace Angyvolin\Predis\Command\Tests;

use Angyvolin\Predis\Command\ZSetReversePop;
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
        return ZSetReversePop::class;
    }

    /**
     * {@inheritdoc}
     */
    protected function getExpectedId()
    {
        return 'EVALSHA';
    }

    public function testFilterArguments()
    {
        $command = $this->getCommand();
        $command->setArguments(['key']);

        $this->assertSame(['77d83487b1ff942c692a299a6b0365dfb09ae500', 1, 'key'], $command->getArguments());
    }

    public function testParseResponse()
    {
        $this->assertSame(1, $this->getCommand()->parseResponse(1));
    }

    /**
     * @group disconnected
     */
    public function testPopsTheLastElementFromZSet()
    {
        $redis = $this->getClient();

        $redis->zadd('letters', 1, 'a', 2.5, 'b');
        $this->assertSame(['a', '1'], $redis->zrpop('letters'));
        $this->assertSame(['b', '2.5'], $redis->zrpop('letters'));
    }

    /**
     * @group disconnected
     */
    public function testReturnsEmptyArrayOnEmptyZSet()
    {
        $this->assertSame([], $this->getClient()->zrpop('letters'));
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
        $redis->zrpop('foo');
    }

    /**
     * {@inheritdoc}
     */
    public function getClient($flushDb = true)
    {
        $redis = parent::getClient($flushDb);
        $redis->getProfile()->defineCommand('zrpop', ZSetReversePop::class);

        return $redis;
    }
}
