<?php

// src/Controller/DashboardController.php

namespace App\Controller;

//use App\Service\RequestService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * The DashboardController test handles any calls that have not been picked up by another test, and wel try to handle the slug based against the wrc.
 *
 * Class DashboardController
 *
 * @Route("/dashboard/organization")
 */
class DashboardOrganizationController extends AbstractController
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
    public function tutorialAction()
    {
        $variables = [];

        // Get resource tutorial
        if ($id != 'new') {
            $variables['tutorial'] = $commonGroundService->getResource(['component' => 'edu', 'type' => 'courses', 'id' => $id]);
        } else {
            $variables['tutorial'] = [];
        }

        return $variables;
    }

    /**
     * @Route("/internships")
     * @Template
     */
    public function internshipsAction()
    {
        $variables = [];

        return $variables;
    }

    /**
     * @Route("/internships/{id}")
     * @Template
     */
    public function internshipAction()
    {
        $variables = [];

        // Get resource Interschip
        if ($id != 'new') {
            $variables['internship'] = $commonGroundService->getResource(['component' => 'mrc', 'type' => 'job_postings', 'id'=>$id]);
        } else {
            $variables['internship'] = [];
        }

        return $variables;
    }

    /**
     * @Route("/challanges")
     * @Template
     */
    public function challangesAction()
    {
        $variables = [];

        return $variables;
    }

    /**
     * @Route("/challanges/{id}")
     * @Template
     */
    public function challangeAction()
    {
        $variables = [];

        // Get resource challenges (known as tender component side)
        if ($id != 'new') {
            $variables['challenge'] = $commonGroundService->getResource(['component' => 'chrc', 'type' => 'tenders', 'id' => $id]);
        } else {
            $variables['challenge'] = [];
        }

        return $variables;
    }

    /**
     * @Route("/teams")
     * @Template
     */
    public function teamsAction()
    {
        $variables = [];

        return $variables;
    }

    /**
     * @Route("/teams/{id}")
     * @Template
     */
    public function teamAction()
    {
        $variables = [];

        return $variables;
    }
}
