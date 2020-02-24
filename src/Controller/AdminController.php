<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        //Gestion de l'affichage de l'interface de gestion de l'administrateur
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/admin/new", name="user_new")
     * @Route("/admin/{id}", name="user_edit")
     */
    public function user(User $user = null, Request $request, ObjectManager $manager){
        if(!$user){
            $user = new User();
        }
        //Créé ou modifie un utilisateur (nom et mdp)
        return $this->render('admin/editUser.html.twig', [
            'user' => $user,
        ]);
    }
}
