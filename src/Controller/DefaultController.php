<?php

namespace Deadkash\SipuniBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    /**
     * @return Response
     * @Route("/_sipuni_api")
     */
    public function indexAction()
    {
        $request = $this->get('request');
        $sipuniService = $this->get('sipuni');

        $sipuniService->receiveRequest($request);

        $output = array(
            'success' => true
        );

        return new JsonResponse($output);
    }
}