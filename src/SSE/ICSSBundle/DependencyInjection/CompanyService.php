<?php


namespace SSE\ICSSBundle\DependencyInjection;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;

class CompanyService
{
    /** @var  \Doctrine\ORM\EntityManager */
    protected $em;

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }

    public function listCompanies($page = 1, $pageSize = 20)
    {
        $query = $this->em->createQuery(
            'SELECT c, cls FROM SSEICSSBundle:Company c LEFT JOIN c.class cls ORDER BY c.id ASC'
        );

        $paginator = new Paginator($query);
        $paginator->setUseOutputWalkers(false);

        $totalRecruits = count($paginator);
        $pagesCount = ceil($totalRecruits / $pageSize);

        $paginator
            ->getQuery()
            ->setFirstResult($pageSize * ($page - 1))
            ->setMaxResults($pageSize);

        $list = $query->getArrayResult();

        return [
            "totalRecruits" => $totalRecruits,
            "currentPage" => $page,
            "pagesCount" => $pagesCount,
            "list" => $list,
        ];
    }
}