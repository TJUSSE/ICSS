<?php


namespace SSE\ICSSBundle\Builder;

use Doctrine\ORM\EntityManager;

class GradeListBuilder extends ColumnValueListBuilder
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em->getRepository('SSEICSSBundle:Student'), 'grade');
    }
}