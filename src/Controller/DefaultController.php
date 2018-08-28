<?php 

// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
}
