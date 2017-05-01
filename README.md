# predis-commands

Adds some useful commands to Predis. 


## Motivation

Any individual redis command is always atomic because Redis is single threaded. In some cases you may want 
to run several redis commands atomically. 

There are two common ways to achieve this: 
[redis transactions][1] and [redis scripts][2]. The first one utilizes `MULTI`/`EXEC` commands to run commands in sequence 
and `WATCH`/`DISCARD` commands for `CAS` optimistic concurrency. The last one is transactional by definition: Redis uses the
same Lua interpreter to run all the commands and guarantees that no other script or Redis command will be executed 
while a script is being executed.

This project uses Lua Scripting approach as it's usually is both simpler and faster. 


## Installation

    composer require angyvolin/predis-commands


## What's included?

As of now, the `predis-commands` project extends predis with following commands:

    ZPOP - Removes and returns the top value in a zset, with its score.
    ZRPOP - Removes and returns the bottom value in a zset, with its score.


## How to use predis-commands ...

### ... in plain PHP

Code snippet below demonstrates how to use `predis-commands` regardless of any framework 

```php
<?php

require __DIR__.'/../vendor/autoload.php';

use Angyvolin\Predis\Command\ZSetPop;
use Angyvolin\Predis\Command\ZSetReversePop;

$client = new Predis\Client();
$client->getProfile()->defineCommand('zpop', ZSetPop::class);
$client->getProfile()->defineCommand('zrpop', ZSetReversePop::class);
```

### ... in Silex application
Code snippet below demonstrates integration with Silex application 

```php
<?php

use Angyvolin\Predis\Command\ZSetPop;
use Angyvolin\Predis\Command\ZSetReversePop;

$app->extend('redis', function ($redis) {
    /* @var \Predis\Client $redis */
    $redis->getProfile()->defineCommand('zpop', ZSetPop::class);
    $redis->getProfile()->defineCommand('zrpop', ZSetReversePop::class);

    return $redis;
});
```


## License

[MIT License](LICENSE.md)


[1]: https://redis.io/topics/transactions
[2]: https://redis.io/commands/eval
