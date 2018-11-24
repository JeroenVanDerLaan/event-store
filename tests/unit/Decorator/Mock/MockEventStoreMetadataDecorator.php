<?php

namespace Jeroenvanderlaan\EventStore\Tests\Unit\Decorator\Mock;

use Jeroenvanderlaan\EventStore\Decorator\EventStoreMetadataDecorator;
use Jeroenvanderlaan\EventStore\EventStream;

class MockEventStoreMetadataDecorator extends EventStoreMetadataDecorator
{
    /**
     * @var
     */
    private $metadata;

    /**
     * @param EventStream $stream
     * @return array
     */
    protected function getMetadata(EventStream $stream): array
    {
        return $this->metadata;
    }

    /**
     * @param array $metadata
     */
    public function setMetadata(array $metadata): void
    {
        $this->metadata = $metadata;
    }

}