<?php

namespace SimonHeimberg\ProfilerViewerBundle\Wrappers\Traits;

use Symfony\Component\HttpKernel\Profiler\Profile;

trait StorageReaderV4Trait
{
    public function find($ip, $url, $limit, $method, $start = null, $end = null): array
    {
        return $this->doFind($ip, $url, $limit, $method, $start, $end);
    }

    public function read($token): ?Profile
    {
        return $this->doRead($token);
    }
}
