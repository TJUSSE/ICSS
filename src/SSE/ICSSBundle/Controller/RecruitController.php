<?php
/**
 * Created by PhpStorm.
 * User: pc-dll
 * Date: 2015/7/14
 * Time: 15:51
 */

namespace SSE\ICSSBundle\Controller;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SSE\ICSSBundle\Entity\RecruitApply;
use SSE\ICSSBundle\Entity\RecruitApplyArchive;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Util\SecureRandom;

class RecruitController extends Controller
{
    /**
     * @Route("/recruit/pages/{page}",name="SSEICSSBundle_Recruit_list",defaults={"page"=1})
     */
    public function listAction($page)
    {
        $pageSize = 20;
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT r FROM SSEICSSBundle:Recruit ORDER BY r.publishAt DESC');

        $paginator = new Paginator($query);

        $totalRecruits = count($paginator);
        $pagesCount = ceil($totalRecruits / $pageSize);

        $paginator
            ->getQuery()
            ->setFirstResult($pageSize * ($page - 1))
            ->setMaxResults($pageSize);

        $list = $query->getArrayResult();

        $response = new JsonResponse(
            [
                "totalRecruits" => $totalRecruits,
                "pagesCount" => $pagesCount,
                "list" => $list,
            ]
        );

        return $response;
    }

    /**
     * @Route("/recruit/detail/{id}",name="SSEICSSBundle_Recruit_detail")
     */
    public function detailAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("SSEICSSBundle:Recruit");
        $recruit = $repository->find($id);

        $response = new JsonResponse(
            [
                'publishAt' => $recruit->getPublishAt(),
                'ended' => $recruit->getEnded(),
                'intro' => $recruit->getIntro(),
                'hidden' => $recruit->getHidden(),
                'applyLimit' => $recruit->getApplyLimit(),
                'visitCount' => $recruit->getVisitCount(),
                'id' => $recruit->getId(),
                'company' => $recruit->getCompany(),
                'types' => $recruit->getTypes(),
                'suitableInternTypes' => $recruit->getSuitableInternTypes(),
                'suitableProjects' => $recruit->getSuitableProjects(),
            ]
        );

        return $response;
    }

    /**
     * @Route("/recruit/apply",name="SSEICSSBundle_Recruit_apply")
     * @Method("POST")
     */
    public function applyAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $studentId = $this->getUser()->getId();
        $student = $em->getRepository('SSEICSSBundle:Student')->find($studentId);

        $recruitId = $request->request->get('recruitId');
        $internTypeId = $request->request->get('internTypeId');
        $description = $request->request->get('description');

        $recruit = $em->getRepository("SSEICSSBundle:Recruit")->find($recruitId);
        $internType = $em->getRepository("SSEICSSBundle:InternType")->find($internTypeId);

        // 检查是否在申请名额内
        $query = $em->createQuery("SELECT COUNT(ra.id) FROM SSEICSSBundle:RecruitApply ra WHERE ra.recruit.id = ?")
            ->setParameter(1, $recruitId);

        $appliesCount = $query->getScalarResult();
        if ($appliesCount >= $recruit->getApplyLimit()) {
            return new JsonResponse(
                [
                    'ok' => false,
                    'message' => "该招聘信息申请名额已满",
                ]
            );
        }

        // 检查所申请的实习性质
        $valid = false;
        $suitableInternTypes = $recruit->getSuitableInternTypes();
        foreach ($suitableInternTypes as $_type) {
            if ($internTypeId === $_type->getId()) {
                $valid = true;
                break;
            }
        }

        if (!$valid) {
            return new JsonResponse(
                [
                    'ok' => false,
                    'message' => '该招聘不能作为'.$internType->getName().'申请',
                ]
            );
        }

        // 检查学生学历
        $valid = false;
        $suitableProjects = $recruit->getSuitableProjects();
        foreach ($suitableProjects as $_project) {
            if ($student->getProject() === $_project->getId()) {
                $valid = true;
                break;
            }
        }

        if (!$valid) {
            return new JsonResponse(
                [
                    'ok' => false,
                    'message' => '您的学历不能申请该招聘',
                ]
            );
        }

        // 建立实习申请
        $recruitApply = new RecruitApply();

        if ($internType->getApprove()) {
            // 该实习类别的申请需要审批
            $recruitApply->setApproved(false);
        } else {
            // 不需要审批，则直接变为审批通过
            $recruitApply->setApproved(true);
        }

        $recruitApply->setCanceled(false);
        $recruitApply->setDescription($description);
        $recruitApply->setStudent($student);
        $recruitApply->setRecruit($recruit);
        $recruitApply->setInternType($internType);
        $em->persist($recruitApply);
        $em->flush();

        return new JsonResponse(
            [
                'ok' => true,
                'message' => "申请成功",
            ]
        );
    }

    /**
     * @Route("/recruit/upload",name="SSEICSSBundle_Recruit_upload")
     * @Method("POST")
     */
    public function uploadAction(Request $request)
    {
        $applyId = $request->request->get('applyId');
        $archiveTypeId = $request->request->get('archiveTypeId');

        if ($request->files->count() !== 1) {
            return new JsonResponse(
                [
                    'ok' => false,
                    'message' => "请选择上传文件",
                ]
            );
        }

        var_dump($request->files);

        $em = $this->getDoctrine()->getManager();
        $recruitApply = $em->getRepository("SSEICSSBundle:RecruitApply")->find($applyId);

        // 检查用户
        if ($recruitApply->getStudent()->getId() !== $this->getUser()->getId()) {
            return new JsonResponse(
                [
                    'ok' => false,
                    'message' => '您没有权限为该申请上传档案',
                ]
            );
        }

        // 检查是否可以递交该类型的档案
        $valid = false;
        $archiveTypeRepository = $em->getRepository("SSEICSSBundle:InternArchive");
        $archiveType = $archiveTypeRepository->find($archiveTypeId);

        foreach ($archiveType->getSuitableInternTypes() as $type) {
            if ($type->getId() == $recruitApply->getInternType()->getId()) {
                $valid = true;
                break;
            }
        }

        if (!$valid) {
            return new JsonResponse(
                [
                    'ok' => false,
                    'message' => '该实习性质不能递交该类型档案',
                ]
            );
        }

        // 检查递交时机
        $valid = false;
        if ($archiveType->getAfterApprove()) {
            // 必须在审批后递交
            $valid = $recruitApply->getApproved();
        }
        if ($archiveType->getAfterApply()) {
            // 申请后就可以递交
            $valid = true;
        }
        if (!$valid) {
            return new JsonResponse(
                [
                    'ok' => false,
                    'message' => '现在不能递交该类型档案',
                ]
            );
        }

        die();

        //$uploadFile = $request->files->;

        // generate a new file name to store the file
        $generator = new SecureRandom();
        $fileName = sha1(uniqid().'_'.$generator->nextBytes(10));
        $originalFileName = $uploadFile->getClientOriginalName();
        $file = $uploadFile->move($this->container->getParameter('upload_destination'), $fileName);

        $applyArchive = new RecruitApplyArchive();

        $applyArchive->setApply($recruitApply);
        $applyArchive->setArchive($archiveType);
        $applyArchive->setArchiveName($originalFileName);
        $applyArchive->setArchiveFile($fileName);

        $em->persist($applyArchive);
        $em->flush();

        return new JsonResponse(
            [
                'ok' => true,
                'message' => '添加成功',
            ]
        );
    }
}