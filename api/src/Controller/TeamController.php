<?php

// src/Controller/TeamController.php

namespace App\Controller;

use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * The TeamController test handles any calls that have not been picked up by another test, and wel try to handle the slug based against the wrc.
 *
 * Class TeamController
 *
 * @Route("/teams")
 */
class TeamController extends AbstractController
{
    /**
     * @Route("/")
     * @Template
     */
    public function indexAction(CommonGroundService $commonGroundService, Request $request)
    {
        $variables = [];

        // On an index route we might want to filter based on user input
        $variables['query'] = array_merge($request->query->all(), $variables['post'] = $request->request->all());

        // Get resource
        $variables['teams'] = $commonGroundService->getResource(['component' => 'cc', 'type' => 'organizations'], $variables['query'])['hydra:member'];
        $variables['entries'] = $commonGroundService->getResourceList(['component' => 'chrc', 'type' => 'entries'], $variables['query'])['hydra:member'];


//        $variables['groups'] = $commonGroundService->getResource(['component' => 'edu', 'type' => 'groups'], $variables['query'])['hydra:member'];

//        //  Getting the participant @todo this needs to be more foolproof
//        if($this->getUser()){
//            $participants = $commonGroundService->getResourceList(['component' => 'edu', 'type' => 'groups',["participants"=> $this->getUser()->getPerson()]])['hydra:member'];
//        }
//        else{
//            $participants = $commonGroundService->getResourceList(['component' => 'edu', 'type' => 'participants',["person"=> "https://dev.zuid-drecht.nl/api/v1/cc/people/d961291d-f5c1-46f4-8b4a-6abb41df88db"]])['hydra:member'];
//        }
//        $variables['participant'] = $participants[0];
//        $variables['teams'] = $variables['participant']['groups'];


        return $variables;
    }

    /**
     * @Route("/{id}")
     * @Template
     */
    public function teamAction(CommonGroundService $commonGroundService, Request $request, $id)
    {
        $variables = [];

        // Get Resource
        $variables['team'] = $commonGroundService->getResource(['component' => 'cc', 'type' => 'organizations', 'id' => $id]);
        $variables['entry'] = $commonGroundService->getResourceList(['component' => 'chrc', 'type' => 'entries'], ['tender.id' => $id])['hydra:member'];

        return $variables;
    }
}
