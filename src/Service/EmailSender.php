<?php
namespace App\Service;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

/**
 *Service chargé de créer et d'envoyer des Emails
 * 
 */
class EmailSender{

    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Créer un email préconfiguré 
     * @param string $subject Le sujet du mail
     */
    private function createTemplatedEmail(string $subject): TemplatedEmail
    {
        return (new TemplatedEmail())
        // ->to(new Address($user->getEmail(),$user->getPseudo()))
                ->from(new Address('bilal.ghulam.0123@gmail.com','Kritik')) // Expediteur(s)
                ->subject("\u{1F3A7} | $subject") // Objet de l'Email
                ; 
    }

    /**
     * Envoyer un email de confirmation de compte suite à l'inscription
     * @param User $user L'utilisateur devant confirmer son compte
     */
    public function sendAccountConfirmationEmail(User $user ):void
    {
        $email = $this->createTemplatedEmail('Confirmation du compte')
                      ->to(new Address('bilal.ghulam.0123@gmail.com','Kritik'))
                    
                      ->htmlTemplate('email/account_confirmation.html.twig')
                      ->context([
                          'user'=>$user,
                      ])
                  ;

        // envoi de l'Email 
        $this->mailer->send($email);
    }
}
