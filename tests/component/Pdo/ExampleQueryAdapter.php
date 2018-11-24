<?php

namespace Jeroenvanderlaan\EventStore\Tests\Component\Pdo;

use Jeroenvanderlaan\EventStore\Pdo\QueryAdapter;
use Jeroenvanderlaan\EventStore\StreamId;

class ExampleQueryAdapter implements QueryAdapter
{
    /**
     * @return string
     */
    public function getCreateTableQuery(): string
    {
        return "CREATE TABLE IF NOT EXISTS `event_store` (`stream_id` TEXT, `event` TEXT)";
    }

    /**
     * @return string
     */
    public function getDropTableQuery(): string
    {
        return "DROP TABLE IF EXISTS `event_store;`";
    }

    /**
     * @param StreamId $id
     * @param array $options
     * @return string
     */
    public function getReadStreamQuery(StreamId $id, array $options = []): string
    {
        return "SELECT `event` FROM `event_store` WHERE stream_id = :id;";
    }

    /**
     * @param StreamId $id
     * @param array $options
     * @return array
     */
    public function getReadStreamParameters(StreamId $id, array $options = []): array
    {
        return ["id" => $id->toString()];
    }

    /**
     * @param StreamId $id
     * @param iterable $events
     * @return string
     */
    public function getAppendToStreamQuery(StreamId $id, iterable $events): string
    {
        $query = "INSERT INTO `event_store` (`stream_id`, `event`) VALUES ";
        foreach ($events as $event) {
            $query .= "(?, ?),";
        }
        return rtrim($query, ",") . ";";
    }

    /**
     * @param StreamId $id
     * @param iterable $events
     * @return array
     */
    public function getAppendToStreamParameters(StreamId $id, iterable $events): array
    {
        $id = $id->toString();
        $parameters = [];
        foreach ($events as $event) {
            $parameters[] = $id;
            $parameters[] = $event["event"];
        }
        return $parameters;
    }

}