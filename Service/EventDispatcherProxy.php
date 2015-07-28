<?php

namespace MCadare\Symfony\EventHubBundle\Service;

use MCadare\EventHub\Service\EventManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;


/**
 * Classe EventManagerProxy
 *
 * Proxy class to symfony event dispatcher
 *
 * Projet : mcadare_bundles
 * Fichier créé par meven.cadare le 28/07/2015 à 09:56
 *
 * @copyright Copyright mcadare_bundles © 2015, All Rights Reserved
 * @author    MCADARE
 * @package MCadare\Symfony\EventHubBundle\Service
 */
class EventDispatcherProxy implements EventManagerInterface
{

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * trigger an event hub downstream event
     *
     * @param $eventName
     * @param $event
     * @param array $params
     */
    public function trigger($eventName, $event = null, $params = [])
    {
        $this->eventDispatcher->dispatch($eventName, $event);
    }
}
