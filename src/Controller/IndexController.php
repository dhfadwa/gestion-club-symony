<?php
 
namespace App\Controller;
use App\Entity\Club; // Import the Club entity class
use App\Form\PhotoType;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Knp\Component\Pager\PaginatorInterface;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use App\Entity\Photo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Category;
use App\Entity\CategorySearchM;
use App\Entity\Membre;
use App\Entity\CategorieMembre;
use App\Form\CategoryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; // Import the SubmitType class
use App\Entity\CategorySearch;
use App\Form\CtaegorySearchType;
use App\Form\ClubSearchType;

use App\Form\CtaegoryMSearchType;
use App\Entity\ClubSearch;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/",name="home")
     */
    public function loginhome():Response
    {
        return $this->render('dashboard/acc.html.twig');
        

    }
    /**
     * @Route("/home",name="clublist")
     */
    public function homelist()
    {
        $clubs=$this->getDoctrine()->getRepository(Club::class)->findAll();
        return $this->render('clubs/index.html.twig',['clubs'=> $clubs]);
    }

     /**
     * @Route("/list_cat",name="list_cat")
     */
    public function listCategory()
    {
        $categorys=$this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render('clubs/listCategory.html.twig',['categorys'=> $categorys]);
    }

       /**
     * @Route("/list_catMembre",name="list_catMembre")
     */
    public function listCategoryM()
    {
        $categorys=$this->getDoctrine()->getRepository(CategorieMembre::class)->findAll();
        return $this->render('membres/listeCategory.html.twig',['categorys'=> $categorys]);
    }

    /**
     * @Route("/club_category/",name="club_par_cat")
     * Method({"GET","POST"})
     */
    public function clubParCategory(Request $request)
    {
        $categorySearch=new CategorySearch();
        $form=$this->createForm(CtaegorySearchType::class,$categorySearch);
        $form->handleRequest($request);
        $clubs=[];
        if($form->isSubmitted() && $form->isValid())
        {
            $category=$categorySearch->getCategory();
            if($category !="")
            $clubs=$category->getClub();
            else
            $clubs=$this->getDoctrine()->getRepository(Club::class)->findAll();
        }
        return $this->render('clubs/clubsparcategory.html.twig', ['form' => $form->createView(), 'clubs' => $clubs]);

    }
    /**
     * @Route("/club/ajout",name="new_club")
     * Method({"GET","POST"})
     */
    public function addclub(Request $request)
    {
        $club=new Club();
        $form=$this->createFormBuilder($club)
        ->add('nom',TextType::class)
        ->add('email',TextType::class)
        ->add('description',TextType::class)
        ->add('type',TextType::class)
        ->add('category',EntityType::class,['class'=>Category::class,'choice_label'=>'titre','label'=>'categorie'])
        ->add('imageFile', FileType::class) // Add file input field

        ->getForm();
 
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager=$this->getDoctrine()->getManager();

            if ($club->getImageFile()) {
                $imageFile = $club->getImageFile();
                $imageName = md5(uniqid()) . '.' . $imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $imageName
                );
                $club->setImage($imageName);
            }
            $entityManager->persist($club);
            $entityManager->flush();

            return $this->redirectToRoute('clublist');
        
        }
        return $this->render('clubs/newclub.html.twig',['form'=>$form->createView()]);

    }

    /**
     * @Route("club/{id}",name="club_show")
     */
    public function show($id){
        $club=$this->getDoctrine()->getRepository(Club::class)->find($id);
        return $this->render('clubs/show.html.twig',array('club'=>$club));
    }

 
      /**
     * @Route("categorieMembre/{id}",name="categorieMembre_show")
     */
    public function showCMembre($id){
        $category=$this->getDoctrine()->getRepository(CategorieMembre::class)->find($id);
        return $this->render('membres/showcat.html.twig',array('category'=>$category));
    }

     /**
     * @Route("category/{id}",name="category_show") 
     */
    public function showCat($id){
        $category=$this->getDoctrine()->getRepository(Category::class)->find($id);
        return $this->render('clubs/showcat.html.twig',array('category'=>$category));
    }

    /**
     * @Route("club/edit/{id}",name="edit_club")
     * Method({"GET","POST"})
     */
    public function edit(Request $request,$id){
        $club=new Club();
        $club=$this->getDoctrine()->getRepository(Club::class)->find($id);

        $form=$this->createFormBuilder($club)
        ->add('nom',TextType::class)
        ->add('type',TextType::class)
        ->add('description',TextType::class)
        ->add('email',TextType::class)
        ->add('category',EntityType::class,['class'=>Category::class,'choice_label'=>'titre','label'=>'categorie'])
        ->add('imageFile', FileType::class, ['required' => false]) // Permet de ne pas rendre le champ obligatoire pour la modification
        ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager=$this->getDoctrine()->getManager();
             // Gestion de l'image
        if ($club->getImageFile()) {
            $imageFile = $club->getImageFile();
            $imageName = md5(uniqid()) . '.' . $imageFile->guessExtension();
            $imageFile->move(
                $this->getParameter('images_directory'),
                $imageName
            );
            $club->setImage($imageName);
        }
            $entityManager->flush();

            return $this->redirectToRoute('clublist');
        }
        return $this->render('clubs/edit.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @Route("/club/delete/{id}",name="delete_club")
     * Method({"DELETE"})
     */
    public function delete(Request $request,$id){
        $club=$this->getDoctrine()->getRepository(Club::class)->find($id);
        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->remove($club);
        $entityManager->flush();

        return $this->redirectToRoute('clublist');

    }

    /**
     * @Route("/category/newCategory", name="new_category")
     * Method({"GET","POST"})
     */
    public function newCategory(Request $request)
    {
        $category=new Category();
        $form=$this->createFormBuilder($category)
        ->add('titre',TextType::class)
        ->add('description',TextType::class)
       
        ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $category=$form->getData();

            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('list_cat');
        
        }
        return $this->render('clubs/newCategory.html.twig',['form'=>$form->createView()]);
    }
    /**
     * @Route("/category/deletecat/{id}",name="delete_category")
     * Method({"DELETE"})
     */
    public function deletecat(Request $request,$id){
        $category=$this->getDoctrine()->getRepository(Category::class)->find($id);
        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->remove($category);
        $entityManager->flush();

        return $this->redirectToRoute('list_cat');

    }

       /**
     * @Route("/membre/deleteMembre/{id}",name="delete_membre")
     * Method({"DELETE"})
     */
    public function deleteMembre(Request $request,$id){
        $membre=$this->getDoctrine()->getRepository(Membre::class)->find($id);
        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->remove($membre);
        $entityManager->flush();

        return $this->redirectToRoute('list_membre');

    }

     /**
     * @Route("/membre/ajout",name="new_membre")
     * Method({"GET","POST"})
     */
    public function addMembre(Request $request,ParameterBagInterface $parameterBag)
    {
        $membre = new Membre();
    $form = $this->createFormBuilder($membre)
        ->add('nom', TextType::class)
        ->add('email', TextType::class)
        ->add('niveau', TextType::class)
        ->add('telephone', TextType::class)
        ->add('club', EntityType::class, [
            'class' => Club::class,
            'choice_label' => 'nom',
            'label' => 'club'
        ])
        ->add('category', EntityType::class, [
            'class' => CategorieMembre::class,
            'choice_label' => 'titre',
            'label' => 'category'
        ])
        ->add('imageFile', FileType::class) // Add file input field
        
        ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        if ($membre->getImageFile()) {
            $imageFile = $membre->getImageFile();
            $imageName = md5(uniqid()) . '.' . $imageFile->guessExtension();
            $imageFile->move(
                $this->getParameter('images_directory'),
                $imageName
            );
            $membre->setImage($imageName);
        }

        $entityManager->persist($membre);
        $entityManager->flush();

        return $this->redirectToRoute('list_membre');
    }

    return $this->render('membres/newmembre.html.twig', [
        'membre' => $membre,
        'form' => $form->createView(),
    ]);
   
    }

       /**
     * @Route("/list_membre",name="list_membre")
     */
    public function listMembre(Request $request, PaginatorInterface $paginator)
    {
        $membresQuery = $this->getDoctrine()->getRepository(Membre::class)->findAll();

        $pagination = $paginator->paginate(
        $membresQuery, // Requête à paginer
        $request->query->getInt('page', 1), // Numéro de page par défaut
        2 // Nombre d'éléments par page
    );
    return $this->render('membres/listeMembre.html.twig', [
        'pagination' => $pagination
    ]);
    }


    /**
     * @Route("/category/newCategieMembre", name="new_categoryMembre")
     * Method({"GET","POST"})
     */
    public function newCategoryMembre(Request $request)
    {
        $category=new CategorieMembre();
        $form=$this->createFormBuilder($category)
        ->add('titre',TextType::class)
        ->add('description',TextType::class)
       
        ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $category=$form->getData();

            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('list_catMembre');
        
        }
        return $this->render('membres/newCategorie.html.twig',['form'=>$form->createView()]);
    }

     /**
     * @Route("/membre_par_cat/",name="membre_par_cat")
     * Method({"GET","POST"})
     */
    public function MembreParCategory(Request $request)
    {
        $categorySearch=new CategorySearchM();
        $form=$this->createForm(CtaegoryMSearchType::class,$categorySearch);
        $form->handleRequest($request);
        $membres=[];
        if($form->isSubmitted() && $form->isValid())
        {
            $category=$categorySearch->getCategory();
            if($category !="")
            $membres=$category->getMembre();
            else
            $membres=$this->getDoctrine()->getRepository(Membre::class)->findAll();
        }
        return $this->render('membres/findbyCat.html.twig', ['form' => $form->createView(), 'membres' => $membres]);

    }


     /**
     * @Route("/category/deletecatMembre/{id}",name="delete_categoryMembre")
     * Method({"DELETE"})
     */
    public function deletecatMembre(Request $request,$id){
        $category=$this->getDoctrine()->getRepository(CategorieMembre::class)->find($id);
        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->remove($category);
        $entityManager->flush();

        return $this->redirectToRoute('list_catMembre');

    }


       /**
     * @Route("membre/{id}",name="membre_show")
     */
    public function showMembre($id){
        $membre=$this->getDoctrine()->getRepository(Membre::class)->find($id);
        return $this->render('membres/detailleMembre.html.twig',array('membre'=>$membre));
    }


     /**
     * @Route("membre/editMembre/{id}",name="edit_membre")
     * Method({"GET","POST"})
     */
    public function editMembre(Request $request,$id){
        $membre=new Membre();
        $membre=$this->getDoctrine()->getRepository(Membre::class)->find($id);

        $form=$this->createFormBuilder($membre)
        ->add('nom',TextType::class)
        ->add('niveau',TextType::class)
        ->add('telephone',TextType::class)
        ->add('email',TextType::class)
        ->add('category',EntityType::class,['class'=>CategorieMembre::class,'choice_label'=>'titre','label'=>'categorie'])
        ->add('club',EntityType::class,['class'=>Club::class,'choice_label'=>'nom','label'=>'club'])
        ->add('imageFile', FileType::class, ['required' => false]) // Permet de ne pas rendre le champ obligatoire pour la modification
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();

        // Gestion de l'image
        if ($membre->getImageFile()) {
            $imageFile = $membre->getImageFile();
            $imageName = md5(uniqid()) . '.' . $imageFile->guessExtension();
            $imageFile->move(
                $this->getParameter('images_directory'),
                $imageName
            );
            $membre->setImage($imageName);
        }

        $entityManager->flush();

            return $this->redirectToRoute('list_membre');
        }
        return $this->render('membres/editMembre.html.twig',['form'=>$form->createView()]);
    }









    /**
     * @Route("/editcat/{id}",name="edit_cat")
     * Method({"GET","POST"})
     */
    public function editcat(Request $request,$id){
        $category=new Category();
        $category=$this->getDoctrine()->getRepository(Category::class)->find($id);

        $form=$this->createFormBuilder($category)
        ->add('titre',TextType::class)
        ->add('description',TextType::class)
        
        ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager=$this->getDoctrine()->getManager();        
            $entityManager->flush();

            return $this->redirectToRoute('list_cat');
        }
        return $this->render('clubs/updatecat.html.twig',['form'=>$form->createView()]);
    }





    /**
     * @Route("/editcatM/{id}",name="edit_catM")
     * Method({"GET","POST"})
     */
    public function editcategorieMembre(Request $request,$id){
        $category=new CategorieMembre();
        $category=$this->getDoctrine()->getRepository(CategorieMembre::class)->find($id);

        $form=$this->createFormBuilder($category)
        ->add('titre',TextType::class)
        ->add('description',TextType::class)
        
        ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager=$this->getDoctrine()->getManager();        
            $entityManager->flush();

            return $this->redirectToRoute('list_catMembre');
        }
        return $this->render('membres/updatecatMembre.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @Route("/membre_par_club",name="membre_par_club")
     * Method({"GET","POST"})
     */
    public function MembreParClub(Request $request)
    {
        $clubSearch=new ClubSearch();
        $form=$this->createForm(ClubSearchType::class,$clubSearch);
        $form->handleRequest($request);
        $membres=[];
        if($form->isSubmitted() && $form->isValid())
        {
            $club=$clubSearch->getClub();
            if($club !=null){
                foreach($club->getMembre()as $membre){
                    $membres[]=$membre;
                }
            }
            else
            $membres=$this->getDoctrine()->getRepository(Membre::class)->findAll();
        }
        return $this->render('membres/membreparclub.html.twig', ['form' => $form->createView(), 'membres' => $membres]);

    }

  

}
