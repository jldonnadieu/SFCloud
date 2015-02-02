<?php

namespace HB\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use HB\BlogBundle\Form\ArticleType;
use \HB\BlogBundle\Entity\Article;

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
        $repository = $this->getDoctrine()->getRepository("HBBlogBundle:Article");
        $articles = $repository->findAll();
        return array('articles'=>$articles);
    }
    /**
     * Affiche un formulaire de modification
     * 
     * @Route("/{id}/edit")
     * @Template("HBBlogBundle:Article:add.html.twig")
     */    
    public function editAction(Article $article)
    {
        // On crée un formulaire
        $article->setModificationDate(new \DateTime());
        $form = $this->createForm(new ArticleType,$article);
        // On récupère la requete
        $request = $this->get('request');
        // On vérifie qu'elle est de type POST pour voir si un formulaire a été soumis
        if ($request->getMethod() == 'POST') {
            // On fait le lien Requête <-> Formulaire
            // À partir de maintenant, la variable $article contient les valeurs entrées dans 
            // le formulaire par le visiteur
            $form->bind($request);
            // On vérifie que les valeurs entrées sont correctes
            // (Nous verrons la validation des objets en détail dans le prochain chapitre)
            if ($form->isValid()) {
                // On l'enregistre notre objet $article dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                // On redirige vers la page de visualisation de l'article nouvellement créé
                return $this->redirect($this->generateUrl('hb_blog_article_read', array('id' => $article->getId())));
            }
        }
        if ($article->getId()>0){
            $editForm = true;
        } else {
            $editForm = false;
        }

        // On passe la méthode createView() du formulaire à la vue afin qu'elle puisse afficher 
        // le formulaire toute seule, on a d'autres méthodes si on veut personnaliser
        return array( 'form' => $form->createView() ,'editForm' => $editForm);            
    }
    /**
     * Affiche un formulaire de création
     * 
     * @Route("/add")
     * @Template()
     */
    public function addAction()
    {
        $article = new Article();
        return $this->editAction($article);
    }
    /**
     * Affiche un article sur un id
     * 
     * @Route("/{id}")
     * @Template()
     */
    public function readAction(Article $article)
    {
        return Array('article' => $article);
    }
    /**
     * Affiche un formulaire de suppression
     * 
     * @Route("/{id}/delete")
     * @Template()
     */
    public function deleteAction(Article $article)
    {
        $form = $this->createForm(new ArticleType,$article);
        // On récupère la requete
        $request = $this->get('request');
        // On vérifie qu'elle est de type POST pour voir si un formulaire a été soumis
        if ($request->getMethod() == 'POST') {
            // On fait le lien Requête <-> Formulaire
            // À partir de maintenant, la variable $article contient les valeurs entrées dans 
            // le formulaire par le visiteur
            $form->bind($request);
            // On vérifie que les valeurs entrées sont correctes
            // (Nous verrons la validation des objets en détail dans le prochain chapitre)
            //if ($form->isValid()) {
                // On l'enregistre notre objet $article dans la base de données
                $em = $this->getDoctrine()->getManager();
                //$em->persist($article);
                $em->remove($article);
                $em->flush();

                // On redirige vers la page de visualisation de l'article nouvellement créé
                return $this->redirect($this->generateUrl('hb_blog_article_index', array()));
            //}
        }

        // On passe la méthode createView() du formulaire à la vue afin qu'elle puisse afficher 
        // le formulaire toute seule, on a d'autres méthodes si on veut personnaliser
        return array( 'form' => $form->createView(),'article'=>$article );            
    }
}
