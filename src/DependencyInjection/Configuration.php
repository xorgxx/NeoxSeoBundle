<?php
    
    namespace NeoxSeo\NeoxSeoBundle\DependencyInjection;
    
    use Symfony\Component\Config\Definition\Builder\TreeBuilder;
    use Symfony\Component\Config\Definition\ConfigurationInterface;
    
    class Configuration implements ConfigurationInterface
    {
        public function getConfigTreeBuilder(): TreeBuilder
        {
            $treeBuilder    = new TreeBuilder('neox_seo');
            $rootNode       = $treeBuilder->getRootNode();
            $rootNode
                ->addDefaultsIfNotSet()
                ->children()
                    ->arrayNode('seo')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('title')->defaultValue("Setup neox_seo.yaml !!")->end()
                            ->scalarNode('charset')->defaultValue("UTF-8")->end()
                            ->arrayNode('link')
                                ->normalizeKeys(false)
                                ->useAttributeAsKey('element')
                                ->prototype('scalar')->end()
                                ->defaultValue([])
                            ->end()
                            ->arrayNode('html')
                                ->normalizeKeys(false)
                                ->useAttributeAsKey('element')
                                ->prototype('scalar')->end()
                                ->defaultValue([])
                            ->end()
                            ->arrayNode('metas')
                                ->children()
                                    ->arrayNode('metasHttpEquiv')
                                        ->normalizeKeys(false)
                                        ->useAttributeAsKey('element')
                                        ->prototype('scalar')->end()
                                        ->defaultValue([])
                                    ->end()
                                    ->arrayNode('metasName')
                                        ->normalizeKeys(false)
                                        ->useAttributeAsKey('element')
                                        ->prototype('scalar')->end()
                                        ->defaultValue([])
                                    ->end()
                                    ->arrayNode('metasProperty')
                                        ->normalizeKeys(false)
                                        ->useAttributeAsKey('element')
                                        ->prototype('scalar')->end()
                                        ->defaultValue([])
                                    ->end()
                                    ->arrayNode('metasItemprop')
                                        ->normalizeKeys(false)
                                        ->useAttributeAsKey('element')
                                        ->prototype('scalar')->end()
                                        ->defaultValue([])
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                    ->booleanNode('save_notify')->defaultTrue()->end()
                ->end();
            
            return $treeBuilder;
        }
    }