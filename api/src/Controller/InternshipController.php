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
        $variables['internships'] = $commonGroundService->getResource(['component' => 'mrc', 'type' => 'job_postings'], $variables['query'])['hydra:member'];

        return $variables;
    }

    /**
     * @Route("/{id}")
     * @Template
     */
    public function positionAction(CommonGroundService $commonGroundService, Request $request, $id)
    {
        $variables = [];

        // Get resource internship
        $variables['internship'] = $commonGroundService->getResource(['component' => 'mrc', 'type' => 'job_postings', 'id'=>$id]);

        //get all positions of the hiringOrganization
        $variables['positions'] = $commonGroundService->getResourceList(['component' => 'mrc', 'type' => 'job_postings'], ['hiringOrganization' => $variables['internship']['hiringOrganization']])['hydra:member'];

        // Check if there is a user loged in
        if ($this->getUser()) {
            // Get the cc/person url of this user
            $personUrl = $this->getUser()->getPerson();

            //get employee conected to the user
            $employees = $commonGroundService->getResourcelist(['component' => 'mrc', 'type' => 'employees'], ['person' => $personUrl])['hydra:member'];
            if (count($employees) > 0) {
                $variables['employee'] = $employees[0];
            } else {
                //create a new employee if this user doesn't have one
                $variables['employee']['person'] = $personUrl;
                $variables['employee'] = $commonGroundService->createResource($variables['employee'], ['component' => 'mrc', 'type' => 'employees']);
            }
        }

        // Lets see if there is a post to procces
        if ($request->isMethod('POST')) {
            if (empty($this->getUser())) {
                return $this->redirect($this->generateUrl('app_user_idvault'));
            } elseif (empty($variables['employee']) || empty($personUrl)) {
                return $this->redirect($this->generateUrl('app_internship_position', ['id'=>$id]));
            }

            $variables['application'] = [];
            $resource = $request->request->all();
            $resource['employee'] = '/employees/'.$variables['employee']['id'];
            $resource['jobPosting'] = '/job_postings/'.$variables['internship']['id'];
            $resource['status'] = 'applied';
            // Update to the commonground component
            $variables['application'] = $commonGroundService->saveResource($resource, ['component' => 'mrc', 'type' => 'applications']);

            // Send an email to organization of this jobPosting:
            // (Maybe this should be handled with the VSBE to send emails whenever an application is created?)
            if (isset($variables['internship']['hiringOrganization'])) {
                // Create the email message
                $message = [];
                $message['service'] = '/services/1541d15b-7de3-4a1a-a437-80079e4a14e0';
                $message['status'] = 'queued';

                // Determine the receiver
                $organization = $commonGroundService->getResource($variables['internship']['hiringOrganization']);
                $message['reciever'] = $organization['contact']; // reciever = typo in BS, keep it like this for now

                // lets use stage platform contact as sender (maybe use or get the sender in a different way?)
                $message['sender'] = $commonGroundService->cleanUrl(['component' => 'cc', 'type' => 'organizations', 'id' => 'faafee73-2b5a-4cd5-a339-c0c96ba0d7eb']);

                // if we don't have that we are going to self send te message
                if (!$commonGroundService->isResource($message['sender'])) {
                    $message['sender'] = $message['reciever'];
                }
                $message['data'] = [
                    'student'   => $commonGroundService->getResource($personUrl),
                    'internship'=> $variables['internship'],
                    'sender'    => $commonGroundService->getResource($message['sender']),
                    'receiver'  => $commonGroundService->getResource($message['reciever']),
                ];
                // Email template in wrc:
                $message['content'] = $commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'templates', 'id'=>'c1e5e409-63d5-4590-ba35-415aa002384b']);

                // Send the email to this contact
                $commonGroundService->createResource($message, ['component'=>'bs', 'type'=>'messages']);
            }
        }

        return $variables;
    }

    /**
     * @Route("/internships/like/{id}")
     * @Template
     */
    public function likeAction(CommonGroundService $commonGroundService, Request $request, $id)
    {
        // On an index route we might want to filter based on user input
        $variables['query'] = array_merge($request->query->all(), $variables['post'] = $request->request->all());

        // Get resources like
        $variables['like'] = $commonGroundService->getResource(['component' => 'rc', 'type' => 'likes'], $variables['query'])['hydra:member'];
        
        return $variables;
    }
}
