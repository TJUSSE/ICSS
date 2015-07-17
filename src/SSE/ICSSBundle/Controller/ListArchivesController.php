<?php


namespace SSE\ICSSBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SSE\ICSSBundle\Entity\RecruitApply;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Hello controller.
 *
 * @Route("/console/archives")
 */
class ListArchivesController extends Controller
{
    /**
     * @Route("/{applyid}", name="consoleListApplyArchives")
     * @Template()
     */
    public function indexAction($applyid)
    {
        $admin_pool = $this->get('sonata.admin.pool');

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            "SELECT ra FROM SSEICSSBundle:RecruitApply ra WHERE ra.id = :applyid"
        )
            ->setParameter('applyid', $applyid);

        /** @var RecruitApply $apply */
        $apply = $query->getOneOrNullResult();

        return array(
            'admin_pool' => $admin_pool,
            'archives' => $apply->getArchives(),
        );
    }
}