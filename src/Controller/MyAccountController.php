<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use App\Repository\MembreRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MyAccountController extends AbstractController
{
  // Accueil mon compte
  #[Route('/my-account', name: 'my_account')]
  public function myAccountAffichage()
  {
    return $this->render('my_account/index.html.twig', []);
  }

  // Affichage commandes de l'utilisateur
  #[Route('/my-account/commandes', name: 'my_account_commandes')]
  public function myAccountCommandes(CommandeRepository $repo)
  {
    $commandes = $repo->findBy(['membre' => $this->getUser()]);
    $commandesCount = count($commandes);
    return $this->render('my_account/myCommands.html.twig', [
      'commandes' => $commandes,
      'commandesCount' => $commandesCount,
    ]);
  }

  // Affichage commandes de l'utilisateur
  #[Route('/my-account/infos', name: 'my_account_infos')]
  public function myAccountInfos()
  {
    $membre = $this->getUser();
    return $this->render('my_account/myInfos.html.twig', [
      'membre' => $membre,
    ]);
  }
}
