<?php

namespace App\Controller;

use Bean\Bundle\BookBundle\Doctrine\Orm\Book;
use Bean\Bundle\BookBundle\Doctrine\Orm\Chapter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Media\Media;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BeanPlaygroundController extends Controller {
	/**
	 * @Route("/", name="home")
	 */
	public function home() {
		return new Response('hello kitty');
	}
	
	/**
	 * @Route("/bean/playground", name="bean_playground")
	 */
	public function index() {
		$registry = $this->get('doctrine');
//		$chapRepo = $registry->getRepository(Chapter::class);
//		$chap     = $chapRepo->findAll()[0];
//		$chap     = $chapRepo->find(6);
//		$qb       = $this->container->get('doctrine.orm.default_entity_manager')->createQueryBuilder();
//
//		$qb->select('c')->from(Chapter::class, 'c')
//		   ->join('c.partOf', 'partOf');;
//		$chapter = $qb->setFirstResult(0)->getQuery()->getResult();
//		$wRepo = $this->getDoctrine()->getRepository(Warranty::class);
		$m            = $this->getDoctrine()->getManagerForClass(Warranty::class);
		$wRepo        = $m->getRepository(Warranty::class);
		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = $wRepo->createQueryBuilder('o');
		$queryBuilder->andWhere('o.id = 61');
		$w = $queryBuilder->getQuery()->getOneOrNullResult();
		
		$w       = $wRepo->find(61);
		$manager = $this->get('doctrine.orm.default_entity_manager');
		$m       = new Media();
		$m->setName('File Name');
		$m->setEnabled(true);
		$m->setProviderName('sonata.media.provider.image');

//		$test = $this->container->get('sonata.media.controller.api.gallery');
		
		return $this->render('bean_playground/index.html.twig', [
			'controller_name' => 'BeanPlaygroundController',
		]);
	}
}
