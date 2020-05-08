<?php

namespace SimonHeimberg\ProfilerViewerBundle\Wrappers\Traits;

trait RouterV5Trait
{
    public function generate(string $name, array $parameters = [], int $referenceType = self::ABSOLUTE_PATH)
    {
        return $this->doGenerate($name, $parameters, $referenceType);
    }

    public function match(string $pathinfo)
    {
        return $this->doMatch($pathinfo);
    }
}
