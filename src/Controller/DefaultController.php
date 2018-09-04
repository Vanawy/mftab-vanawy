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

class DefaultController extends Controller
{

    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function mainAction()
    {
        $em = $this->getDoctrine()->getManager();
        $shedule = $em->getRepository(Shedule::class)->findOneBy([], ['updated' => 'DESC']);

        return array(
            'shedule' => $shedule,
        );
    }

    /**
     * @Route("/show/{url}", name="course")
     * @Template()
     */
    public function courseAction($url)
    {
        $em = $this->getDoctrine()->getManager();
        $shedule = $em->getRepository(Shedule::class)->findOneBy([], ['updated' => 'DESC']);

        $course = $em->getRepository(Course::class)->findOneBy(['shedule' => $shedule, 'url' => $url]);

        return array(
            'shedule' => $shedule,
            'course' => $course,
        );
    }

    /**
     * @Route("/show/{course}/{url}", name="group")
     * @Template()
     */
    public function groupAction($course, $url)
    {
        $em = $this->getDoctrine()->getManager();
        $shedule = $em->getRepository(Shedule::class)->findOneBy([], ['updated' => 'DESC']);

        $course = $em->getRepository(Course::class)->findOneBy(['shedule' => $shedule, 'url' => $course]);
        $group = $em->getRepository(Group::class)->findOneBy(['course' => $course, 'url' => $url]);

        return array(
            'shedule' => $shedule,
            'course' => $course,
            'group' => $group,
        );
    }

    /**
     * @Route("/info/", name="info")
     * @Template()
     */
    public function infoAction()
    {
    	return array('info' => phpinfo());
    }
}
