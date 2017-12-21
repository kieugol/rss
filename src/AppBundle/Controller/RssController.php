<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
Use AppBundle\Entity\Feed;
use Doctrine\ORM\Tools\Pagination\Paginator;


class RssController extends BaseController
{
    /**
     * Show list items data of RSS and filter category name
     *
     * @param  Request $request   the object contains request parameters
     * @return view               display page list items data
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository(Feed::class)->createQueryBuilder('f');

        $categoryFilter = trim($request->query->get('filter'));
        if (!empty($categoryFilter)) {
            $queryBuilder
                ->where('f.category LIKE :param')
                ->setParameter('param', '%' . $categoryFilter . '%');
        }

        $query = $queryBuilder->getQuery();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 20)
        );
        return $this->render('rss/index.html.twig', [ 
           'list_item'  => $pagination,
           'page_title' => 'list item'
        ]);
    }
}
