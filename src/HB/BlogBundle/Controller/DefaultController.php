<?php

namespace HB\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }
    /**
     * @Route("/fr/{name}")
     * @Template()
     */
    public function frAction($name)
    {
        return array('name' => $name);
    }
    /**
     * @Route("/")
     * @Template()
     */
    public function blogAction()
    {
        $repository = $this->getDoctrine()->getRepository("HBBlogBundle:Article");
        $articles = $repository->findAll();
        return array('articles'=>$articles);
    }
}
