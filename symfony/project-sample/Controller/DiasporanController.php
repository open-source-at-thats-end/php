<?php

declare(strict_types=1);

namespace App\Controller;

use App\Domain\Diasporan\PostJob;
use App\Domain\Diasporan\PostJobCommand;
use App\Domain\Diasporan\Register;
use App\Domain\Diasporan\RegisterCommand;
use App\Entity\Diasporan;
use App\Entity\Customer;
use App\Form\Diasporan\PostJobCommandType;
use App\Form\Diasporan\RegisterCommandType;
use App\ReadModel\JobPostingHistory;
use App\Repository\DiasporanRepository;
use App\Security\CustomerAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

/**
 * @Route("/diasporans", name="diasporan_")
 */
final class DiasporanController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(
        Request $request,
        Register $register,
        DiasporanRepository $diasporanRepository,
        GuardAuthenticatorHandler $guardAuthenticatorHandler,
        CustomerAuthenticator $customerAuthenticator
    ): Response {
        $form = $this->createForm(RegisterCommandType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var RegisterCommand $command */
            $command = $form->getData();
            $register($command);

            $diasporan = $diasporanRepository->findOneByEmail($command->email);
            if (null === $diasporan) {
                throw new \LogicException();
            }

            $guardAuthenticatorHandler->authenticateUserAndHandleSuccess($diasporan, $request, $customerAuthenticator, 'main');

            return $this->redirectToRoute('diasporan_verification_email');
        }

        return $this->render('diasporan/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/", name="dashboard")
     */
    public function dashboard(Request $request, PostJob $postJob, JobPostingHistory $jobPostingHistory): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        /** @var Customer $user */
        $user = $this->getUser();

        $user->setIsLogin(true);
        $entityManager->flush();

        /** @var Diasporan $diasporan */
        $diasporan = $this->getUser();
        $command = new PostJobCommand();
        $command->posterId = $diasporan->getId();

        $form = $this->createForm(PostJobCommandType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var PostJobCommand $command */
            $command = $form->getData();
            $postJob($command);

            return $this->redirectToRoute('diasporan_dashboard');
        }

        return $this->render('diasporan/dashboard.html.twig', [
            'postings' => $jobPostingHistory->forDiasporan($diasporan->getId()),
            'form' => $form->createView(),
        ]);
    }
}
