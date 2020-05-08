<?php

namespace SimonHeimberg\ProfilerViewerBundle\Wrappers\Traits;

// inspired by https://github.com/symfony/symfony/commit/121f42641834a7bbe209ba85df32295aca9fe41c

use ReflectionClass;
use Symfony\Component\HttpKernel\Profiler\ProfilerStorageInterface;

$r = new ReflectionClass(ProfilerStorageInterface::class);

if ($r->getMethod('find')->getNumberOfParameters() > 6) {
    trait RouterTrait
    {
        use RouterV5Trait;
    }
} else {
    trait RouterTrait
    {
        use RouterV4Trait;
    }
}
