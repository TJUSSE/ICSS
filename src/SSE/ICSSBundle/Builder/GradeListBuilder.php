<?php


namespace SSE\ICSSBundle\Builder;

use Doctrine\ORM\EntityManager;

class GradeListBuilder
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getList()
    {
        $query = $this->em->getRepository('SSEICSSBundle:Student')->createQueryBuilder('s')
            ->select('s.grade')
            ->distinct()
            ->getQuery();

        $items = $query->getResult();
        $ret = array();
        foreach ($items as $item) {
            if ($item['grade'] !== null) {
                $ret[$item['grade']] = $item['grade'];
            }
        }
        return $ret;
    }
}