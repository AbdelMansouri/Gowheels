<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\MembreRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/gowheels-ad')]
class AdminCommandeController extends AbstractController
{
  // Vue des commandes
  #[Route('/commandes/gestion', name: 'admin_gestion_commandes')]
  public function gestionCommandes(CommandeRepository $repo)
  {
    $commandes = $repo->findAll();
    return $this->render('admin/gestionCommande.html.twig', [
      'commandes' => $commandes
    ]);
  }

  // Modification des commandes
  #[Route('/commandes/update/{id}', name: 'admin_commandes_update')]
  public function formMembre(Request $request, EntityManagerInterface $manager, Commande $commande)
  {
    $form = $this->createForm(CommandeType::class, $commande);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $manager->persist($commande);
      $manager->flush();
      return $this->redirectToRoute('admin_gestion_commandes');
    }

    return $this->render('admin/formCommande.html.twig', [
      'form' => $form,
      'commande' => $commande,
    ]);
  }

  // Suppression des commandes
  #[Route('/commandes/delete/{id}', name: 'admin_commandes_delete')]
  public function deleteVehicule(Commande $commande, EntityManagerInterface $manager)
  {
    $manager->remove($commande);
    $manager->flush();
    return $this->redirectToRoute('admin_gestion_commandes');
  }
}
