<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PagesController extends Controller
{
    /**
     * @Route(
     *     "/about",
     *     name = "blog_about"
     * )
     */
    public function aboutAction()
    {
        return $this->render('pages/about.html.twig');
    }
    /**
     * @Route(
     *     "/contact",
     *     name = "blog_contact"
     * )
     */
    public function contactAction()
    {
        return $this->render('pages/contact.html.twig');
    }
}