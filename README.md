# predis-commands

Adds some [Lua][4]-based atomic commands to [Predis][3]. 


## Motivation

Any individual Redis command is always atomic because Redis is single threaded. In some cases you may want to run 
 several Redis commands atomically. 

There are two common ways to achieve this:
 - [Redis transactions][1]. It utilizes `MULTI`/`EXEC` Redis commands to run some commands in sequence 
   It also uses `WATCH`/`DISCARD` Redis commands for `CAS` optimistic concurrency.
 - [Redis scripts][2]. This one is transactional by definition: Redis uses the
same Lua interpreter to run all the commands and guarantees that no other script or Redis command will be executed 
while a script is being executed.

This project uses Lua Scripting approach as it's usually both simpler and faster. 


## Installation

    composer require angyvolin/predis-commands


## What's included?

As of now, the `predis-commands` project extends Predis with following commands:

    ZPOP - Removes and returns the top value in a zset, with its score.
    ZRPOP - Removes and returns the bottom value in a zset, with its score.


## How to use predis-commands ...

### ... in plain PHP

Code snippet below demonstrates how to use `predis-commands` regardless of any framework 

```php
<?php

require __DIR__.'/../vendor/autoload.php';

use Angyvolin\Predis\Command;

$client = new Predis\Client();
$client->getProfile()->defineCommand('zpop', Command\ZSetPop::class);
$client->getProfile()->defineCommand('zrpop', Command\ZSetReversePop::class);
```

### ... in Silex application
Code snippet below demonstrates integration with Silex application 

```php
<?php

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Angyvolin\Predis\Command;

class PredisCommandsServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app->extend('redis', function ($redis) {
            /* @var \Predis\Client $redis */
            $redis->getProfile()->defineCommand('zpop', Command\ZSetPop::class);
            $redis->getProfile()->defineCommand('zrpop', Command\ZSetReversePop::class);
        
            return $redis;
        });
    }
}
```


## License

[MIT License](LICENSE.md)


[1]: https://redis.io/topics/transactions
[2]: https://redis.io/commands/eval
[3]: https://github.com/nrk/predis
[4]: https://www.lua.org/
