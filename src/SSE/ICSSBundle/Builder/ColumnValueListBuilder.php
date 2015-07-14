<?php


namespace SSE\ICSSBundle\Builder;

use Doctrine\ORM\EntityRepository;

class ColumnValueListBuilder
{
    protected $repo;
    protected $column;

    public function __construct(EntityRepository $repo, $column)
    {
        $this->repo = $repo;
        $this->column = $column;
    }

    public function getList()
    {
        $query = $this->repo->createQueryBuilder('t')
            ->select('t.' . $this->column)
            ->distinct()
            ->getQuery();

        $items = $query->getResult();
        $ret = [];
        foreach ($items as $item) {
            if ($item[$this->column] !== null) {
                $ret[$item[$this->column]] = $item[$this->column];
            }
        }
        return $ret;
    }
}