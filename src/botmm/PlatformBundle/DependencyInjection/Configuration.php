<?php

namespace botmm\PlatformBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('botmm_platform');

        $rootNode
            ->children()
                ->arrayNode('apk')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('version')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('apk_id')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('apk_version')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('sign')->isRequired()->cannotBeEmpty()->end()
                    ->end()
                ->end()
                ->arrayNode('android')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('imei')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('version')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('appId')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('pcVersion')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('osType')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('osVersion')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('imsi')->isRequired()->cannotBeEmpty()->end()
                         ->scalarNode('device')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('deviceType')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('guid')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('deviceBrand')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('android_device_id')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('android_device_mac_hash')->isRequired()->cannotBeEmpty()->end()
                    ->end()
                ->end()
                ->arrayNode('network')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('bssid')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('ssid')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('networkType')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('netDetail')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('apn')->isRequired()->end()
                        ->scalarNode('mac')->isRequired()->end()
                        ->scalarNode('client_ip')->isRequired()->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
