<?php

namespace Magenta\Bundle\SWarrantyApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface {
	public function getConfigTreeBuilder() {
		$treeBuilder = new TreeBuilder();
		$rootNode    = $treeBuilder->root('magenta_swarranty_api');
		
		$rootNode
			->children()
			->arrayNode('bundles')
				->prototype('scalar')->end()
			
//						->children()
//							->arrayNode('classes')->end()
//						->end()
			->end()// bundles
			->arrayNode('components')
			->prototype('scalar')->end()
			->end()// components
			->arrayNode('sites')
				->prototype('scalar')->end()
			->end()//  sites
			->scalarNode('library_source')->end()
			->scalarNode('library_workspace')->end()
			->end();
		
		return $treeBuilder;
	}
}