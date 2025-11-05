<?php
/**
 * File header placeholder
 */

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\UserBundle\Model\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Controller\SecurityController as ParentController;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Tests\JsonSerializableObject;

/**
 * Class CheckoutController
 */
class CheckoutController extends Controller
{

	public function __construct()
	{

	}

	/**
	 * main checkout page.
	 *
	 * @Route("/checkout", name="checkout",
	 *
	 * )
	 */
	public function checkoutAction()
	{
		if ($this->get('security.authorization_checker')->isGranted('ROLE_USER'))
		{
			$cart = $this->get('domain.cart');
			$cart->setCurrentCartToOnlineShopping();
			$cart->ManipulateShoppingCart();

			$user =  $this->getUser();
			$customer_number = $user->getCustomerNumber();
			//$customer_number = 3850;

			$card_details = $this
				->get('domain.api')
				->getPaymentMethodByCustomerNumber(
					$customer_number
				);
			//dump($card_details);die;
			return $this->render(':checkout:checkout.html.twig',['cart'=>$cart,'card_details'=>$card_details,'me'=>$user,'payment'=>true]);

		}
		else{

			return new RedirectResponse($this->generateUrl('fos_user_security_login',['target_path'=>$this->generateUrl('checkout')]));
		}



	}

	/**
	 * main home page.
	 *
	 * @Route("/checkout/download/{order_id}", name="download_order",defaults = {
	 *          "order_id" = ""})
	 */
	public function downloadOrderAction($order_id)
	{
		if(is_numeric($order_id))
		{
			$user =  $this->getUser();
			$cart = $this->get('domain.cart');

			$order = $this->getDoctrine()->getRepository('AppBundle:PurchaseVideoOrder')->find($order_id);
			if($order->getUserId() == $user->getId())
			{
				$orderData = unserialize($order->getOrderData());

				$old_cart = $this->get('domain.cart');
				$old_cart->setCurrentCartToPrevOnlineShopping();
				$old_cart->updateCurrentCart($orderData, true);


				return $this->render(':checkout:checkout.html.twig', ['cart' => $old_cart]);
			}
			else{
				return new RedirectResponse($this->generateUrl('home'));
			}
		}
		else{
			return new RedirectResponse($this->generateUrl('checkout'));
		}
	}

}
?>