<?php

namespace SSE\ICSSBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SSE\ICSSBundle\Security\User\HybridUserProvider;
use SSE\ICSSBundle\Security\User\PasswordEncoder;
use SSE\ICSSBundle\SSO\SSOService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ICSSController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        return new Response('<body><h1>It works!</h1></body>');
    }

    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function helloAction($name)
    {
        return array('name' => $name);
    }

    /**
     * @Route("/user/check/{username}/{password}")
     */
    public function userCheckAction($username, $password)
    {
        $entityManager= $this->getDoctrine()->getEntityManagers();
        $entityManager= $entityManager['default'];
        $check= new HybridUserProvider(new SSOService(null),$entityManager,new PasswordEncoder());
        return new Response((string)$check->getUsernameForInternalUser($username, $password));
    }
}
