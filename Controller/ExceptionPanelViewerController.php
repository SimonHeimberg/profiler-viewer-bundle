<?php

namespace SimonHeimberg\ProfilerViewerBundle\Controller;

use SimonHeimberg\ProfilerViewerBundle\Wrappers\ProfilerReader;
use Symfony\Bundle\WebProfilerBundle\Controller\ExceptionPanelController;
use Symfony\Component\ErrorHandler\ErrorRenderer\HtmlErrorRenderer;

class ExceptionPanelViewerController extends ExceptionPanelController
{
    public function __construct(HtmlErrorRenderer $errorRenderer, ProfilerReader $profiler = null)
    {
        parent::__construct($errorRenderer, $profiler);
    }
}
