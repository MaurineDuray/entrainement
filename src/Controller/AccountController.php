<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountController extends AbstractController
{
    /**
     * Permet à l'utilisateur de se connecter, via la route de nom "account_login que nous avons renseigné dans le fichier security.yaml, on renvoie si il y a une erreur lors de la connexion et la variable username
     *
     * @param AuthenticationUtils $utils
     * @return Response
     */
    #[Route('/login', name: 'account_login')]
    public function index(AuthenticationUtils $utils): Response
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('account/index.html.twig', [
            'hasError' => 'error!==null',
            'username' => $username
        ]);
    }

    /**Permet à l'utilisateur de se déconnecter */
    #[Route("/logout",name:"account_logout")]
    public function logout():void
    {

    }

    /**Permet l'inscription d'un nouveau compte user */
    #[Route("/register", name:"account_register")]
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher):Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $hash = $hasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre compte a bien été créé"
            );

            return $this->redirectToRoute('account_login');
        }

        return $this->render("account/registration.html.twig",[
            'myform'=>$form->createView()
        ]);
    }

    /**
     * Permet d'éditer les infos d'un utilisateur connecté 
     */
    #[Route("/account/profile", name:"account_profile")]
    public function profile(Request $request, EntityManagerInterface $manager):Response
    {
        $user = $this->getUser(); //récup le user de l'utilisateur connecté 
        $form = $this->createForm(AccountType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager ->persist($user);
            $manager ->flush();

            $this->addFlash(
                'success',
                "Vos données ont été enregistrées avec succès"
            );

        }
        return $this->render("account/profile.html.twig",[
            'myform'=> $form->createView()
        ]);

    }
}
