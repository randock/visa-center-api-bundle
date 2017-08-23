<?php

declare(strict_types=1);

namespace Randock\VisaCenterApiBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

/**
 * Class VisaCenterApiClientExtension.
 */
class VisaCenterApiClientExtension extends Extension
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(
            __DIR__.'/../Resources/config'
        ));
        $loader->load('services.yml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // set params
        $container->setParameter('randock_visa_center_api.base_uri', $config['base_uri']);
        $container->setParameter('randock_visa_center_api.version', $config['version']);
        $container->setParameter('randock_visa_center_api.auth', $config['auth']);


    }
}
