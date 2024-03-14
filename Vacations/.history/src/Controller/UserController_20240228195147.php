<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\Test\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

use function PHPUnit\Framework\equalTo;

#[Route('/users')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData(),
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordEncoder): Response
    {
        $user = $entityManager->getRepository(User::class)->find($user->getId());
        $this->checkOnTeamChange($request, $user, $entityManager);


        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);


        $newPassword = $form->get('password')->getData();
        if (!empty($newPassword)) {
            $encodedPassword = $passwordEncoder->hashPassword($user, $newPassword);
            $user->setPassword($encodedPassword);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }


    private function checkOnTeamChange(Request $request, User $newUser, EntityManagerInterface $entityManager): void
    {
        $user = $user = $this->getUser();
        error_log($oldUser . "------------------------");

        /*         $oldMail = $oldUser->getEmail();
        $newMail = $newUser->getEmail();

        $staroIme = $oldUser->getName();
        $novoIme = $newUser->getName();

        error_log($oldMail . "------------------------");
        error_log($staroIme . "------------------------");

        $oldTeamLeader = $oldUser->getTeam()->getTeamLeader();
        $oldProjectLeader = $oldUser->getTeam()->getProjectLeader(); */
    }

    /*             if (is_null($form->get('team')->getData())) {
                if ($oldTeamLeader === $user) {
                    $oldTeam = $entityManager->find(Team::class, $user->getTeam()->getId());
                    $oldTeam->setTeamLeader(null);
                }

                if ($oldProjectLeader === $user) {
                    $oldTeam = $entityManager->find(Team::class, $user->getTeam()->getId());
                    $oldTeam->setProjectLeader(null);
                }
            } else {
                $newTeam = $form->get('team')->getData();

                $newTeamLeader = $newTeam->getProjectLeader();
                $newProjectLeader = $newTeam->getProjectLeader();

                if ($oldTeamLeader !== $newTeamLeader) {
                    $oldTeam = $entityManager->find(Team::class, $user->getTeam()->getId());
                    $oldTeam->setTeamLeader(null);
                }

                if ($oldProjectLeader !== $newProjectLeader) {
                    $oldTeam = $entityManager->find(Team::class, $user->getTeam()->getId());
                    $oldTeam->setProjectLeader(null);
                }
            }

            if ($oldTeamLeader !== $newTeamLeader || is_null($newTeamLeader)) {
                $oldTeam = $entityManager->find(Team::class, $user->getTeam()->getId());
                $oldTeam->setTeamLeader(null);
            }
            if ($oldProjectLeader !== $newProjectLeader || is_null($newTeamLeader)) {
                $oldTeam = $entityManager->find(Team::class, $user->getTeam()->getId());
                $oldTeam->setProjectLeader(null);
            } */
}
