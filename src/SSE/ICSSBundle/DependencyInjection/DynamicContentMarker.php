<?php

namespace SSE\ICSSBundle\DependencyInjection;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class DynamicContentMarker
{
    /** @var Request */
    protected $request;

    public function setRequest(RequestStack $request_stack)
    {
        $this->request = $request_stack->getCurrentRequest();
    }

    public function isAjax()
    {
        return $this->request->isXmlHttpRequest();
    }
}