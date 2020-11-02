<?php

// src/Controller/OrganizationController.php

namespace App\Controller;

use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * This controller handles any pages with organization(s) as main subject.
 *
 * Class OrganizationController
 *
 * @Route("/organizations")
 */
class OrganizationController extends AbstractController
{
    /**
     * @Route("/")
     * @Template
     */
    public function indexAction(CommonGroundService $commonGroundService, Request $request)
    {
        $variables['slug'] = 'organizations';
        $variables['h1'] = 'organizations';
        $variables['organizations'] = $commonGroundService->getResourceList(['component'=>'wrc', 'type'=>'organizations'])['hydra:member'];

        return $variables;
    }

    /**
     * @Route("/{id}")
     * @Template
     */
    public function organizationAction(CommonGroundService $commonGroundService, Request $request, $id)
    {
        $variables['organization'] = $commonGroundService->getResource(['component'=>'wrc', 'type'=>'organizations', 'id'=>$id]);
        $variables['challenges'] = $commonGroundService->getResourceList(['component'=>'chrc', 'type'=>'tenders'], ['submitters'=>$variables['organization']['@id']])['hydra:member'];
//        $variables['programs'] = $commonGroundService->getResourceList(['component'=>'edu', 'type'=>'programs'], ['provider'=>$variables['organization']['@id']])['hydra:member'];

        $variables['h1'] = $variables['organization']['name'];
        $variables['slug'] = $variables['organization']['name'];

        return $variables;
    }
}
