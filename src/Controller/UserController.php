<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/* Para cifrar las contraseñas */
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

// LOGIN
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class UserController extends AbstractController
{
    
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {

        // Crear formulario
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        // Rellenamos el objeto del formulario con lo que envía la request
        $form->handleRequest($request);

        // Comprobación si el formluario ha llegado
        if($form->isSubmitted() && $form->isValid()){
            $user->setRole('ROLE_USER');

            $user->setCreatedAt(new \Datetime('now'));
            

            // Cifrado de contraseña
            $encoded = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($encoded);

            // Guardar usuario
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('tasks');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function login(AuthenticationUtils $authenticationUtils){
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', array(
            'error' => $error,
            'last_username' => $lastUsername
        ));
    }
}
