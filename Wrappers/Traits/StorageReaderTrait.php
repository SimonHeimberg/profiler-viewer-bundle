<?php

namespace SimonHeimberg\ProfilerViewerBundle\Wrappers\Traits;

use ReflectionClass;
use Symfony\Component\HttpKernel\Profiler\ProfilerStorageInterface;

$r = new ReflectionClass(ProfilerStorageInterface::class);

if ($r->getMethod('find')->getNumberOfParameters() > 6) {
    trait StorageReaderTrait
    {
        use StorageReaderV5Trait;
    }
} else {
    trait StorageReaderTrait
    {
        use StorageReaderV4Trait;
    }
}
