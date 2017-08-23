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
            ->arrayNode('auth')->children()
                ->scalarNode('username')->isRequired()->end()
                ->scalarNode('password')->isRequired()->end()
                ->end()->isRequired()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}