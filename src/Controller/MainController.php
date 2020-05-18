<?php

namespace App\Controller;

use App\Entity\Libelle;
use App\Entity\Pdi;
use App\Entity\Tournee;
use App\Entity\Ville;
use App\Form\PdiFormType;
use App\Repository\PdiRepository;
use App\Repository\TourneeRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
     * @Route("/tournee/new", name="tournee_new")
     */
    public function newTournee(Request $request, ObjectManager $manager){
        
        $tournee = new Tournee();
        
        $form = $this->createFormBuilder($tournee)
            ->add('name', TextType::class, ['label' => 'Nom de la tournée'])
            ->getForm()
        ;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tournee->setCreatedAt(new \DateTime());
            $tournee->setUpdatedAt(new \DateTime());

            $manager->persist($tournee);
            $manager->flush();

            return $this->redirectToRoute("tournee_show", ['id' => $tournee->getId()]);
        }

        return $this->render('main/newTournee.html.twig', [
            'formTournee' => $form->createView(),
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
     * @Route("/tournee/{tournee}/pdi/new/{order}", name="pdi_new")
     * @Route("/tournee/{tournee}/pdi/{pdi}", name="pdi_edit")
     */
    public function pdi(Tournee $tournee, Pdi $pdi = null, int $order = -1, Request $request, ObjectManager $manager){
        $edit = true;
        if(!$pdi){
            if($order > -1){
                //Si un ordre est donné (on ajoute le pdi au milieu de la tournée)
                //alors il va falloir décaler tous les autres pour insérer celui-là
                $repo = $this->getDoctrine()->getRepository(Pdi::class);
                $pdisAModifier = $repo->findAllOrderGreaterThanDesc($order, $tournee->getId());
                foreach($pdisAModifier as $pdiAModifier){
                    $pdiAModifier->setOrdre($pdiAModifier->getOrdre() + 1);
                    $manager->persist($pdiAModifier);
                }                
            }
            else{
                $order = -1;
            }
            $pdi = new Pdi();
            $pdi->setTourneeId($tournee);
            $pdi->setOrdre($order);

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

    /**
     * @Route("/dump/tournee/{id}", name="dump_tournee")
     */
    function dumpQuery(Tournee $tournee){
        //Tests des requêtes
        $doctrine = $this->getDoctrine();
        $doctrineConnection = $doctrine->getConnection();
        $stack = new \Doctrine\DBAL\Logging\DebugStack();
        $doctrineConnection->getConfiguration()->setSQLLogger($stack);
        $em = $doctrine->getManager();

        $pdiRepo = $em->getRepository(Pdi::class);

        $pdis = $pdiRepo->findByOrder(4, $tournee->getId());
        $pdis = $pdiRepo->findTopOrder($tournee->getId());
        $pdis = $pdiRepo->findAllOrderGreaterThanDesc(3, $tournee->getId());

        return $this->render('main/dump.html.twig',[
            'stack' => $stack,
        ]);
    }
}
