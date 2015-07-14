<?php


namespace SSE\ICSSBundle\Builder;

use Doctrine\ORM\EntityRepository;

class SimpleIdNameListBuilder
{
    protected $repo;

    public function __construct(EntityRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getList()
    {
        $items = $this->repo->findAll();
        $ret = array();
        foreach ($items as $item) {
            $ret[$item->getId()] = $item->getName();
        }
        return $ret;
    }
}