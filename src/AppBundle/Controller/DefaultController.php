<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Utils\Utils;
use AppBundle\Utils\MysqlDB;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Configuration;
Use AppBundle\Entity\Feed;

class DefaultController extends BaseController
{
    use Utils;

    /**
     * [$client description]
     * @var object
     */
    protected $client = null;

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        // return $this->render('dsds/index.html.twig', [ 
        //    'krol' => 'ok'
        // ]);
    }
}


