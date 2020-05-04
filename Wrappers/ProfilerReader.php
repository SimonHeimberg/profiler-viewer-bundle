<?php

namespace SimonHeimberg\ProfilerViewerBundle\Wrappers;

use Symfony\Component\HttpKernel\Profiler\Profiler;

// sets ReaderStorage as storage
class ProfilerReader extends Profiler
{
    public function __construct(StorageReader $readStorage)
    {
        parent::__construct($readStorage);
    }
}
