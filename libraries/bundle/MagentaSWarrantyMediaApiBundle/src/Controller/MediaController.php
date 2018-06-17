<?php

namespace Magenta\Bundle\SWarrantyMediaApiBundle\Controller;

use Sonata\MediaBundle\Controller\Api\MediaController as SonataMediaController;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View as FOSRestView;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sonata\DatagridBundle\Pager\PagerInterface;
use Sonata\MediaBundle\Filesystem\Local;
use Sonata\MediaBundle\Form\Type\ApiMediaType;
use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Provider\MediaProviderInterface;
use Sonata\MediaBundle\Provider\Pool;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class MediaController extends SonataMediaController {
	
	/**
	 * Write a medium, this method is used by both POST and PUT action methods.
	 *
	 * @param Request                $request
	 * @param MediaInterface         $media
	 * @param MediaProviderInterface $provider
	 *
	 * @return View|FormInterface
	 */
	protected function handleWriteMedium(Request $request, MediaInterface $media, MediaProviderInterface $provider) {
		// sonata-project\media-bundle\src\Resources\config\api_form_doctrine_orm.xml
		$form = $this->formFactory->createNamed(null, ApiMediaType::class, $media, [
			'provider_name'   => $provider->getName(),
			'csrf_protection' => false
		]);
		
		$form->handleRequest($request);
		
		if($form->isValid()) {
			/** @var MediaInterface $media */
			$media = $form->getData();
			if( ! empty($mc = $request->query->get('context'))) {
				$media->setContext($mc);
			}
			$this->mediaManager->save($media);
			
			$context = new Context();
			$context->setGroups([ 'read_medium', 'sonata_api_read' ]);
			$context->enableMaxDepth();
			
			$view = FOSRestView::create($media);
			$view->setContext($context);
			
			return $view;
		}
		
		return $form;
	}
	
	/**
	 * @param string $id
	 * @param string $format
	 *
	 * @throws NotFoundHttpException
	 *
	 * @return Response
	 *
	 */
	public function getMediumBinaryViewAction(Request $request, $id, $format = MediaProviderInterface::FORMAT_REFERENCE) {
		$media = $this->getMedia($id);
		
		if( ! $media) {
			throw new NotFoundHttpException(sprintf('unable to find the media with the id : %s', $id));
		}
		
		if( ! $this->mediaPool->getDownloadStrategy($media)->isGranted($media, $request)) {
			throw new AccessDeniedException();
		}
		
		$response = $this->getViewBinaryResponse($media, $format, $this->mediaPool->getDownloadMode($media));
		
		if($response instanceof BinaryFileResponse) {
			$response->prepare($request);
		}
		
		return $response;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getViewBinaryResponse(MediaInterface $media, $format, $mode, array $headers = []) {
		$provider = $this->getProvider($media);
		
		// build the default headers
		$headers = array_merge([
			'Content-Type'        => $media->getContentType(),
//			'Content-Disposition' => sprintf('attachment; filename="%s"', $media->getMetadataValue('filename')),
			'Content-Disposition' => sprintf('inline; filename="%s"', $media->getMetadataValue('filename')),
		], $headers);
		
		if( ! in_array($mode, [ 'http', 'X-Sendfile', 'X-Accel-Redirect' ])) {
			throw new \RuntimeException('Invalid mode provided');
		}
		
		if('http' == $mode) {
			if(MediaProviderInterface::FORMAT_REFERENCE === $format) {
				$file = $provider->getReferenceFile($media);
			} else {
				$file = $provider->getFilesystem()->get($provider->generatePrivateUrl($media, $format));
			}
			
			return new StreamedResponse(function() use ($file) {
				echo $file->getContent();
			}, 200, $headers);
		}
		
		if( ! $provider->getFilesystem()->getAdapter() instanceof Local) {
			throw new \RuntimeException('Cannot use X-Sendfile or X-Accel-Redirect with non \Sonata\MediaBundle\Filesystem\Local');
		}
		
		$filename = sprintf('%s/%s',
			$provider->getFilesystem()->getAdapter()->getDirectory(),
			$provider->generatePrivateUrl($media, $format)
		);
		
		return new BinaryFileResponse($filename, 200, $headers);
	}
	
	/**
	 * @param string $id
	 *
	 * @return MediaInterface
	 */
	public function getMedia($id) {
		return $this->mediaManager->find($id);
	}
	
	/**
	 * @param MediaInterface $media
	 *
	 * @return MediaProviderInterface
	 */
	public function getProvider(MediaInterface $media) {
		return $this->mediaPool->getProvider($media->getProviderName());
	}
	
}