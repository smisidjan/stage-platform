<?php

// src/Controller/InternshipController.php

namespace App\Controller;

//use App\Service\RequestService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * The InternshipController test handles any calls that have not been picked up by another test, and wel try to handle the slug based against the wrc.
 *
 * Class InternshipController
 *
 * @Route("/internships")
 */
class InternshipController extends AbstractController
{
    /**
     * @Route("/")
     * @Template
     */
    public function indexAction()
    {
        $variables = [];

        return $variables;
    }

    /**
     * @Route("/{id}")
     * @Template
     */
    public function positionAction($id)
    {
        $variables = [];

        // Get resource Interschip
        $variables['intership'] = $commonGroundService->getResource(['component' => 'mrc', 'type' => 'job_postings', 'id'=>$id]);

        return $variables;
    }
}
