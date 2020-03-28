<?php

namespace App\Controller;

use App\Entity\Libelle;
use App\Entity\Pdi;
use App\Entity\Tournee;
use App\Entity\Ville;
use App\Form\PdiFormType;
use App\Repository\TourneeRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main")
     * @Route("/", name="root")
     */
    public function index(TourneeRepository $repo)
    {
        $tournees = $repo->findAll();
        return $this->render('main/index.html.twig', [
            'tournees' => $tournees,
        ]);
    }

    /**
     * @Route("/tournee/{id}", name="tournee_show")
     */
    public function tournee(Tournee $tournee){
        return $this->render('main/show.html.twig',[
            'tournee' => $tournee,
        ]);
    }

    /**
     * @Route("/tournee/{tournee}/pdi/new", name="pdi_new")
     * @Route("/tournee/{tournee}/pdi/{pdi}", name="pdi_edit")
     */
    public function pdi(Tournee $tournee, Pdi $pdi = null, Request $request, ObjectManager $manager){
        $edit = true;
        if(!$pdi){
            $pdi = new Pdi();
            $pdi->setTourneeId($tournee);
            $pdi->setOrdre(0);

            $ville = new Ville();
            $ville->setCreatedAt(new \DateTime());
            $ville->setUpdatedAt(new \DateTime());

            $libelle = new Libelle();
            $libelle->setVilleId($ville);
            $libelle->setCreatedAt(new \DateTime());
            $libelle->setUpdatedAt(new \DateTime());

            $pdi->setLibelleId($libelle);

            $edit = false;
        }
        
        $form = $this->createForm(PdiFormType::class, $pdi, [
            'edit' => $edit,
            ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if(!$pdi->getId()){
                $pdi->setCreatedAt(new \DateTime());
            }
            $pdi->setUpdatedAt(new \DateTime());


            $manager->persist($pdi);
            $manager->flush();

            return $this->redirectToRoute("tournee_show", ['id' => $pdi->getTourneeId()->getId()]);
        }

        return $this->render('main/editPdi.html.twig', [
            'pdiNum' => $pdi->getNumero(),
            'pdiLibelle' => $pdi->getLibelleId(),
            'formPdi' => $form->createView(),
            'editMode' => $pdi->getId() !== null,
        ]);
    }
}
