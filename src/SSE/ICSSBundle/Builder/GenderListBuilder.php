<?php


namespace SSE\ICSSBundle\Builder;

use Doctrine\ORM\EntityManager;

class GenderListBuilder extends SimpleIdNameListBuilder
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em->getRepository('SSEICSSBundle:Gender'));
    }
}