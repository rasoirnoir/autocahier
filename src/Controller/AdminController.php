<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(UserRepository $repo)
    {
        $users = $repo->findAll();
        //Gestion de l'affichage de l'interface de gestion de l'administrateur
        return $this->render('admin/index.html.twig',[
            'users' => $users,
        ]);
    }

    /**
     * @Route("/admin/new", name="user_new")
     * @Route("/admin/{id}", name="user_edit")
     */
    public function user(User $user = null, Request $request, ObjectManager $manager){
        if(!$user){
            $user = new User();
        }

        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if(!$user->getId()){
                $user->setCreatedAt(new \DateTime());
            }

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute("admin");
        }

        //Créé ou modifie un utilisateur (nom et mdp)
        return $this->render('admin/editUser.html.twig', [
            'formUser' => $form->createView(),
            'editMode' => $user->getId() !== null,
        ]);
    }

    /**
     * @Route("/admin/delete/{id}", name="user_delete")
     */
    public function deleteUser(User $user, ObjectManager $manager){
        if($user != null){
            $manager->remove($user);
            $manager->flush();
        }
        return $this->redirectToRoute("admin");
    }
}
