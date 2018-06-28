<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\DependencyInjection;

use Magenta\Bundle\SWarrantyAdminBundle\Admin\BaseAdmin;
use Magenta\Bundle\SWarrantyAdminBundle\Admin\BaseCRUDAdminController;
use ProxyManager\FileLocator\FileLocator;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class MagentaSWarrantyAdminExtension extends ConfigurableExtension {
	// note that this method is called loadInternal and not load
	protected function loadInternal(array $mergedConfig, ContainerBuilder $container) {
		$loader = new YamlFileLoader($container, new \Symfony\Component\Config\FileLocator(__DIR__ . '/../Resources/config'));

//		$container->registerForAutoconfiguration(BaseCRUDAdminController::class)
//		          ->addTag('controller.service_arguments');
		
		$loader->load('admin.yaml');
		$loader->load('custom_form.yaml');
		
		$definitions = [];
		foreach(get_declared_classes() as $class) {
			if(is_subclass_of($class, CRUDController::class)) {
				$container->getDefinition($class)->addTag('controller.service_arguments');
			} elseif(is_subclass_of($class, BaseAdmin::class)) {
				if(empty($class::AUTO_CONFIG)) {
					continue;
				}
				$className = explode('\\', str_replace('Admin', '', $class));
				
				$def = new Definition();
				$def->setClass($class);
				$def->addTag('sonata.admin', [
					'manager_type'              => 'orm',
					'label'                     => 'sidebar_left.' . strtolower(end($className)),
					'label_translator_strategy' => 'sonata.admin.label.strategy.underscore'
				]);
				$def->addMethodCall('setTemplate', [ 'decide', '@MagentaSWarrantyAdmin/CRUD/decide.html.twig' ]);
				if(empty($code = $class::ADMIN_CODE)) {
					$code = $class;
				}
				if(empty($entity = $class::ENTITY)) {
					$entity = str_replace('Admin\\', 'Entity\\', $code);
					$entity = str_replace('AdminBundle', 'ModelBundle', $entity);
					$entity = str_replace('Admin', '', $entity);
				}
				
				if(empty($controller = $class::CONTROLLER)) {
					$controller = $class . 'Controller';
					if( ! class_exists($controller)) {
						$controller = BaseCRUDAdminController::class;
					}
				}
				
				$def->setArguments([ $code, $entity, $controller ]);
				
				$definitions[ $code ] = $def;
			}
		}
		
		$container->addDefinitions($definitions);
		foreach(get_declared_classes() as $class) {
			if(is_subclass_of($class, CRUDController::class)) {
			} elseif(is_subclass_of($class, BaseAdmin::class)) {
				if(empty($class::AUTO_CONFIG)) {
					continue;
				}
				$className = explode('\\', str_replace('Admin', '', $class));
				$def       = $container->getDefinition($class);
				if( ! empty($children = $class::CHILDREN)) {
					foreach($children as $child => $property) {
						if($child !== $class) {
							$def->addMethodCall('addChild', [ $container->getDefinition($child), $property ]);
						}
					}
				}
			}
		}

//		var_dump($container->getDefinitions());
	}
}