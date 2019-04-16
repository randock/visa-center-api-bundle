<?php

declare(strict_types=1);

namespace Randock\VisaCenterApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class RandockVisaCenterApiExtension.
 */
class RandockVisaCenterApiExtension extends Extension
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

        $abstractClientDefinition = $container->getDefinition('randock.abstract.visa_center_api_client');
        $abstractClientDefinition->addMethodCall('setTransform', [$config['transform']]);

        // set params
        $container->setParameter('randock_visa_center_api.base_uri', $config['base_uri']);
        $container->setParameter('randock_visa_center_api.version', $config['version']);

        // auth
        if (isset($config['auth']['username']) && isset($config['auth']['password'])) {
            $container->setParameter(
                'randock_visa_center_api.auth',
                [
                    $config['auth']['username'],
                    $config['auth']['password']
                ]
            );
        } else if (isset($config['auth']['credentials_provider'])) {

            $definition = $container->getDefinition('randock.abstract.visa_center_api_client');
            $definition->addMethodCall(
                'setCredentialsProvider',
                [
                    new Reference(
                        $config['auth']['credentials_provider']
                    )
                ]
            );

            // remove the "auth" constructor argument
            $definition->replaceArgument(2, null);

        } else {
            throw new InvalidConfigurationException('You must specify either username and password or a credentials_provider under the auth section.');
        }

    }
}
