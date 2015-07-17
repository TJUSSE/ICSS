<?php
/**
 * Created by PhpStorm.
 * User: pc-dll
 * Date: 2015/7/14
 * Time: 14:45
 */

namespace SSE\ICSSBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

//use Sluggable\Fixture\Handler\Company;

class CompanyController extends Controller
{

    /**
     * @Route("/company/list/{page}", name="companyList",defaults={"page"=1})
     * @Template()
     */
    public function listAction($page)
    {
        $data = $this->container->get('sse.icss.company_service')->listCompanies($page);

        return $data;
    }

    /**
     * @Route ("/company/detail/{id}",name="companyDetail")
     * @Template()
     */
    public function detailAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("SSEICSSBundle:Company");
        $company = $repository->find($id);

        return ['company' => $company];
    }

}
