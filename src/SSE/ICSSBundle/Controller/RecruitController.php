<?php
/**
 * Created by PhpStorm.
 * User: pc-dll
 * Date: 2015/7/14
 * Time: 15:51
 */

namespace SSE\ICSSBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SSE\ICSSBundle\Entity\RecruitApply;
use SSE\ICSSBundle\Entity\RecruitApplyArchive;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Util\SecureRandom;

class RecruitController extends Controller
{
    /**
     * @Route("/recruit/list/{page}",name="recruitList",defaults={"page"=1})
     * @Template()
     */
    public function listAction($page)
    {
        $data = $this->container->get('sse.icss.recruit_service')->listRecruits($page);

        return $data;
    }

    /**
     * @Route("/recruit/detail/{id}",name="recruitDetail")
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
                'company' => [
                    'name' => $recruit->getCompany()->getName(),
                    'id' => $recruit->getCompany()->getId(),
                ],
                'types' => $recruit->getTypes()->map(
                    function ($t) {
                        return $t->getName();
                    }
                )->toArray(),
                'suitableInternTypes' => $recruit->getSuitableInternTypes()->map(
                    function ($t) {
                        return $t->getName();
                    }
                )->toArray(),
                'suitableProjects' => $recruit->getSuitableProjects()->map(
                    function ($p) {
                        return $p->getName();
                    }
                )->toArray(),
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
        if ($appliesCount >= $recruit->getApplyLimit() && $recruit->getApplyLimit() !== -1) {
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