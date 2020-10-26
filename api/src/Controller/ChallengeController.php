<?php

// src/Controller/ChallengeController.php

namespace App\Controller;

//use App\Service\RequestService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function indexAction()
    {
        $variables = [];

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
