<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureForm;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoitureController extends AbstractController
{
    #[Route('/voiture', name: 'app_voiture')]
    public function Listevoiture(VoitureRepository $vr): Response
    {
        $voitures = $vr->findAll();
        return $this->render('voiture/Listevoiture.html.twig', [
            'Listevoiture' => $voitures,
        ]);
    }

    #[Route('/addvoiture', name: 'addvoiture')]
    public function addvoiture(Request $request, EntityManagerInterface $em)
    {
        $voiture = new Voiture();
        $form = $this->createForm(VoitureForm::class, $voiture);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em->persist($voiture);
            $em->flush();
            return $this->redirectToRoute("app_voiture");
        }
        return $this->render("voiture/addvoiture.html.twig", ["FormV" => $form->createView()]);
    }

    #[Route('/voiture/{id}', name: 'voituredelete')]
    public function delete(EntityManagerInterface $em, VoitureRepository $vr, $id): Response
    {
        $voiture = $vr->find($id);
        $em->remove($voiture);
        $em->flush();

        return $this->redirectToRoute('app_voiture');
    }
    #[Route('/voitureupdate/{id}', name: 'voitureupdate')]
    public function voitureupdate(Request $request, EntityManagerInterface $em, VoitureRepository $vr, $id): Response
    {
        $voiture=$vr->find($id);
        $editform=$this->createForm(VoitureForm::class , $voiture);
        $editform->handleRequest($request);
        if ($editform->isSubmitted()and $editform->isValid())
        {
            $em->persist($voiture);
            $em->flush();
            return $this->redirectToRoute('app_voiture');
        }
        return $this->render('voiture/updatevoiture.html.twig',['editFormVoiture'=>$editform->createView()]);
    }



    #[Route('/searchVoitures', name: 'searchVoitures')]
    public function searchVoitures(Request $request, EntityManagerInterface $em): Response
    {
        $voitures = null;

        if ($request->isMethod('POST'))
        {
            $serie=$request->request->get("input_serie");
            $query = $em->createQuery(
                "SELECT v FROM App\Entity\Voiture v
               where v.serie LIKE '".$serie."'");
    $voitures=$query->getResult();
        }
return  $this->render("voiture/rechercheVoiture.html.twig",
    ["voitures"=>$voitures]
);

}



    #[Route('/search', name: 'search')]
    public function search(Request $request, EntityManagerInterface $em): Response
    {
        $voiture = null;

        if ($request->isMethod('POST'))
        {
            $libelle=$request->request->get("input_libelle");
            $query = $em->createQuery(
                "SELECT v FROM App\Entity\Voiture v join v.marque m
               where m.libelle LIKE '".$libelle."'");
            $voiture=$query->getResult();
        }
        return  $this->render("voiture/voiturelibelle.html.twig",
            ["voiture"=>$voiture]
        );

    }



}




