<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
/**
 * @IsGranted("ROLE_USER")
 */
class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="app_account")
     * @var \App\Entity\User $user 
     */
    public function index()
    {
        
        $user = $this->getUser();
        dd($user);
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
            'user' => $user
        ]);
    }

    /**
     * @Route("/api/account", name="api_account")
     */
    public function accountApi()
    {
        $user = $this->getUser();
        dd($user);
        return $this->json($user, 200, [], [
            'groups' => ['main']
        ]);
    }
}
