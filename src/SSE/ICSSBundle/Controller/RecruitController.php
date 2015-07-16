<?php
/**
 * Created by PhpStorm.
 * User: pc-dll
 * Date: 2015/7/14
 * Time: 15:51
 */

namespace SSE\ICSSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SSE\ICSSBundle\Entity\RecruitApply;
use SSE\ICSSBundle\Entity\RecruitApplyArchive;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
class RecruitController extends Controller
{
    /**
     * @Route("/recruit/pages/{page}",name="SSEICSSBundle_Recruit_list",defaults={"page"=1})
     */
    public function listAction($page)
    {
        $pageSize=20;
        $em=$this->getDoctrine()->getManager();
        $query=$em->createQuery('SELECT r FROM SSEICSSBundle:Recruit ORDER BY r.publishAt DESC');

        $paginator=new Paginator($query);

        $totalRecruits=count($paginator);
        $pagesCount=ceil($totalRecruits/$pageSize);

        $paginator
            ->getQuery()
            ->setFirstResult($pageSize*($page-1))
            ->setMaxResults($pageSize);

        $list=$query->getArrayResult();

        $response=new JsonResponse();

        $response->setData(
            array(
                "totalRecruits"=>$totalRecruits,
                "pagesCount"=>$pagesCount,
                "list"=>$list
            )
        );
        return $response;




    }

    /**
     * @Route("/recruit/detail/{id}",name="SSEICSSBundle_Recruit_detail")
     */
    public function detailAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $repository=$em->getRepository("SSEICSSBundle:Recruit");
        $recruit=$repository->find($id);

        $response=new JsonResponse();
        $response->setData(
            array("recruit"=>$rec=array(
                'publishAt'=>$recruit->getPublishAt(),
                'ended'=>$recruit->getEnded(),
                'intro'=>$recruit->getIntro(),
                'hidden'=>$recruit->getHidden(),
                'applyLimit'=>$recruit->getApplyLimit(),
                'visitCount'=>$recruit->getVisitCount(),
                'id'=>$recruit->getId(),
                'company'=>$recruit->getCompany(),
                'types'=>$recruit->getTypes(),
                'suitableInternTypes'=>$recruit->getSuitableInternTypes(),
                'suitableProjects'=>$recruit->getSuitableProjects()
            ))
        );

