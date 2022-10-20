<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

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
}
