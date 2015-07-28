<?php

namespace MCadare\Symfony\EventHubBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;


/**
 * Classe RegisterFlashMessageListenerCompilerPass
 *
 * attach event hub listener to all configured events
 *
 * Projet : mcadare_bundles
 * Fichier créé par meven.cadare le 22/07/2015 à 11:33
 *
 * @copyright Copyright mcadare_bundles © 2015, All Rights Reserved
 * @author    MCADARE
 * @package MCadare\Symfony\EventHubBundle\DependencyInjection
 */
class RegisterEventHubListenerCompilerPass implements CompilerPassInterface
{

    protected $dispatcherService;

    protected $eventHubListenerService;

    public function __construct(
        $dispatcherService = 'event_dispatcher',
        $eventHubListenerService = 'event_hub_listener'
    ) {
        $this->dispatcherService = $dispatcherService;
        $this->eventHubListenerService = $eventHubListenerService;
    }

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {

        if (!$container->hasDefinition($this->dispatcherService) && !$container->hasAlias($this->dispatcherService)) {
            return;
        }

        $dispatcherDefinition = $container->findDefinition($this->dispatcherService);

        if (!$container->hasDefinition($this->eventHubListenerService) && !$container->hasAlias(
                $this->eventHubListenerService
            )
        ) {
            return;
        }

        $eventHubListenerDefinition = $container->findDefinition($this->eventHubListenerService);

        if (!$eventHubListenerDefinition->isPublic()) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The service "%s" must be public as event listeners are lazy-loaded.',
                    $this->eventHubListenerService
                )
            );
        }

        if ($eventHubListenerDefinition->isAbstract()) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The service "%s" must not be abstract as event listeners are lazy-loaded.',
                    $this->eventHubListenerService
                )
            );
        }



        $config = $container->getExtensionConfig('event_hub');
        $events = array_keys($config[0]);

        foreach ($events as $event) {
            $dispatcherDefinition->addMethodCall(
                'addListenerService',
                array($event, array($this->eventHubListenerService, "handleHubEvent"), 0)
            );
        }
    }
}
