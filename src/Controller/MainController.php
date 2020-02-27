<?php

namespace App\Controller;

use App\Entity\Pdi;
use App\Entity\Tournee;
use App\Form\PdiFormType;
use App\Repository\TourneeRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
     * @Route("/pdi/new", name="pdi_new")
     * @Route("/pdi/{id}", name="pdi_edit")
     */
    public function pdi(Pdi $pdi = null, Request $request, ObjectManager $manager){
        if(!$pdi){
            $pdi = new Pdi();
        }
        /*
        $form = $this->createFormBuilder($pdi)
                    ->add('clientName')
                    ->add('numero')
                    ->add('isReex', CheckboxType::class, [
                        'false_values' => [0, '0'],
                        ])
                    ->getForm();
        */

        $form = $this->createForm(PdiFormType::class, $pdi);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if(!$pdi->getId()){
                $pdi->setCreatedAt(new \DateTime());
            }
            $pdi->setUpdatedAt(new \DateTime());

            $manager->persist($pdi);
            $manager->flush();

            return $this->redirectToRoute("tournee_show", ['id' => $pdi->getTourneeId()]);
        }

        return $this->render('main/editPdi.html.twig', [
            'formPdi' => $form->createView(),
            'editMode' => $pdi->getId() !== null,
        ]);
    }
}
