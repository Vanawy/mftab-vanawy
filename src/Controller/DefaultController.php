<?php 

// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use App\Service\SpreadsheetService;

class DefaultController
{

    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function mainAction()
    {
        return;
    }

    /**
     * @Route("/info", name="info")
     * @Template()
     */
    public function infoAction()
    {
    	return array('info' => phpinfo());
    }

    /**
     * @Route("/upload", name="upload")
     * @Template()
     */
    public function uploadAction()
    {
    	$ss = new SpreadsheetService();
    	$ss->open('01.xls');
    	$ss->parseShedule();
    	return;
    }


}
