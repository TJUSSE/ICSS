<?php
/**
 * Created by PhpStorm.
 * User: pc-dll
 * Date: 2015/7/14
 * Time: 15:51
 */

namespace SSE\ICSSBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SSE\ICSSBundle\Entity\RecruitApply;
use SSE\ICSSBundle\Entity\RecruitApplyArchive;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

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
     * @Template()
     */
    public function detailAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("SSEICSSBundle:Recruit");
        $recruit = $repository->find($id);

        $applied = false;

        if ($this->getUser()) {
            $studentId = $this->getUser()->getId();

            // 是否已经申请过该职位?
            $query = $em->createQuery(
                "SELECT COUNT(ra) FROM SSEICSSBundle:RecruitApply ra WHERE ra.student = :studentid AND ra.recruit = :recruitid"
            )
                ->setParameter('studentid', $studentId)
                ->setParameter('recruitid', $id);

            if ($query->getSingleScalarResult() >= 1) {
                $applied = true;
            }
        }

        return ['recruit' => $recruit, 'applied' => $applied];
    }

    /**
     * @Route("/recruit/apply/{id}",name="recruitApply")
     * @Template()
     * @param Request $request
     */
    public function applyAction($id, Request $request)
    {
        if ($this->getUser() === null || !$this->get('security.authorization_checker')->isGranted(
                'ROLE_APPLY_RECRUIT'
            )
        ) {
            return [
                'ok' => false,
                'message' => '您没有权限',
            ];
        }

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $studentId = $this->getUser()->getId();
        $student = $em->getRepository('SSEICSSBundle:Student')->find($studentId);

        $recruitId = $id;
        $recruit = $em->getRepository("SSEICSSBundle:Recruit")->find($recruitId);

        // 是否已经申请过该职位? 如果已经申请过，则显示自己的申请记录或更新记录
        $query = $em->createQuery(
            "SELECT ra FROM SSEICSSBundle:RecruitApply ra WHERE ra.student = :studentid AND ra.recruit = :recruitid"
        )
            ->setParameter('studentid', $studentId)
            ->setParameter('recruitid', $recruitId);

        /** @var RecruitApply $apply */
        $apply = $query->getOneOrNullResult();

        // 已有申请记录~
        if ($apply != null) {
            // 是否是文件上传？
            if ($request->files->get('file') !== null) {
                $archiveTypeId = $request->request->get('archiveTypeId');
                // 检查是否可以递交该类型的档案
                $valid = false;
                $archiveTypeRepository = $em->getRepository("SSEICSSBundle:ArchiveType");
                $archiveType = $archiveTypeRepository->find($archiveTypeId);

                foreach ($archiveType->getSuitableInternTypes() as $type) {
                    if ($type->getId() == $apply->getInternType()->getId()) {
                        $valid = true;
                        break;
                    }
                }

                if (!$valid) {
                    return [
                        'ok' => false,
                        'message' => '该实习性质不能递交该类型档案',
                    ];
                }

                // 检查递交时机
                $valid = false;
                if ($archiveType->getAfterApprove()) {
                    // 必须在审批后递交
                    $valid = $apply->getApproved();
                }
                if ($archiveType->getAfterApply()) {
                    // 申请后就可以递交
                    $valid = true;
                }
                if (!$valid) {
                    return [
                        'ok' => false,
                        'message' => '现在不能递交该类型档案',
                    ];
                }

                /** @var UploadedFile $uploadFile */
                $uploadFile = $request->files->get('file');

                // 根据文件内容生成新的文件名
                $fileName = hash_file('sha1', $uploadFile->getRealPath());
                $originalFileName = $uploadFile->getClientOriginalName();
                $uploadFile->move($this->container->getParameter('upload_destination'), $fileName);

                $applyArchive = new RecruitApplyArchive();

                $applyArchive->setApply($apply);
                $applyArchive->setAt(new \DateTime());
                $applyArchive->setArchiveType($archiveType);
                $applyArchive->setArchiveName($originalFileName);
                $applyArchive->setArchiveFile($fileName);

                $em->persist($applyArchive);
                $em->flush();
                $this->addFlash('notice', '档案上传成功！');
            } else {
                // 是递交：更新描述
                if ($request->getMethod() === 'POST') {
                    $description = $request->request->get('intro');
                    $apply->setDescription($description);
                    $em->flush();
                    $this->addFlash('notice', '申请更新成功！');
                }
            }

            return [
                'ok' => true,
                'view' => true,
                'recruit' => $recruit,
                'apply' => $apply,
                'archiveTypes' => $apply->getInternType()->getAvailableArchiveTypes(),
                'archives' => $apply->getArchives(),
            ];
        }

        // 检查是否在申请名额内
        $query = $em->createQuery(
            "SELECT COUNT(ra.id) FROM SSEICSSBundle:RecruitApply ra WHERE ra.recruit = :recruitid"
        )
            ->setParameter('recruitid', $recruitId);

        $appliesCount = $query->getSingleScalarResult();
        if ($appliesCount >= $recruit->getApplyLimit() && $recruit->getApplyLimit() !== -1) {
            return [
                'ok' => false,
                'message' => "该招聘信息申请名额已满",
            ];
        }

        // 检查学生学历
        $valid = false;
        $suitableProjects = $recruit->getSuitableProjects();
        foreach ($suitableProjects as $_project) {
            if ($student->getProject()->getId() === $_project->getId()) {
                $valid = true;
                break;
            }
        }

        if (!$valid) {
            return [
                'ok' => false,
                'message' => '您的学历不能申请该招聘',
            ];
        }

        $suitableInternTypes = $recruit->getSuitableInternTypes()->filter(
            function ($internType) use ($student) {
                $show = false;
                foreach ($internType->getSuitableProjects() as $proj) {
                    if ($proj->getId() === $student->getProject()->getId()) {
                        $show = true;
                        break;
                    }
                }

                return $show;
            }
        );

        if ($request->getMethod() === 'GET') {
            return [
                'ok' => true,
                'recruit' => $recruit,
                // 筛选适用学历
                'suitableInternTypes' => $suitableInternTypes,
            ];
        }

        $internTypeId = $request->request->get('internType');
        $description = $request->request->get('intro');

        $internType = $em->getRepository("SSEICSSBundle:InternType")->find($internTypeId);

        // 检查所申请的实习性质
        $valid = false;
        $suitableInternTypes = $recruit->getSuitableInternTypes();
        foreach ($suitableInternTypes as $_type) {
            if ($internTypeId == $_type->getId()) {
                $valid = true;
                break;
            }
        }

        if (!$valid) {
            return [
                'ok' => false,
                'message' => '该招聘不能作为'.$internType->getName().'申请',
            ];
        }

        // 检查该实习性质所适合学历
        $valid = false;
        foreach ($internType->getSuitableProjects() as $proj) {
            if ($proj->getId() === $student->getProject()->getId()) {
                $valid = true;
                break;
            }
        }

        if (!$valid) {
            return [
                'ok' => false,
                'message' => '该实习性质不适合您的学历',
            ];
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

        $this->addFlash('notice', '申请成功！');

        return $this->redirectToRoute('recruitApply', ['id' => $id]);
    }

    /**
     * @Route("/archive/{name}", name="archiveDownload")
     * @param $name
     * @return BinaryFileResponse
     */
    public function downloadArchiveAction($name)
    {
        $em = $this->getDoctrine()->getManager();
        $archive = $em->getRepository('SSEICSSBundle:RecruitApplyArchive')->findOneBy(
            [
                'archiveFile' => $name,
            ]
        );

        if ($archive === null) {
            throw new ResourceNotFoundException();
        }

        $file = $this->container->getParameter('upload_destination').'/'.$archive->getArchiveFile();
        $response = new BinaryFileResponse($file);
        $response->trustXSendfileTypeHeader();
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $archive->getArchiveName(),
            iconv('UTF-8', 'ASCII//TRANSLIT', $archive->getArchiveName())
        );

        return $response;
    }
}