<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Security\LoginFormAuthenticator;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
            http://localhost:8000/security/confirm/' . $user->getToken() . '',
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
        //dd($user);
        $role = array('ROLE_ADMIN');
        $user->setConfirm(true);
        $user->setToken(rand());
        $user->setRoles($role);
        $manager->persist($user);
        $manager->flush();

        return $this->redirectToRoute('app_account');
        /*$urlToken = $request->attributes->get('token');
        $userFetchToken = $this->getDoctrine()->getRepository(User::class);
        $userToken = $userFetchToken->findBy(array(
            'token' => '$urlToken')
        );
        dd($userToken);
        if ($user === $urlToken):
        echo 'OUEEEEEE';
        endif; */
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
     * @Route("/logout", name="app_logout")
     */

    public function logout() 
    {
        throw new \Exception('will be intercepted before getting here');
    }

}
