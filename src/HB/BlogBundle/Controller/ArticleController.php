<?php

namespace HB\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @author jld
 * 
 * 
 * @Route("/article")
 */
class ArticleController extends Controller
{
    /**
     * Liste tous les articles
     * 
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    /**
     * Affiche un formulaire de création
     * 
     * @Route("/add")
     * @Template()
     */
    public function addAction()
    {
        return array();
    }
    /**
     * Affiche un article sur un id
     * 
     * @Route("/{id}")
     * @Template()
     */
    public function readAction($id)
    {
        $repository = $this->getDoctrine()->getRepository("HBBlogBundle:Article");
        
        $article = $repository->find($id);
        
        return Array('article' => $article);
    }
    /**
     * Affiche un formulaire de modification
     * 
     * @Route("/{id}/edit")
     * @Template()
     */
    public function editAction($id)
    {
        return array('id' => $id);
    }
    /**
     * Affiche un formulaire de suppression
     * 
     * @Route("/{id}/delete")
     * @Template()
     */
    public function deleteAction($id)
    {
        return array('id' => $id);
    }
}
