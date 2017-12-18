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
}