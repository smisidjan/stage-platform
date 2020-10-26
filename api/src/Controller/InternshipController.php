<?php

// src/Controller/InternshipController.php

namespace App\Controller;

//use App\Service\RequestService;
use Conduction\CommonGroundBundle\Service\ApplicationService;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
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
    public function indexAction(Session $session, Request $request, ApplicationService $applicationService, CommonGroundService $commonGroundService, ParameterBagInterface $params)
    {
        $variables = [];


        // Lets provide this data to the template
        $variables['query'] = $request->query->all();
        $variables['post'] = $request->request->all();

        // Get resource Stages
        $variables['resource'] = $commonGroundService->getResource(['component' => 'mrc', 'type' => 'job_postings'], $variables['query'])['hydra:member'];


        return $variables;
    }

    /**
     * @Route("/{id}")
     * @Template
     */
    public function positionAction(Session $session, Request $request, ApplicationService $applicationService, CommonGroundService $commonGroundService, ParameterBagInterface $params, $id)
    {
        $variables = [];

        return $variables;
    }



}
