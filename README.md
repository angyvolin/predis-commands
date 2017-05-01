# predis-commands
Adds some useful commands to Predis. 

## Installation

    composer require angyvolin/predis-commands

## What's included?
As of now, the `predis-commands` project extends predis with following commands:

    * ZPOP - Removes and returns the top value in a zset, with its score.
    * ZRPOP - Removes and returns the bottom value in a zset, with its score.

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
