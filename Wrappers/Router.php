<?php

namespace SimonHeimberg\ProfilerViewerBundle\Wrappers;

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouterInterface;

/**
 * Wrapper to generate routes pointing to profiler_viewer when in profiler_viewer.
 */
class Router implements RouterInterface
{
    // Overwriting the route generator would be sufficient, but does not work because of how symfony's container is created.

    /**
     * @var RouterInterface wrapped router
     */
    private $inner;

    public function __construct(RouterInterface $router)
    {
        $this->inner = $router;
    }

    public function generate(string $name, array $parameters = [], int $referenceType = self::ABSOLUTE_PATH)
    {
        // rewrites profiler routes when inside profiler viewer
        $pathInfo = $this->inner->getContext()->getPathInfo();
        if (false === strpos($pathInfo, '_profiler') && false === strpos($pathInfo, '_wdt/')) {
            // currently in profiler_viewer
            $newName = preg_replace('/^_profiler/', 'profiler_viewer', $name, 1);
        } else {
            // in normal profiler
            $newName = $name;
        }

        return $this->inner->generate($newName, $parameters, $referenceType);
    }

    public function getContext()
    {
        return $this->inner->getContext();
    }

    public function setContext(RequestContext $context)
    {
        return $this->inner->setContext($context);
    }

    public function match(string $pathinfo)
    {
        return $this->inner->match($pathinfo);
    }

    public function getRouteCollection()
    {
        return $this->inner->getRouteCollection();
    }
}
