<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
Use AppBundle\Entity\Feed;
use Doctrine\ORM\Tools\Pagination\Paginator;


class RssController extends BaseController
{
    
    public function listAction()
    {
        // $em = $this->getDoctrine()->getManager();
        // $allOurBlogPosts = $em->getRepository(Feed::class)->findAll();
        // $paginator  = $this->get('knp_paginator');
        // $blogPosts = $paginator->paginate($allOurBlogPosts, 2, 100);
        return $this->render('rss/index.html.twig', [ 
           'items' => 'ok'
        ]);
    }
}
