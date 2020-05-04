<?php

namespace SimonHeimberg\ProfilerViewerBundle\Controller;

use SimonHeimberg\ProfilerViewerBundle\Wrappers\ProfilerReader;
use Symfony\Bundle\WebProfilerBundle\Controller\ProfilerController;
use Symfony\Bundle\WebProfilerBundle\Csp\ContentSecurityPolicyHandler;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class ProfilerViewerController extends ProfilerController
{
    public function __construct(UrlGeneratorInterface $generator, ProfilerReader $profiler, Environment $twig, array $templates = ['TEMP'], ContentSecurityPolicyHandler $cspHandler = null, string $baseDir = null)
    {
        // todo set basedir to project root of files to view
        parent::__construct($generator, $profiler, $twig, $templates, $cspHandler, $baseDir);
    }
}
