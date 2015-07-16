<?php

namespace SSE\ICSSBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SSE\ICSSBundle\Security\User\HybridUserProvider;
use SSE\ICSSBundle\Security\User\PasswordEncoder;
use SSE\ICSSBundle\SSO\SSOService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class ICSSController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/logout", name="logout")
     * @return RedirectResponse
     */
    public function logoutAction()
    {
        $response = new RedirectResponse($this->generateUrl('index'));

        $this->get('security.token_storage')->setToken(null);
        $this->get('request')->getSession()->invalidate();
        $this->get('request')->cookies->remove('iPlanetDirectoryPro');

        $response->headers->clearCookie('iPlanetDirectoryPro', '/', '.tongji.edu.cn');

        return $response;
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
        $entityManager = $this->getDoctrine()->getEntityManagers();
        $entityManager = $entityManager['default'];
        $check = new HybridUserProvider(new SSOService(null), $entityManager, new PasswordEncoder());

        return new Response((string)$check->getUsernameForInternalUser($username, $password));
    }
}
