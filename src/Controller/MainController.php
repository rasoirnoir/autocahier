<?php

namespace App\Controller;

use App\Entity\Pdi;
use App\Entity\Tournee;
use App\Repository\TourneeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/pdi/{id}", name="pdi_show")
     */
    public function pdi(Pdi $pdi){
        $form = $this->createFormBuilder($pdi)->add('clientName')->add('isReex')->getForm();
        return $this->render('main/editPdi.html.twig', [
            'pdi' => $pdi,
            'formPdi' => $form->createView(),
        ]);
    }
}
