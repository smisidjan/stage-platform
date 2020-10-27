<?php

// src/Controller/ChallengeController.php

namespace App\Controller;

//use App\Service\RequestService;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

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
    public function indexAction(Session $session, Request $request, CommonGroundService $commonGroundService, ParameterBagInterface $params, string $slug = 'home')
    {
        $variables = [];

        // Lets provide this data to the template
        $variables['query'] = $request->query->all();
        $variables['post'] = $request->request->all();

        // Get resource
        $variables['resources'] = $commonGroundService->getResource(['component' => 'chrc', 'type' => 'tenders'], $variables['query'])['hydra:member'];

        return $variables;
    }


    /**
     * @Route("/{id}")
     * @Template
     */
    public function challengeAction($id)
    {
        $variables = [];

        return $variables;
    }
}
