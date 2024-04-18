<?php

namespace App\Controller;
use App\Entity\Evenement;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Club;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class EvenementController extends AbstractController
{
    /**
     * @Route("/evenement/listevenement", name="list_evenement")
     */
    public function index(): Response
    {
        $evenements=$this->getDoctrine()->getRepository(Evenement::class)->findAll();
        return $this->render('evenement/index.html.twig',['evenements'=> $evenements]);
    }


    /**
     * @Route("/evenements/ajout",name="new_evenement")
     * Method({"GET","POST"})
     */
    public function addEvenement(Request $request)
    {
        $evenement=new Evenement();
        $form=$this->createFormBuilder($evenement)
        ->add('nom',TextType::class)
        ->add('date',TextType::class)
        ->add('contexte',TextType::class)
        ->add('description',TextType::class)
        ->add('lieu',TextType::class)
        ->add('club',EntityType::class,['class'=>Club::class,'choice_label'=>'nom','label'=>'club'])
        ->add('imageFile', FileType::class) // Add file input field

        ->getForm();
 
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager=$this->getDoctrine()->getManager();

            if ($evenement->getImageFile()) {
                $imageFile = $evenement->getImageFile();
                $imageName = md5(uniqid()) . '.' . $imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $imageName
                );
                $evenement->setPostulaire($imageName);
            }
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('list_evenement');
        
        }
        return $this->render('evenement/newevenement.html.twig',['form'=>$form->createView()]);

    }


     /**
     * @Route("/evenement/delete/{id}",name="delete_evenement")
     * Method({"DELETE"})
     */
    public function delete(Request $request,$id){
        $evenement=$this->getDoctrine()->getRepository(Evenement::class)->find($id);
        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->remove($evenement);
        $entityManager->flush();

        return $this->redirectToRoute('list_evenement');

    }

         /**
     * @Route("/evenement/show/{id}",name="evenement_show")
     */
    public function show($id){
        $evenement=$this->getDoctrine()->getRepository(Evenement::class)->find($id);
        
        return $this->render('evenement/show.html.twig',array('evenement'=>$evenement));
    }

    /**
     * @Route("evenement/editEvenement/{id}",name="edit_evenement")
     * Method({"GET","POST"})
     */
    public function edit(Request $request,$id){
        $evenement=new Evenement();
        $evenement=$this->getDoctrine()->getRepository(Evenement::class)->find($id);

        $form=$this->createFormBuilder($evenement)
        ->add('nom',TextType::class)
        ->add('contexte',TextType::class)
        ->add('lieu',TextType::class)
        ->add('date',TextType::class)
        ->add('description',TextType::class)
        ->add('imageFile', FileType::class, ['required' => false]) // Permet de ne pas rendre le champ obligatoire pour la modification
        ->add('club',EntityType::class,['class'=>Club::class,'choice_label'=>'nom','label'=>'club'])
        
        
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();

        // Gestion de l'image
        if ($evenement->getImageFile()) {
            $imageFile = $evenement->getImageFile();
            $imageName = md5(uniqid()) . '.' . $imageFile->guessExtension();
            $imageFile->move(
                $this->getParameter('images_directory'),
                $imageName
            );
            $evenement->setImage($imageName);
        }

        $entityManager->flush();

            return $this->redirectToRoute('list_evenement');
        }
        return $this->render('evenement/edit.html.twig',['form'=>$form->createView()]);
    }

}
