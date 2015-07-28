<?php

namespace MCadare\Symfony\EventHubBundle\DependencyInjection;

use MCadare\EventHub\Constant\Configs;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('mcadare_event_hub');
        $rootNode
            ->requiresAtLeastOneElement()
            ->useAttributeAsKey('event')
            ->prototype('array')
            ->children()
                ->append($this->addMailPrototype())
                ->append($this->addFlashMessagePrototype())
            ->end();

        return $treeBuilder;
    }

    private function addMailPrototype()
    {
        $builder = new TreeBuilder();

        $node = $builder->root(Configs::MAIL_KEY);
        $node
            ->requiresAtLeastOneElement()
            ->useAttributeAsKey(Configs::STATUS_KEY)
            ->prototype('scalar')
            ->end()
        ;

        return $node;
    }

    private function addFlashMessagePrototype()
    {
        $builder = new TreeBuilder();

        $node = $builder->root(Configs::FLASH_KEY);
        $node
            ->requiresAtLeastOneElement()
            ->useAttributeAsKey(Configs::STATUS_KEY)
            ->prototype('array')
                ->children()
                    ->scalarNode(Configs::FLASH_MESSAGE_LEVEL_KEY)->defaultValue('info')->end()
                    ->scalarNode(Configs::FLASH_MESSAGE_CODE_KEY)->end()
                ->end()
            ->end()
        ;
        return $node;
    }
}
