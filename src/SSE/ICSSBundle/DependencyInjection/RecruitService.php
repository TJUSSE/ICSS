<?php


namespace SSE\ICSSBundle\DependencyInjection;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;

class RecruitService
{
    /** @var  \Doctrine\ORM\EntityManager */
    protected $em;

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }

    public function listRecruits($page = 1, $pageSize = 20)
    {
        $query = $this->em->createQuery(
            'SELECT r, p FROM SSEICSSBundle:Recruit r LEFT JOIN r.suitableProjects p ORDER BY r.publishAt DESC'
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
        foreach ($list as &$rec) {
            $rec['publishAt'] = $rec['publishAt']->format('Y-m-d');
        }

        return [
            "totalRecruits" => $totalRecruits,
            "currentPage" => $page,
            "pagesCount" => $pagesCount,
            "list" => $list,
        ];
    }

}