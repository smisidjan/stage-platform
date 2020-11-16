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
        if (empty($this->getUser())) {
            return $this->redirect($this->generateUrl('app_user_idvault'));
        }

        $variables = [];

        // Get the cc/person url of this user
        $personUrl = $this->getUser()->getPerson();

        //get organizations id of current position
        $organization = $commonGroundService->cleanUrl(['component' => 'wrc', 'type' => 'organizations', 'id' => $id]);

        //get all positions of that organizations
        $variables['positions'] = $commonGroundService->getResourceList(['component' => 'mrc', 'type' => 'job_postings'], ['organization' => $organization])['hydra:member'];

        // Get resource Intership
        $variables['intership'] = $commonGroundService->getResource(['component' => 'mrc', 'type' => 'job_postings', 'id'=>$id]);

        //get employee conected to user
        $employees = $commonGroundService->getResourcelist(['component' => 'mrc', 'type' => 'employees'], ['person' => $personUrl])['hydra:member'];
        if (count($employees) > 0) {
            $variables['employee'] = $employees[0];
        } else {
            //create a new employee if user doesn't have one
            $variables['employee']['person'] = $personUrl;
            $variables['employee'] = $commonGroundService->createResource($variables['employee'], ['component' => 'mrc', 'type' => 'employees']);
        }

        // Lets see if there is a post to procces
        if ($request->isMethod('POST')) {
            $variables['application'] = [];
            $resource = $request->request->all();
            $resource['employee'] = '/employees/'.$variables['employee']['id'];
            $resource['jobPosting'] = '/job_postings/'.$variables['intership']['id'];
            $resource['status'] = 'applied';
            // Update to the commonground component
            $variables['application'] = $commonGroundService->saveResource($resource, ['component' => 'mrc', 'type' => 'applications']);
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
