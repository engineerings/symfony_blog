<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PostsController extends Controller
{

    protected $itemsLimit = 3;
    
    /**
     * @Route(
     *     "/{page}",
     *     name = "blog_index",
     *     defaults = {"page" = 1},
     *     requirements = {"page" = "\d+"}
     * )
     */
    public function indexAction($page)
    {
        $pagination = $this->getPaginatedPosts(array(
            'status' => 'published',
            'orderBy' => 'p.publishDate',
            'orderDir' => 'DESC'
        ), $page);

        return $this->render('posts/postsList.html.twig',
            array(
                'pagination' => $pagination,
                'listTitle'  => 'Najnowsze wpisy'
            ));
    }

    /**
     * @Route(
     *     "/search/{page}",
     *     name = "blog_search",
     *     defaults = {"page" = 1},
     *     requirements = {"page" = "\d+"}
     * )
     */
    public function searchAction(Request $request, $page)
    {
        $searchParam = $request->query->get('search');
        $pagination = $this->getPaginatedPosts(array(
            'status' => 'published',
            'orderBy' => 'p.publishDate',
            'orderDir' => 'DESC',
            'search' => $searchParam
        ), $page);

        return $this->render('posts/postsList.html.twig',
            array(
                'pagination' => $pagination,
                'listTitle'  => sprintf('Search Results %s', $searchParam),
                'searchParam' => $searchParam
            ));

    }


    /**
     * @Route(
     *     "/category/{slug}/{page}",
     *     name = "blog_category",
     *     defaults = {"page" = 1},
     *     requirements = {"page" = "\d+"}
     * )
     */
    public function categoryAction($slug, $page)
    {
        $pagination = $this->getPaginatedPosts(array(
            'status' => 'published',
            'orderBy' => 'p.publishDate',
            'orderDir' => 'DESC',
            'categorySlug' => $slug
        ), $page);

        $CategoryRepo = $this->getDoctrine()->getRepository('AppBundle:Category');
        $Category = $CategoryRepo->findOneBySlug($slug);


        return $this->render('posts/postsList.html.twig',
            array(
                'pagination' => $pagination,
                'listTitle' => sprintf('Entries in category "%s"', $Category->getName())
            ));
    }

    /**
     *
     * @Route(
     *     "/{slug}",
     *     name = "blog_post"
     * )
     */
    public function postAction($slug)
    {
        $PostRepo = $this->getDoctrine()->getRepository('AppBundle:Post');
        $Post = $PostRepo->getPublishedPost($slug);
        if($Post === null) {
            throw $this->createNotFoundException('Post was not found');
        }

        return $this->render('posts/post.html.twig',
            array(
                'post' => $Post
            ));
    }

    /**
     *
     * @Route(
     *     "/tag/{slug}/{page}",
     *     name = "blog_tag",
     *     defaults = {"page" = 1},
     *     requirements = {"page" = "\d+"}
     * )
     */
    public function tagAction($slug, $page)
    {

        $TagRepo = $this->getDoctrine()->getRepository('AppBundle:Tag');
        $Tag = $TagRepo->findOneBySlug($slug);
        $pagination = $this->getPaginatedPosts(array(
            'status' => 'published',
            'orderBy' => 'p.publishDate',
            'orderDir' => 'DESC',
            'tagSlug' => $slug
        ), $page);

        return $this->render('posts/tag.html.twig',
            array(
                'pagination' => $pagination,
                'listTitle' => sprintf('Entries tagged with "%s"', $Tag->getName())
            ));
    }

    protected function getPaginatedPosts(array $params = array(), $page) {
        $PostRepo = $this->getDoctrine()->getRepository('AppBundle:Post');
        $qb = $PostRepo->getQueryBuilder($params);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $this->itemsLimit);
        return $pagination;
    }

}
