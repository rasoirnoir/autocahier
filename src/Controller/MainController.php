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
        //ICI possibilité d'appliquer un filtre sur les tournées affichées en fonction des droits de l'utilisateur
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
     * @Route("/tournee/delete/{id}", name="tournee_delete")
     */
    public function deleteTournee(Tournee $tournee, ObjectManager $manager){
        if($tournee != null){
            $manager->remove($tournee);
            $manager->flush();
        }
        return $this->redirectToRoute("main");
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

            $libelle = new Libelle();
            $libelle->setVilleId($ville);

            $pdi->setLibelleId($libelle);

            $edit = false;
        }
        
        $form = $this->createForm(PdiFormType::class, $pdi, [
            'edit' => $edit,
            ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //Vérification de l'existence de la ville et de la rue dans la base de donnée
            //afin d'éviter de créer des doublons
            $allVilles = $this->getDoctrine()->getRepository(Ville::class)->findAll();
            $allLibelles = $this->getDoctrine()->getRepository(Libelle::class)->findAll();

            $nVille = false;
            $nLibelle = false;
            foreach($allVilles as $v){
                if( //On vérifie si une ville du même nom et même code postal existe deja dans la base de données
                $pdi->getLibelleId()->getVilleId()->getName() == $v->getName() 
                    && 
                $pdi->getLibelleId()->getVilleId()->getPostalCode() == $v->getPostalCode()){
                    $pdi->getLibelleId()->setVilleId($v);

                    foreach($allLibelles as $l){ //Si la ville existe deja, on vérifie si un libelle portant de le même nom n'existe pas deja.
                        if($pdi->getLibelleId()->getName() == $l->getName() && $pdi->getLibelleId()->getVilleId() == $l->getVilleId()){
                            $pdi->setLibelleId($l);
                            $nLibelle = true;
                        break;
                        }
                    }
                    $nVille = true;
                break;
                }
            }
            switch(false){
                case $nVille:
                    $pdi->getLibelleId()->getVilleId()->setCreatedAt(new \DateTime());
                    $pdi->getLibelleId()->getVilleId()->setUpdatedAt(new \DateTime());
                case $nLibelle:
                    $pdi->getLibelleId()->setCreatedAt(new \DateTime());
                    $pdi->getLibelleId()->setUpdatedAt(new \DateTime());
                default:
            }
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
     * @Route("/tournee/{tournee}/pdi/{pdi}/delete", name="pdi_delete")
     */
    public function deletePdi(Pdi $pdi, ObjectManager $manager){
        //Attention, à la suppression d'un pdi, l'ordre des suivant doit être décrémenté, sinon ça laisse un trou dans l'ordre
        if($pdi != null){
            $manager->remove($pdi);

            $repo = $this->getDoctrine()->getRepository(Pdi::class);
                $pdisAModifier = $repo->findAllOrderGreaterThanDesc($pdi->getOrdre(), $pdi->getTourneeId()->getId());
                foreach($pdisAModifier as $pdiAModifier){
                    $pdiAModifier->setOrdre($pdiAModifier->getOrdre() - 1);
                    $manager->persist($pdiAModifier);
                } 


            $manager->flush(); 
        }
        return $this->redirectToRoute("tournee_show", ['id' => $pdi->getTourneeId()->getId()]);
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
