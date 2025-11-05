<?php
/**
 * Created by PhpStorm.
 * User: m.benhenda <benhenda.med@gmail.com>
 * Date: 10/07/2015
 * Time: 23:17
 */

namespace CAB\UserBundle\Controller;

use CAB\UserBundle\Form\Type\RegistrationFormType;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
class RegistrationController extends BaseController
{
	private $formFactory;

	/*public function __construct(\Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher, \FOS\UserBundle\Form\Factory\FactoryInterface $formFactory, \FOS\UserBundle\Model\UserManagerInterface $userManager, \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage)
	{
		parent::__construct($eventDispatcher, $formFactory, $userManager, $tokenStorage);
		$this->formFactory = $formFactory;
	}*/

	public function registerAction(Request $request, $layout = 1, $idVehicule = 0, $role = null)
    {
        $securityContext = $this->get('security.authorization_checker');


        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        //$formFactory = $this->get('fos_user.registration.form.factory');
        //$formFactory = $this->formFactory;
		//$this->process($this->container);

        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');


        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $tokenStorage = $this->container->get('security.token_storage');

        $form = $this->createForm(
            RegistrationFormType::class
        );

        //$form = $formFactory->createForm($securityContext);
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                /*if ($roleCreated != 'ROLE_USER' && !$request->request->has('reg_booking')) {
                    $user->setRoles(array($roleCreated));
                    $userManager->updateUser($user);
                    $textOption = $user->getFirstName().' '.$user->getLastName();
                    $response = new JsonResponse();
                    $response->setData(
                        array(
                            'status' => 1,
                            'id' => $user->getId(),
                            'text' => $textOption,
                            'role' => $roleCreated,
                        )
                    );
                }*/
                $url = $this->generateUrl('fos_user_registration_confirmed');
                $response = new RedirectResponse($url);
            }
            /*else {
                if ($user->getRoles()[0] != 'ROLE_USER') {
                    $response = new JsonResponse();
                    $response->setData(
                        array(
                            'status' => 0,
                        )
                    );
                }
            }*/
            //$dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        if ($layout == 1) {
            $tpl = 'CABUserBundle:Registration:register.html.twig';
            $role = 'ROLE_CUSTOMER';
        } elseif ($layout == 0) {
            $tpl = 'CABUserBundle:Registration:register_modal.html.twig';
        } elseif ($layout == 2) {
            $tpl = 'CABUserBundle:Registration:register_before_booking.html.twig';
        }

        return $this->render($tpl, array(
            'form' => $form->createView(),
            'role' => $role,
        ));
    }

    /**
     * Tell the user to check his email provider
     */
    public function checkEmailAction()
    {
        $email = $this->get('session')->get('fos_user_send_confirmation_email/email');
        $this->get('session')->remove('fos_user_send_confirmation_email/email');
        $user = $this->get('fos_user.user_manager')->findUserByEmail($email);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with email "%s" does not exist', $email));
        }



        return $this->render('FOSUserBundle:Registration:checkEmail.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * Receive the confirmation token from user email provider, login the user
     */
    public function confirmAction(Request $request, $token)
    {
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user->setConfirmationToken(null);
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRM, $event);

        $userManager->updateUser($user);

        if (null === $response = $event->getResponse()) {
            $url = $this->generateUrl('fos_user_registration_confirmed');
            $response = new RedirectResponse($url);
        }

        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRMED, new FilterUserResponseEvent($user, $request, $response));

        return $response;
    }

    /**
     * Tell the user his account is now confirmed
     */
    public function confirmedAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->render('FOSUserBundle:Registration:confirmed.html.twig', array(
            'user' => $user,
        ));
    }
}