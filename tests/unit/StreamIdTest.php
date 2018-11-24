<?php

namespace Jeroenvanderlaan\EventStore\Tests\Unit;

use Jeroenvanderlaan\EventStore\StreamId;
use PHPUnit\Framework\TestCase;

abstract class StreamIdTest extends TestCase
{
    abstract protected function createStreamId(string $id): StreamId;

    public function testToString(): void
    {
        $id = $this->createStreamId("id");
        $this->assertEquals("id", $id->toString());
    }

    public function testCastToString(): void
    {
        $id = $this->createStreamId("id");
        $this->assertEquals("id", (string) $id);
    }

    public function testEquals(): void
    {
        $id = $this->createStreamId("id");
        $clone = $this->createStreamId("id");
        $this->assertTrue($id->equals($clone));
    }

    public function testNotEquals(): void
    {
        $id = $this->createStreamId("id-1");
        $another = $this->createStreamId("id-2");
        $this->assertFalse($id->equals($another));
    }
}