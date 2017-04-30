<?php

namespace Angyvolin\Predis\Command;

use Predis\Command\ScriptCommand;

/**
 * Removes and returns the top value in a zset, with its score.
 */
class ZSetPop extends ScriptCommand
{
    const BODY = <<<LUA
local result = redis.call('ZRANGE', KEYS[1], -1, -1, "WITHSCORES")
if result then redis.call('ZREMRANGEBYRANK', KEYS[1], -1, -1) end
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
