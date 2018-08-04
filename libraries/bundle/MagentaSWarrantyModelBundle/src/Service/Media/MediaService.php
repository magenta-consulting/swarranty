<?php

namespace Magenta\Bundle\SWarrantyModelBundle\Service\Media;

use Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Media;
use Sonata\MediaBundle\Entity\MediaManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MediaService extends MediaManager {
	/** @var ContainerInterface $container */
	private $container;
	
	public function generatePrivateUrl($mid, $format = 'admin') {
		$mediaPrefix = $this->container->getParameter('MEDIA_API_PREFIX');
		if($mediaPrefix === '/') {
			$mediaPrefix = '';
		}
		
		return $url = $this->container->getParameter('MEDIA_API_BASE_URL') . $mediaPrefix . sprintf('/media/%d/binaries/%s/view.json', $mid, $format);
	}
	
	/**
	 * @param ContainerInterface $container
	 */
	public function setContainer(ContainerInterface $container): void {
		$this->container = $container;
	}
}