<?php

namespace SimonHeimberg\ProfilerViewerBundle\Controller;

use Symfony\Bundle\WebProfilerBundle\Controller\ExceptionController;
use Symfony\Component\HttpKernel\Debug\FileLinkFormatter;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Twig\Environment;

class ExceptionPanelViewerController extends ExceptionController
{
    public function __construct(Profiler $profiler = null, Environment $twig, bool $debug, FileLinkFormatter $fileLinkFormat = null)
    {
        // $fileLinkFormat only for sy4
        parent::__construct($profiler, $twig, $debug, $fileLinkFormat);
    }
}
