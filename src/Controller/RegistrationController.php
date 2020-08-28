<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Service\EmailSender;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    private $manager;
    public function __construct(EntityManagerInterface $entityManagerInterface){
        $this->manager = $entityManagerInterface;
      
    }
    
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EmailSender $emailSender): Response
    {
        
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récuperation des données de formulaire (entité User + mot de pass)
            $user = $form->getData();
            // encode the plain password
            $password = $form->get('plainPassword')->getData();

            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $password
                )
            );

            $user->renewToken();
            
            
            $this->manager->persist($user);
            $this->manager->flush();

            // do anything else you need here, like send an email

            $this->addFlash('success','Vous avez bien été inscrit');
            $emailSender->sendAccountConfirmationEmail($user);
            $this->addFlash('success','Un mail de confirmation vous a été envoyé');
            return $this->redirectToRoute('home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * Confirmation du compte (via un lien envoyé par email)
     * @Route("/confirm-account/{id<\d+>}/{token}", name="account_confirmation")
     */

     public function confirmAccount($id,$token, UserRepository $repository){
        
        // Recherche de l'utilisateur
        $user = $repository->findOneBy([
            'id'=>$id,
            'token'=>$token
        ]);

        if($user==null){
            $this->addFlash('danger','Utilisateur ou jeton invalide');
            return $this->redirectToRoute('app_login');
        }

        // Utilisateur trouvé: confirmation du compte 
        $user
            ->confirmAccount()
            ->renewToken()
            ;
        $this->manager->flush();
        $this->addFlash('success','Votre compte à bien été confirmé');
        return $this->redirectToRoute('app_login');
     }

}
