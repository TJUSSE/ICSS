<?php

namespace SSE\ICSSBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
}
