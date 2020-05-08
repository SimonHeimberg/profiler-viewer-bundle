<?php

namespace SimonHeimberg\ProfilerViewerBundle\Wrappers;

use Symfony\Component\HttpKernel\Profiler\Profile;
use Symfony\Component\HttpKernel\Profiler\ProfilerStorageInterface;

/**
 * Profiler storage with read only access to the given path.
 */
class StorageReader implements ProfilerStorageInterface
{
    use Traits\StorageReaderTrait;

    /**
     * @var ProfilerStorageInterface wrapped storage
     */
    private $storage;

    /**
     * @var string stores the path for displaying
     */
    private $folder;

    public function __construct(string $profilerPath)
    {
        $this->folder = $profilerPath;
        if (false === strpos($profilerPath, ':')) {
            $profilerPath = 'file:'.$profilerPath;
        }
        if (empty($_ENV['PROFILER_VIEWER_PROFILER_STORAGE'])) {
            $profilerStorage = 'Symfony\Component\HttpKernel\Profiler\FileProfilerStorage';
        } else {
            $profilerStorage = $_ENV['PROFILER_VIEWER_PROFILER_STORAGE'];
        }
        $storage = new $profilerStorage($profilerPath);
        $this->setStorage($storage);
    }

    protected function doFind(?string $ip, ?string $url, ?int $limit, ?string $method, int $start = null, int $end = null, string $statusCode = null): array
    {
        return $this->storage->find($ip, $url, $limit, $method, $start, $end, $statusCode);
    }

    protected function doRead(string $token): ?Profile
    {
        $profile = $this->storage->read($token);
        if (null !== $profile) {
            $profile->storagePath = $this->folder;
        }

        return $profile;
    }

    public function write(Profile $profile): bool
    {
        throw new \RuntimeException('not supported, read only');
    }

    public function purge()
    {
        throw new \RuntimeException('not supported, read only');
    }

    private function setStorage(ProfilerStorageInterface $storage)
    {
        $this->storage = $storage;
    }
}
