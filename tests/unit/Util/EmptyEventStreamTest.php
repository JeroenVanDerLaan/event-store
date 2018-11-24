<?php

namespace Jeroenvanderlaan\EventStore\Tests\Unit\Util;

use Jeroenvanderlaan\EventStore\Util\EmptyEventStream;
use Jeroenvanderlaan\EventStore\Tests\Unit\Mock\MockStreamId;
use PHPUnit\Framework\TestCase;

class EmptyEventStreamTest extends TestCase
{
    public function testThatEventsAreEmpty(): void
    {
        $id = new MockStreamId("id");
        $stream = new EmptyEventStream($id, []);
        $this->assertEmpty(iterator_to_array($stream));
    }
}