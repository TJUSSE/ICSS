<?php
/**
 * Created by PhpStorm.
 * User: YiRo
 * Date: 2015/7/17
 * Time: 12:21
 */


namespace SSE\ICSSBundle\Controller;
use Ddeboer\DataImport\Reader\CsvReader;
use Ddeboer\DataImport\Workflow;
use Ddeboer\DataImport\Writer\DoctrineWriter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
 * @Route("/import")
 * @Template()
 */
class ImportController extends Controller
{
    /**
     * @Route("/students")
     */
    public function studentsAction()
    {
        $file=new \SplFileObject("D:/ICSS/input.csv");
        $reader=new CsvReader($file);
        $reader->setHeaderRowNumber(0);
        $workflow=new Workflow($reader);
        $em=$this->getDoctrine()->getEntityManager();
        $em->getConnection()->exec("SET FOREIGN_KEY_CHECKS=0;");
        $resault=$workflow->addWriter(new DoctrineWriter($em,"SSEICSSBundle:Student"))->process();
        $em->getConnection()->exec("SET FOREIGN_KEY_CHECKS=1;");
        return [];
    }
}