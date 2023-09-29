<?php

	namespace NeoxSeo\NeoxSeoBundle\DependencyInjection;

	use Exception;
	use JetBrains\PhpStorm\NoReturn;
	use Symfony\Component\Config\FileLocator;
	use Symfony\Component\DependencyInjection\ContainerBuilder;
	use Symfony\Component\DependencyInjection\Extension\Extension;
	use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

	class NeoxSeoExtension extends Extension
	{

		/**
		 * @inheritDoc
		 * @throws Exception
		 */
		public function load( array $configs, ContainerBuilder $container ) :void
		{
			$loader = new YamlFileLoader( $container, new FileLocator(__DIR__ . "/../Resources/config") );
			$loader->load("services.yaml");
            
            // set configuration from config file if not set default
            $configuration  = $this->getConfiguration($configs,$container) ;//new Configuration();
            $config         = $this->processConfiguration($configuration, $configs);
            
            // set key config as container parameters
            foreach ($config as $key => $value) {
                $container->setParameter('neox_seo.'.$key, $value);
            }
            
		}
	}