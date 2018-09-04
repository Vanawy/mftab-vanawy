<?php 

// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Entity\Shedule;
use App\Entity\Group;
use App\Entity\Course;
use App\Entity\Pair;

use App\Service\SpreadsheetService;

class AdminController extends Controller
{
    /**
     * @Route("/upload/", name="upload")
     * @Template()
     */
    public function uploadAction()
    {
        if(true){
            $ss = new SpreadsheetService();
            $ss->open('01.xls');
            $shedule = $ss->parseShedule();
            $em = $this->getDoctrine()->getManager();
            $em->persist($shedule);
            $em->flush();

            return array(
                'shedule' => $shedule,
            );
        }

        return;

    }
}