        return $response;
    }

    /**
     * @Route("/recruit/apply",name="SSEICSSBundle_Recruit_apply")
     * @Method("POST")
     */
    public function applyAction(Request $request)
    {
        $recruitId=$request->request->get('recruitId');
        $internTypeId=$request->request->get('internTypeId');
        $projectId=$request->request->get('projectId');
        $studentId=$request->request->get('studentId');
        $description=$request->request->get('description');

        $isInTypes=false;
        $isInProjects=false;
        $isUnderLimit=false;

        $em=$this->getDoctrine()->getManager();
        $recruitRepository=$em->getRepository("SSEICSSBundle:Recruit");
        $studentRepository=$em->getRepository("SSEICSSBundle:Student");
        $internTypeRepository=$em->getRepository("SSEICSSBundle:InternType");

        $recruit=$recruitRepository->find($recruitId);
        $student=$studentRepository->find($studentId);
        $internType=$internTypeRepository->find($internTypeId);

        switch ($recruit->getApplyLimit())
        {
            case 0:
                $response=new JsonResponse();
                $response->setData(
                    array(
                        'ok'=>false,
                        'message'=>" 不允许申请。"
                    )
                );
                return $response;
                break;
            case -1:
                $isUnderLimit=true;
                break;
            default:
                $query=$em->createQuery("SELECT COUNT(ra.id) FROM　SSEICSSBundle:RecruitApply ra
                                   WHERE ra.recruit.id = ?1")
                           ->setParameter(1,$recruitId);

                $appliesCount=$query->getScalarResult();
                if ($appliesCount<$recruit->getApplyLimit())
                    $isUnderLimit=true;
                break;
        }

        $suitableInternTypes=$recruit->getSuitableInternTypes();
        $suitableProjects=$recruit->getSuitableProjects();


        foreach($suitableInternTypes as $ainternType)
        {
            if ($internTypeId==$ainternType->getId())
            {
                $isInTypes = true;
                break;
            }
        }
        foreach($suitableProjects as $project)
        {
            if($projectId==$project->getId())
            { $isInProjects=true;
                break;
            }
        }

        if($isInTypes&&$isInProjects&&$isUnderLimit)
        {
            $recruitApply=new RecruitApply();
            $recruitApply->setAt(new\DateTime());
            if($internType->getApprove()) {
                $recruitApply->setApproved(false);
            }
            else{ $recruitApply->setApproved(true);}
            $recruitApply->setCanceled(false);
            $recruitApply->setDescription($description);
            $recruitApply->setStudent($student);
            $recruitApply->setRecruit($recruit);
            $recruitApply->setInternType($internType);
            $em->persist($recruitApply);
            $em->flush();

            $response=new JsonResponse();
            $response->setData(
                array(
                    'ok'=>true,
                    'message'=>"申请成功！"
                )
            );
            return $response;
        }

        else{
            $response=new JsonResponse();
            $response->setData(
                array(
                    'ok'=>false,
                    'message'=>"申请失败，可能有以下原因：（1）申请人数已超过限制。
                    （2）您申请的实习类型与该招聘类型不符。（3）您的年级不符合要求。"
                )
            );
            return $response;
        }

    }
    /**
     * @Route("/recruit/upload",name="SSEICSSBundle_Recruit_upload")
     * @Method("POST")
     */
    public function uploadAction(Request $request)
    {
       // $archiveFile=$request->request->get('archiveFile');
        $archiveFile=$_FILES['archiveFile'];
        $applyId=$request->request->get('applyId');
        $archiveTypeId=$request->request->get('archiveTypeId');
        $archiveName=$request->request->get('archiveName');


        $isTypeOk=false;
        $isTimeOk=false;

        $em=$this->getDoctrine()->getManager();
        $applyRepository=$em->getRepository("SSEICSSBundle:RecruitApply");
        $archiveTypeRepository=$em->getRepository("SSEICSSBundle:InternArchive");

        $recruitApply=$applyRepository->find($applyId);
        $archiveType=$archiveTypeRepository->find($archiveTypeId);

        foreach($archiveType->getSuitableInternTypes() as $type)
        {
            if($type->getId()==$recruitApply->getInternType()->getId())
            {
                $isTypeOk=true;
                break;
            }
        }

        if($archiveType->getAfterApprove())
        {
            if($recruitApply->getApproved())
                $isTimeOk=true;

        }
        else if(!$archiveType->getAfterApprove()){
              $isTimeOk=true;
        }
        else if($archiveType->getAfterApprove()==null){
              $isTimeOk=true;
        }


        if($isTimeOk&&$isTypeOk)
        {
            $applyArchive=new RecruitApplyArchive();

            $applyArchive->setAt(new\DateTime());
            $applyArchive->setArchive($archiveType);
            $applyArchive->setArchiveName($archiveName);
            $applyArchive->setApply($recruitApply);
            $applyArchive->setArchiveFile($archiveFile);

            $recruitApply->addArchive($applyArchive);

            $em->persist($recruitApply);
            $em->persist($applyArchive);
            $em->flush();

            $response=new JsonResponse();
            $response->setData(
                array(
                    'ok'=>true,
                    'message'=>"上传成功。"
                )
            );

        }
        else{
            $response=new JsonResponse();
            $response->setData(
                array(
                    'ok'=>false,
                    'message'=>"上传失败,该实习类型无需上传此类文件或上传时机不对（申请未审批）。"
                )
            );
        }
        return $response;

/*        $applyArchive=new RecruitApplyArchive();

        $form=$this->createFormBuilder($applyArchive)
            ->add('apply','integer')
            ->add('archive','integer')
            ->add('archiveFile','vich_file',array(
                'required'=>false,
                'allow_delete'=>true,
                'download_link'=>true,
            ))
            ->add('upload','submit',array('label'=>'upload'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid())
        {
            return new Response('success');
        }
        return $this->render('SSEICSSBundle:Default:new.html.twig', array(
            'form' => $form->createView(),
        ));*/
    }
}