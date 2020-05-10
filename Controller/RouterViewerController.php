<?php

namespace SimonHeimberg\ProfilerViewerBundle\Controller;

use SimonHeimberg\ProfilerViewerBundle\Wrappers\ProfilerReader;
use Symfony\Bundle\WebProfilerBundle\Controller\RouterController;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\RouteCollection;
use Twig\Environment;

class RouterViewerController extends RouterController
{
    public function __construct(ProfilerReader $profiler = null, Environment $twig, UrlMatcherInterface $matcher = null, RouteCollection $routes = null)
    {
        parent:: __construct($profiler, $twig, $matcher, $routes);
    }
}
