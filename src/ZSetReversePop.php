<?php

namespace Angyvolin\Predis\Command;

use Predis\Command\ScriptCommand;

/**
 * Removes and returns the bottom value in a zset, with its score.
 */
class ZSetReversePop extends ScriptCommand
{
    const BODY = <<<LUA
local result = redis.call('ZRANGE', KEYS[1], 0, 0, "WITHSCORES")
if result then redis.call('ZREMRANGEBYRANK', KEYS[1], 0, 0) end
return result
LUA;

    /**
     * {@inheritdoc}
     */
    public function getKeysCount()
    {
        return 1;
    }

    /**
     * {@inheritdoc}
     */
    public function getScript()
    {
        return self::BODY;
    }
}
