<?php

namespace Jeroenvanderlaan\EventStore\Tests\Unit\Util;

use Jeroenvanderlaan\EventStore\StreamId;
use Jeroenvanderlaan\EventStore\Util\SimpleStreamId;
use Jeroenvanderlaan\EventStore\Tests\Unit\StreamIdTest;

class SimpleStreamIdTest extends StreamIdTest
{
    protected function createStreamId(string $id): StreamId
    {
        return new SimpleStreamId($id);
    }

}