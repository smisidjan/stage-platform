<?php

// src/Controller/InternshipController.php

namespace App\Controller;

use Conduction\CommonGroundBundle\Service\CommonGroundService;
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
    public function indexAction(CommonGroundService $commonGroundService, Request $request)
    {
        // On an index route we might want to filter based on user input
        $variables['query'] = array_merge($request->query->all(), $variables['post'] = $request->request->all());

        // Get resources Interschips
        $variables['interships'] = $commonGroundService->getResource(['component' => 'mrc', 'type' => 'job_postings'], $variables['query'])['hydra:member'];

        return $variables;
    }

    /**
     * @Route("/{id}")
     * @Template
     */
    public function positionAction(CommonGroundService $commonGroundService, Request $request, $id)
    {
        $variables = [];

        //get organizations id of current position
        $organization = $commonGroundService->cleanUrl(['component' => 'wrc', 'type' => 'organizations', 'id' => $id]);
        //get all positions of that organizations
        $variables['positions'] = $commonGroundService->getResourceList(['component' => 'mrc', 'type' => 'job_postings'], ['organization' => $organization])['hydra:member'];

        // Get resource Intership
        $variables['intership'] = $commonGroundService->getResource(['component' => 'mrc', 'type' => 'job_postings', 'id'=>$id]);
        return $variables;
    }
}
