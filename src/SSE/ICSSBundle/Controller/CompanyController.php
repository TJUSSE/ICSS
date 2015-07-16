<?php
/**
 * Created by PhpStorm.
 * User: pc-dll
 * Date: 2015/7/14
 * Time: 14:45
 */

namespace SSE\ICSSBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Sluggable\Fixture\Handler\Company;
use SSE\ICSSBundle\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Tools\Pagination\Paginator;

class CompanyController extends Controller
{

    /**
     * @Route("/company/{page}", name="SSEICSSBundle_Company_list",defaults={"page"=1})
     */
    public function listAction($page)
    {
        $pageSize=20;
        $em=$this->getDoctrine()->getManager();


        $query=$em->createQuery('SELECT company FROM SSEICSSBundle:Company company');
        $paginator=new Paginator($query);
        $totalCompanies=count($paginator);
        $pagesCount=ceil($totalCompanies/$pageSize);

        $paginator
            ->getQuery()
            ->setFirstResult($pageSize*($page-1))
            ->setMaxResults($pageSize);

        $list=$query->getArrayResult();


        $response=new JsonResponse();
        $response->setData(
            array( "totalCompanies"=>$totalCompanies,
                   "pagesCount"=>$pagesCount,
                   "list"=>$list)
        );
       return $response;
    }

    /**
     * @Route ("/company/detail/{id}",name="SSEICSSBundle_Company_detail")
     */
    public function detailAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $repository=$em->getRepository("SSEICSSBundle:Company");
        $company=$repository->find($id);


        $response=new JsonResponse();
        $response->setData(
            array("company"=>$comp=array(
                'id'=>$company->getId(),
                'name'=>$company->getName(),
                'intro'=>$company->getIntro(),
                'updateAt'=>$company->getUpdateAt(),
                'location'=>$company->getLocation(),
                'hidden'=>$company->getHidden(),
            ))
        );

        return $response;
    }

}