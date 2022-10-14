<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AnnonceType;
use App\Repository\AdRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * Permet d'afficher l'ensemble des annonces
     *
     * @param AdRepository $repo
     * @return Response
     */
    #[Route('/ads', name: 'ads_index')]
    public function index(AdRepository $repo): Response
    {
        $ads = $repo->findAll();

        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
        ]);
    }


    #[Route("/ads/new", name:"ads_create")]
    public function create(): Response
    {
        $ad = new Ad();

      
        $form = $this->createFormBuilder($ad)
                    ->add('title')
                    ->add('introduction')
                    ->add('content')
                    ->add('rooms')
                    ->add('price')
                    ->getForm();

        $form = $this->createForm(AnnonceType::class, $ad);

        return $this->render("ad/new.html.twig",[
            'myform' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher une annonce via son slug(titre)
     */
    #[Route('/ads/{slug}', name:'ads_show')]
    public function show(string $slug, Ad $ad):Response
    {
        dump($ad);
        return $this->render('ad/show.html.twig',[
            'ad' => $ad
        ]);
    }
}
