<?php

namespace Magenta\Bundle\AppPdfBundle\Controller;

use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class Html2PdfController extends Controller
{
    /**
     * http://swarranty.magenta-dev.com/download-pdf/http://127.0.0.1:8000/test.html/oh-man.
     *
     * @param         $url
     * @param         $name
     * @param Request $request
     *
     * @return PdfResponse
     */
    public function downloadFromUrlAction($url, $name, Request $request)
    {
        //		$this->container->get('knp_snappy.pdf')->generate($url, 'E:\\hello.pdf');
        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(file_get_contents($url)),
            $name.'.pdf'
        );
    }
}
