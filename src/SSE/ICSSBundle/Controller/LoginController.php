<?php

namespace SSE\ICSSBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller
{
    /**
     * @Route("/login/sso/dialog", name="loginDialog")
     * @Template()
     */
    public function loginDialogAction(Request $request)
    {
        $loginFailed = ($request->query->has('ok') && $request->query->get('ok') !== 'true');

        return ['failed' => $loginFailed];
    }

    /**
     * @Route("/login/native/dialog", name="loginNativeDialog")
     * @Template()
     */
    public function loginNativeDialogAction()
    {
        return [];
    }

    /**
     * @Route("/login/sso/result", name="loginDialogResult")
     * @Template()
     */
    public function loginDialogResultAction(Request $request)
    {
        $loginFailed = ($request->query->has('ok') && $request->query->get('ok') !== 'true');

        return ['failed' => $loginFailed];
    }

    /**
     * @Route("/login/check", name="loginNativeCheck")
     */
    public function loginNativeCheck()
    {

    }

}