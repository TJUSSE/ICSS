<?php

namespace SSE\ICSSBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
    public function loginNativeDialogAction(Request $request)
    {
        $loginFailed = ($request->query->has('ok') && $request->query->get('ok') !== 'true');

        return ['failed' => $loginFailed];
    }

    /**
     * @Route("/login/sso/result", name="loginDialogResult")
     * @Template()
     */
    public function loginDialogResultAction(Request $request)
    {
        if ($this->getUser() === null) {
            return new RedirectResponse($this->generateUrl('loginDialog', ['ok' => 'false']));
        }

        $loginFailed = ($request->query->has('ok') && $request->query->get('ok') !== 'true');

        return ['failed' => $loginFailed];
    }

    /**
     * @Route("/login/native/result", name="loginNativeDialogResult")
     * @Template()
     */
    public function loginNativeDialogResultAction(Request $request)
    {
        $loginFailed = ($request->query->has('ok') && $request->query->get('ok') !== 'true');

        return ['failed' => $loginFailed];
    }

    /**
     * @Route("/login/check", name="loginNativeCheck")
     */
    public function loginNativeCheckAction()
    {
        if ($this->getUser() === null) {
            return new RedirectResponse($this->generateUrl('loginNativeDialog', ['ok' => 'false']));
        }

        return new RedirectResponse($this->generateUrl('loginNativeDialogResult', ['ok' => 'true']));
    }

}