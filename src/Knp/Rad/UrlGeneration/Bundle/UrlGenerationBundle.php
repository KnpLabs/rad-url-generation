<?php

namespace Knp\Rad\UrlGeneration\Bundle;

use Knp\Rad\UrlGeneration\DependencyInjection\UrlGenerationExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class UrlGenerationBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new UrlGenerationExtension;
    }
}
