<?php

namespace SimonHeimberg\ProfilerViewerBundle\Wrappers\Traits;

trait RouterV4Trait
{
    public function generate($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH)
    {
        return $this->doGenerate($name, $parameters, $referenceType);
    }

    public function match($pathinfo)
    {
        return $this->doMatch($pathinfo);
    }
}
