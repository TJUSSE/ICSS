<?php

namespace SSE\ICSSBundle\Builder;

use Doctrine\ORM\EntityManager;

class ProjectListBuilder extends SimpleIdNameListBuilder
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em->getRepository('SSEICSSBundle:Project'));
    }
}