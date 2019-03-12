<?php

namespace Magenta\Bundle\SWarrantyAdminBundle\Controller;

use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\WarrantyCase;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ServiceSheetController extends Controller
{
    public function indexAction(Request $request)
    {
        $casesParam = $request->query->get('cases');
        $qb = $this->get('doctrine.orm.default_entity_manager')->createQueryBuilder();
        $qb->select('c')->from(WarrantyCase::class, 'c');
        $expr = $qb->expr();
        $q = $qb->where($expr->in('c.id', ':ids'))
            ->setParameter(':ids', $casesParam)
            ->getQuery();
        $cases = $q->getResult();

        return $this->render('@MagentaSWarrantyAdmin/Pdf/service-sheet/fujioh.html.twig', ['cases' => $cases]);
    }
}
