<?php

// src/Controller/EducationController.php

namespace App\Controller;

use Conduction\CommonGroundBundle\Service\ApplicationService;
//use App\Service\RequestService;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use function GuzzleHttp\Promise\all;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

/**
 * The EducationController test handles any calls that have not been picked up by another test, and wel try to handle the slug based against the wrc.
 *
 * Class EducationController
 *
 * @Route("/education")
 */
class EducationController extends AbstractController
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
     * @Route("/tutorials")
     * @Template
     */
    public function tutorialsAction()
    {
        $variables = [];

        return $variables;
    }

    /**
     * @Route("/tutorials/{id}")
     * @Template
     */
    public function tutorialAction($id = null)
    {
        $variables = [];

        return $variables;
    }

    /**
     * @Route("/programs")
     * @Template
     */
    public function programsAction()
    {
        $variables = [];

        return $variables;
    }

    /**
     * @Route("/programs/{id}")
     * @Template
     */
    public function programAction($id = null)
    {
        $variables = [];

        return $variables;
    }



}
