<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController  extends Controller
{

    /**
     * objec writing log
     * 
     * @var object
     */
    protected $logger;

    public function _init()
    {
        $this->logger = $this->get('logger');
    }

    /**
     * Show error page
     *
     * @return error view
     */
    protected function errorAction()
    {
        return $this->render('common/error.html.twig', [
           'page_title' => 'page not found'
        ]);
    }
}