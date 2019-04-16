<?php


namespace Randock\VisaCenterApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('randock_visa_center_api');

        $rootNode
            ->children()
            ->scalarNode('base_uri')->isRequired()->end()
            ->scalarNode('version')->isRequired()->end()
            ->booleanNode('transform')->defaultFalse()->end()
            ->arrayNode('auth')->children()
                ->scalarNode('username')->end()
                ->scalarNode('password')->end()
                ->scalarNode('credentials_provider')->end()
            ->end()->isRequired()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}