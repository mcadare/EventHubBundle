<?php

namespace MCadare\Symfony\EventHubBundle;

use MCadare\Symfony\EventHubBundle\DependencyInjection\RegisterEventHubListenerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EventHubBundle extends Bundle
{
    /**
     * Builds the bundle.
     *
     * It is only ever called once when the cache is empty.
     *
     * This method can be overridden to register compilation passes,
     * other extensions, ...
     *
     * add compiler pas to dynamically attach event hub listener to configured business events
     *
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RegisterEventHubListenerCompilerPass());
    }
}
