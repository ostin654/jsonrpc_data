<?php

namespace App;

use Yoanm\JsonRpcServer\Domain\JsonRpcMethodAwareInterface;
use Yoanm\JsonRpcServer\Domain\JsonRpcMethodInterface;

class MappingCollector implements JsonRpcMethodAwareInterface
{
    private $mappingList = [];

    public function addJsonRpcMethod(string $methodName, JsonRpcMethodInterface $method): void
    {
        $this->mappingList[$methodName] = $method;
    }

    public function getMappingList(): array
    {
        return $this->mappingList;
    }
}