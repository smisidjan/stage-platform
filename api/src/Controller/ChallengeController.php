<?php

// src/Controller/ChallengeController.php

namespace App\Controller;

//use App\Service\RequestService;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * The ChallengeController test handles any calls that have not been picked up by another test, and wel try to handle the slug based against the wrc.
 *
 * Class ChallengeController
 *
 * @Route("/challenges")
 */
class ChallengeController extends AbstractController
{
    /**
     * @Route("/")
     * @Template
     */
    public function indexAction(Request $request, CommonGroundService $commonGroundService)
    {
        // On an index route we might want to filter based on user input
        $variables['query'] = array_merge($request->query->all(), $variables['post'] = $request->request->all());

        // Get resource challenges (known as tender component side)
        $variables['challenges'] = $commonGroundService->getResource(['component' => 'chrc', 'type' => 'tenders'], $variables['query'])['hydra:member'];

        return $variables;
    }


    /**
     * @Route("/{id}")
     * @Template
     */
    public function challengeAction(Request $request, CommonGroundService $commonGroundService, $id)
    {
        $variables = [];

        // Get resource challenges (known as tender component side)
        $variables['challenge'] = $commonGroundService->getResource(['component' => 'chrc', 'type' => 'tenders', 'id' => $id]);

        return $variables;
    }
}
