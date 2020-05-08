<?php

namespace SimonHeimberg\ProfilerViewerBundle\Wrappers\Traits;

use Symfony\Component\HttpKernel\Profiler\Profile;

trait StorageReaderV5Trait
{
    public function find(?string $ip, ?string $url, ?int $limit, ?string $method, int $start = null, int $end = null, string $statusCode = null): array
    {
        return $this->doFind($ip, $url, $limit, $method, $start, $end, $statusCode);
    }

    public function read(string $token): ?Profile
    {
        return $this->doRead($token);
    }
}
