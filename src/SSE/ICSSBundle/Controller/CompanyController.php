<?php

namespace SSE\ICSSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CompanyController extends Controller
{
    protected function getCompanyRepository()
    {
        return $this->getDoctrine()->getRepository("SSEICSSBundle:Company");
    }
}
