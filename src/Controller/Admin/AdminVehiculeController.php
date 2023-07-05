<?php

namespace App\Controller\Admin;

use App\Entity\Vehicule;
use App\Form\VehiculeType;
use App\Repository\CommandeRepository;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


#[Route('/gowheels-ad')]
class AdminVehiculeController extends AbstractController
{
  // Vue des véhicules
  #[Route('/vehicules/gestion', name: 'admin_gestion_vehicules')]
  public function gestionVehicules(VehiculeRepository $repo)
  {
    $vehicules = $repo->findAll();
    return $this->render('admin/gestionVehicules.html.twig', [
      'vehicules' => $vehicules
    ]);
  }


  // Modification + Ajout des vehicules
  #[Route('/vehicules/update/{id}', name: 'admin_vehicules_update')]
  #[Route('/vehicules/new', name: 'admin_vehicules_new')]
  public function formVehicule(Request $request, EntityManagerInterface $manager, SluggerInterface $slugger, Vehicule $vehicule = null)
  {
    if ($vehicule == null) {
      $vehicule = new Vehicule;
    }

    $form = $this->createForm(VehiculeType::class, $vehicule);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $imgFile = $form->get('photo')->getData();
      if ($imgFile) {
        $originalFilname = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $slugger->slug($originalFilname);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $imgFile->guessExtension();
        try {
          $imgFile->move(
            $this->getParameter('uploads_directory'),
            $newFilename
          );
        } catch (FileException $e) {
        }
        $vehicule->setPhoto($newFilename);
        $vehicule->setDateEnregistrement(new \DateTime);
        $manager->persist($vehicule);
        $manager->flush();
        return $this->redirectToRoute('admin_gestion_vehicules');
      }
    }

    return $this->render('admin/formVehicule.html.twig', [
      'form' => $form,
      'editMode' => $vehicule->getId() != null
    ]);
  }

  // Suppression des vehicules avec redirection si une commande existe avec le véhicule en question
  #[Route('/vehicules/delete/{id}', name: 'admin_vehicules_delete')]
  public function deleteVehicule(Vehicule $vehicule, EntityManagerInterface $manager, CommandeRepository $commandeRepository)
  {
    $commandes = $commandeRepository->findBy(['vehicule' => $vehicule]);

    if ($commandes) {
      return $this->redirectToRoute('admin_gestion_commandes');
    }

    $manager->remove($vehicule);
    $manager->flush();

    return $this->redirectToRoute('admin_gestion_vehicules');
  }
}
