<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Vehicule;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CarController extends AbstractController
{
  // Accueil du site
  #[Route('/', name: 'accueil')]
  public function index(VehiculeRepository $repo)
  {
    $vehicules = $repo->findAll();
    return $this->render('car/index.html.twig', [
      'vehicules' => $vehicules
    ]);
  }

  // Vu de tout les véhicules
  #[Route('/vehicules', name: 'vehicules')]
  public function listVehicules(VehiculeRepository $repo)
  {
    $vehicules = $repo->findAll();
    return $this->render('car/vehicules.html.twig', [
      'vehicules' => $vehicules
    ]);
  }

  // Vue d'un véhicule avec formulaire de commande
  #[Route('/vehicules/details/{id}', name: 'vehicules_details')]
  public function detailsVehicule(Request $request, EntityManagerInterface $manager, Security $security, Vehicule $vehicule, Commande $commande = null)
  {
    $form = $this->createForm(CommandeType::class, $commande);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $commande = $form->getData();

      $heureDepart = $commande->getDateHeureDepart();
      $heureFin = $commande->getDateHeureFin();
      $interval = $heureDepart->diff($heureFin);
      $days = $interval->days + 1;
      $prixJournalier = $vehicule->getPrixJournalier();
      $commande->setPrixTotal($days * $prixJournalier);

      $membre = $security->getUser();
      $commande->setMembre($membre);

      $commande->setVehicule($vehicule);

      $commande->setDateEnregistrement(new \DateTime());

      $manager->persist($commande);
      $manager->flush();

      return $this->redirectToRoute('command_confirm', ['id' => $commande->getId()]);
    }

    return $this->render('car/details.html.twig', [
      'vehicule' => $vehicule,
      'form' => $form->createView(),
    ]);
  }

  // Confirmation de commande
  #[Route('/commande/confirm/{id}', name: 'command_confirm')]
  public function confirmCommand($id, CommandeRepository $repo)
  {
    $commande = $repo->find($id);
    if (!$commande) {
      return $this->redirectToRoute('accueil');
  }
    return $this->render('car/command-confirm.html.twig', [
      'commande' => $commande
    ]);
  }
}
