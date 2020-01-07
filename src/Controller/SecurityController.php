<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Form\ForgotPasswordType;
use App\Repository\UserRepository;

use App\Security\LoginFormAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Repository\RepositoryFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer){
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $role = array('ROLE_TO_VALID');
            $user->setPassword($hash);
            $manager->persist($user);
            $user->setToken(rand());
            $user->setConfirm(false);
             $user->setRoles($role);                 
            $manager->flush();

            $message = (new \Swift_Message('Mail de Confirmation'))
            ->setFrom('send@example.com')
            ->setTo($user->getEmail())
            ->setBody(
                'Voici le lien pour confirmer votre compte : </br>
            http://localhost:8000/confirmation/' . $user->getToken() . '',
                'text/html'
            );
            $mailer->send($message);
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);


    }
    
    /**
     * @Route("/confirmation/{token}", name="security_confirmation")
     */
    public function confirm(User $user, ObjectManager $manager)
    {
        $role = array('ROLE_ADMIN');
        $user->setConfirm(true);
        $user->setToken(rand());
        $user->setRoles($role);
        $manager->persist($user);
        $manager->flush();

        return $this->redirectToRoute('app_account');
    }
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }
    /**
     * @Route("/forgotten", name="app_forgot_pass")
     */
    public function passwordForgotten(\Swift_Mailer $mailer, Request $request, UserRepository $repo)
    {
        $form = $this->createFormBuilder()
            ->add('email', EmailType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $repo->findOneByEmail($form["email"]->getData());
            $message = (new \Swift_Message('Mail de Confirmation'))
            ->setFrom('send@example.com')
            ->setTo($user->getEmail())
            ->setBody(
                'Voici le lien pour confirmer votre compte : </br>
            http://localhost:8000/reset/' . $user->getToken() . '',
                'text/html'
            );
            $mailer->send($message);
            return $this->redirectToRoute('app_login');
        }
           
        
            return $this->render('security/forgotten_password.html.twig', [
                'formEmail' => $form->createView()
            ]);
        }
    
    /**
     * @Route("/reset/{token}", name="app_reset_pass")
     */
    public function resetPassword( \Swift_Mailer $mailer, User $user, Request $request, UserPasswordEncoderInterface $encoder, UserRepository $repo, ObjectManager $manager)
    {
        
        $form = $this->createFormBuilder($user)
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent corresspondre !',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ])
            ->getForm();
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
        //dd($user->getPassword());
        $hash = $encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($hash);
        $manager->persist($user);
        $manager->flush();

        return $this->redirectToRoute('app_login');    
        }
        return $this->render('security/reset_password.html.twig', [
            'resetEmail' => $form->createView()
        ]);
    }


    /**
     * @Route("/logout", name="app_logout")
     */

    public function logout() 
    {
        throw new \Exception('will be intercepted before getting here');
    }

}
