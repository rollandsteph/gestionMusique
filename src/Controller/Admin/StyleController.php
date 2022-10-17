<?php

namespace App\Controller\Admin;

use App\Entity\Style;
use App\Form\StyleType;
use App\Repository\StyleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StyleController extends AbstractController
{
/**
     * @Route("/admin/styles", name="admin_styles", methods={"GET"})
     */
    public function listeStyles(StyleRepository $repo, PaginatorInterface $paginator, Request $request)
    {
        $styles=$paginator->paginate(
            $repo->listeStylesCompletePaginee(),
            $request->query->getInt('page', 1), /*page number*/
            9/*limit per page*/
        );
        return $this->render('admin/style/listeStyles.html.twig', [
            'lesStyles' => $styles
        ]);

    }

    /**
     * @Route("/admin/style/ajout", name="admin_style_ajout", methods={"GET","POST"})
     * @Route("/admin/style/modif/{id}", name="admin_style_modif", methods={"GET","POST"})
     */
    public function ajoutModifStyle(Style $style=null, Request $request, EntityManagerInterface $manager)
    {
        if($style == null){
            $style=new Style();
            $mode="ajouté";
        }else{
            $mode="modifié";
        }
        $form=$this->createForm(StyleType::class, $style);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid() )
        {
            $manager->persist($style);
            $manager->flush();  
            $this->addFlash("success","Le style a bien été $mode");       
            return $this->redirectToRoute('admin_styles');
        }
        return $this->render('admin/style/formAjoutModifStyle.html.twig', [
            'formStyle' => $form->createView()

        ]);

    }

    /**
     * @Route("/admin/style/suppression/{id}", name="admin_style_suppression", methods={"GET"})
     */
    public function suppressionStyle(Style  $style, EntityManagerInterface $manager)
    {
        $nbAlbums=$style->getAlbums()->count();
        if($nbAlbums>0){
            $this->addFlash("danger","Vous ne pouvez pas supprimer ce style car $nbAlbums album(s) y sont associés");       
        }else{
            $manager->remove($style);
            $manager->flush();  
            $this->addFlash("success","Le style a bien été supprimé");       
        }
        return $this->redirectToRoute('admin_styles');
    }
}
