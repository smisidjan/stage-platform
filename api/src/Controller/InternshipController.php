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

        //get test user
        /* @todo change this test employee to the employee connected to current logged in person */
        $variables['employee'] = $commonGroundService->getResource(['component' => 'mrc', 'type' => 'employees', 'id' => '7aeadbc2-742c-45d9-8d61-fdb120ab4934']);

        // Lets see if there is a post to procces
        if ($request->isMethod('POST')) {
            $variables['applications'] = [];
            $resource = $request->request->all();
            $resource['jobPosting'] = '/job_postings/'. $variables['intership']['id'];
            $resource['employee'] = '/employees/'.$variables['employee']['id'];
            $resource['status'] = "applied";

            $variables['applications'] = array_merge($variables['applications'], $resource);

            // Update to the commonground component
            $variables['applications'] = $commonGroundService->saveResource($resource, ['component' => 'mrc', 'type' => 'applications']);

        }
        return $variables;
    }

    /**
     * @Route("/internships/like")
     * @Template
     */
    public function likeAction(CommonGroundService $commonGroundService, Request $request)
    {
        // On an index route we might want to filter based on user input
        $variables['query'] = array_merge($request->query->all(), $variables['post'] = $request->request->all());

        // Get resources like
        $variables['like'] = $commonGroundService->getResource(['component' => 'rc', 'type' => 'like'], $variables['query'])['hydra:member'];

        return $variables;
    }
}
