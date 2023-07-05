<?php

namespace App\Controller\Admin;

use App\Entity\Membre;
use App\Form\MembreType;
use App\Repository\MembreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/gowheels-ad')]
class AdminMembreController extends AbstractController
{
  // Vue des membres
  #[Route('/membres/gestion', name: 'admin_gestion_membres')]
  public function gestionMembres(MembreRepository $repo)
  {
    $membres = $repo->findAll();
    return $this->render('admin/gestionMembres.html.twig', [
      'membres' => $membres
    ]);
  }

  // Modification des membres
  #[Route('/membres/update/{id}', name: 'admin_membres_update')]
  public function formMembre(Request $request, EntityManagerInterface $manager, Membre $membre)
  {
    $form = $this->createForm(MembreType::class, $membre);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $manager->persist($membre);
      $manager->flush();
      return $this->redirectToRoute('admin_gestion_membres');
    }

    return $this->render('admin/formMembre.html.twig', [
      'form' => $form,
      'editMode' => $membre->getId() != null
    ]);
  }
}
