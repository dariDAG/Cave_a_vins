<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManager;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Void_;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $erreur = $authenticationUtils->getLastAuthenticationError();
        $lastEmail = $authenticationUtils->getLastUsername();

        return $this->render('login/formLogin.html.twig', [
            'erreur' => $erreur,
            'lastEmail' => $lastEmail
        ]);
    }

    #[Route('/logout', name: 'deconnexion')]
    public function logout()
    {
    }

    #[Route('/user/new', name: 'user.new')]
    public function new(Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $em, MailerInterface $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($user);
            $post = $request->get('user');
            dump($post);
            $user->addRole($post['role']);
            //$user->setRoles([$post['role']]);
            dump($user);
            $psw = $hasher->hashPassword($user, $post['password']);
            $user->setPassword($psw);
            dump($user);
            $em->persist($user);
            $em->flush();

            $this->sendEmail($mailer, $user);


            return $this->redirectToRoute('user.new');
        }

        return $this->renderForm(
            'login/formNew.html.twig',
            ['formNew' => $form]
        );
    }

    #[Route('/user/list', name: 'user.list')]
    public function list(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('login/list.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/user/{id}', name: 'user.show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('login/show.html.twig', [
            'user' => $user,
        ]);
    }

    // #[Route('/user/{id}/edit', name: 'user.edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(UserType::class, $user);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('user.list', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('login/edit.html.twig', [
    //         'user' => $user,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/user/{id}/edit', name: 'user.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        

        if ($request->getMethod() === 'POST') {
            //dump($request->get('email'));
            //dump($user->getEmail());
            $email = $request->get('email');
            if ($email !== $user->getEmail()) {
                $user->setEmail($email);
                $entityManager->flush();
                
            }
            return $this->redirectToRoute('user.list');
        }

        return $this->renderForm('login/formEdit.html.twig', [
            'user' => $user,
            
        ]);
    }



    #[Route('/user/{id}', name: 'id.delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user.list', [], Response::HTTP_SEE_OTHER);
    }

    private function sendEmail(MailerInterface $mailer, User $client): Void
    {
        $email = (new Email())
            ->from($this->getUser()->getEmail())
            ->to($client->getEmail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Création de votre compte client')
            ->text('Votre compte client a bien été crée!')
            ->html('<h4>Votre compte client a bien été crée!</h4>');

        $mailer->send($email);

       
    }

}
