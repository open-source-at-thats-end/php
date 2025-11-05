<?php
/**
 *	File Name		:	Cart.php
 *	Purpose			:	Provide database routine for cart management
 **/

namespace AppBundle\Domain;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Repository\VideoRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use DateTime;
use AppBundle\Entity\VideoPurchase;
use AppBundle\Entity\PurchaseVideoOrder;
use Doctrine\Common\Persistence\ObjectRepository;

define('CART_KEY_NAME',                 'SHOPPING_CART');
define('CART_CURCART',                  'CurCart');
define('CART_ITEM',                     'Item');

define('CART_KEY_ONLINESHOPPING',       'ONLINESHOPPING');
define('CART_KEY_ONLINESHOPPING_PREV',  'ONLINESHOPPING_PREV');

define('CART_LAST_ORDER_BATCH_ID',                          'LastOrderBatchId');
define('CART_LAST_ORDER_PAYMENT_ID',                        'LastOrderPaymentId');
define('CART_SHOPPING_ITEM',                                'PurchaseItem');
define('CART_SHOPPING_BUSINESS_ITEM',                       'BusinessPurchaseItem');

define('CART_SHOPPING_AVAILABLE_OFFER_ONITEM',              'AvailableOfferOnItem');
define('CART_SHOPPING_AVAILABLE_OFFER_ONTOTALPURCHASE',     'AvailableOfferOnTotalPurchase');
define('CART_SHOPPING_APPLIED_OFFER_ONITEM',                'AppliedOfferOnItem');
define('CART_SHOPPING_APPLIED_OFFER_ONTOTALPURCHASE',       'AppliedOfferOnTotalPurchase');
define('CART_SHOPPING_APPLIED_COUPON',                      'AppliedCoupon');
define('CART_SHOPPING_APPLIED_COUPON_INFO',                 'AppliedCouponInfo');
define('CART_SHOPPING_APPLIED_COUPON_OFFER',                'AppliedCouponOffer');
define('CART_SHOPPING_GRAND_TOTAL',                         'GrandTotal');
define('CART_SHOPPING_PURCHASECALCULATETOTAL',              'PurchaseCalculateTotal');
define('CART_SHOPPING_PLACEDORDER',                         'PlacedOrder');
define('CART_SHOPPING_STEP',                                'Step');
define('CART_ORDER_BILLING_INFO',                           'OrderBillingInfo');
define('CART_ORDER_SHIPPING_INFO',                          'OrderShippingInfo');
define('CART_ORDER_PAYMENT_GATEWAY_INFO',                   'OrderPaymentGatewayInfo');
define('CART_ORDER_PAYMENT_GATEWAY_SETUP',                  'OrderPaymentGatewaySetup');
define('CART_ORDER_SHIPPING_GATEWAY_INFO',                  'OrderShippingGatewayInfo');
define('CART_ORDER_SHIPPING_METHOD',                        'OrderShippingMethod');

define('CART_SHOPPING_BUSINESS_ORDER_GRAND_TOTAL',         'BusinessOrderGrandTotal');

###############################################################################

define('REQ_ACTION',                                        'action');
define('REQ_REF_ID',                                        'ref_id');
define('REQ_REF_TYPE',                                      'ref_type');
define('REQ_REF_QTY',                                       'ref_qty');
define('REQ_REF_COUPON_CODE',                               'ref_coupon_code');
define('REQ_ACT_ITEM_ADD',                                  'ItemAdd');
define('REQ_ACT_ITEM_REMOVE',                               'ItemRemove');
define('REQ_ACT_APPLY_COUPON',                              'ApplyCoupon');
define('REQ_ACT_PLACE_ORDER',                               'PlaceOrder');

define('REQ_IRTYPE_VIDEO',                                  '1');

define('RES_STATUS_CODE_SUCCESS',                               '200');

class Cart
{
	/**
	 * @var VideoRepository
	 *
	 * Video repository
	 */
	private $videoRepository;

	/**
	 * @var SessionInterface
	 *
	 * Session
	 */
	private $session;

	/**
	 * @var VideoUrlResolver
	 *
	 * Video url resolver
	 */
	private $videoUrlResolver;

	/**
	 * @var EntityRepository
	 *
	 * Repository
	 */
	private $profileRepository;

	/**
	 * @var TokenStorageInterface
	 *
	 * Token Storage
	 */
	private $tokenStorage;

	/**
	 * @var VideoPurchaseManager
	 *
	 * Video purchase manager
	 */
	private $videoPurchaseManager;

	/**
	 * @var API
	 *
	 * API
	 */
	private $API;

	/**
	 * @var EntityManagerInterface
	 *
	 * Entity Manager
	 */
	private $entityManager;



	public  $Basket			=	array();

	private $REQ;
	private $REQ_ACTION;
	private $REQ_REF_ID;
	private $REQ_REF_TYPE;
	private $REQ_REF_QTY;
	private $REQ_COUPON_CODE;

	public function __construct(VideoRepository $videoRepository,
	                            SessionInterface $session,
	                            VideoUrlResolver $videoUrlResolver,
	                            EntityRepository $profileRepository,
	                            TokenStorageInterface $tokenStorage,
	                            VideoPurchaseManager $videoPurchaseManager,
								API $API,
								EntityManagerInterface $entityManager
								//EntityManagerInterface $puchasevideoManager

								)
	{
		$this->videoRepository = $videoRepository;
		$this->session = $session;
		$this->videoUrlResolver = $videoUrlResolver;
		$this->profileRepository = $profileRepository;
		$this->tokenStorage = $tokenStorage;
		$this->videoPurchaseManager = $videoPurchaseManager;
		$this->API                  = $API;
		$this->entityManager = $entityManager;
		//$this->puchasevideoManager = puchasevideoManager;

		# Populate the cart
		$this->populateCart();

		$this->SetBasketStructure();
	}
	private function getUserProfile()
	{
		# get current user, whether it is logged or not because need to decide price based on that
		$user = $this->tokenStorage->getToken()->getUser();

		# If user is not logged in
		if($user == 'anon.')
		{
			# get price of free profile
			$profile_detail = $this
				->profileRepository
				->find(1);
		}
		# If user if logged in
		else
		{
			$profile_detail = $user->getProfile();
		}
		return $profile_detail;
	}
	private function CheckVideoDownloadable($video)
	{
		$user = $this->tokenStorage->getToken()->getUser();
		if($user == 'anon.')
		{
			$r = false;
		}
		else
		{
			$r = $this->videoPurchaseManager->isVideoDownloadable($user, $video);
		}
		return $r;
	}
	private function getReqItem($ref_id, $ref_type, $ref_qty)
	{
		$return = false;

		switch($ref_type)
		{
			case REQ_IRTYPE_VIDEO:

				$video = $this->videoRepository->getVideo($ref_id);
				if($video->getId() == $ref_id)
				{
					$profile_detail = $this->getUserProfile();
					$downloadable = $this->CheckVideoDownloadable($video);

					if($downloadable != true)
					{

						$item_id  = $ref_type."_".$ref_id;
						$quantity = $ref_qty;
						$discount = 0;

						$price = $profile_detail->getParcourHDDownload();

						$subtotal_amount = $price * $quantity;
						$total_amount    = number_format($subtotal_amount - $discount, 2);

						$item             = array();
						$item['id']       = $ref_id;
						$item['type']     = $ref_type;
						$item['title']    = $video->getTitle();
						$item['image']    = $this->videoUrlResolver->getVideoImage($video);
						$item['price']    = $price;
						$item['quantity'] = $quantity;
						$item['discount'] = $discount;

						$item['subtotal_amount'] = $subtotal_amount;
						$item['total_amount']    = $total_amount;

						$item['etc']['event']['id']    = $video->getEvent()->getID();
						$item['etc']['event']['title'] = $video->getEvent()->getTitle();

						$item['etc']['round']['id']    = $video->getRound()->getID();
						$item['etc']['round']['title'] = $video->getRound()->getTitle();

						$item['etc']['rider']['id']    = $video->getRider()->getID();
						$item['etc']['rider']['title'] = $video->getRider()->getName();

						$item['etc']['horse']['id']    = $video->getHorse()->getID();
						$item['etc']['horse']['title'] = $video->getHorse()->getName();

						$final_item[$item_id] = $item;
						$return = $final_item;
					}



				}

				break;
			case "":

				break;
		}
		return $return;
	}
	#######################################################################
	#######################################################################
	#######################################################################

	public function init($POST)
	{
		# change current cart to shopping cart
		$this->setCurrentCart(CART_KEY_ONLINESHOPPING);
		$cart = $this->getCurrentCart();

		if(!is_array($cart) || (is_array($cart) && count($cart) <= 0))
		{
			$this->SetBasketStructure(true);
			$cart = $this->getCurrentCart();
			$this->updateCurrentCart($cart,true);
		}

		# check posted data
		if($this->CheckRequest($POST) !== true)
			return false;

		$r=array('error'=>'Unable to process your request');

		switch($this->REQ_ACTION)
		{
			case REQ_ACT_ITEM_ADD:
				$r = $this->AddItem();
				break;
			case REQ_ACT_ITEM_REMOVE:
				$r = $this->RemoveItem();
				break;
			case REQ_ACT_APPLY_COUPON:
				$r = $this->ApplyCoupon();
				break;
			case REQ_ACT_PLACE_ORDER:
				$r = $this->PurchasePlaceOrder();
				break;
		}

		//dump($this->Basket);exit;
		return new JsonResponse($r);
	}
	private function CheckRequest($POST)
	{
		# set requested post in REQ variable for internal use in entire class
		$this->REQ = $POST;

		# check if request is not array or empty
		if(!is_array($this->REQ) || count($this->REQ) <= 0)
			return false;

		# check action in request. Because without action we cannot process request
		$this->REQ_ACTION = (isset($this->REQ[REQ_ACTION]) && $this->REQ[REQ_ACTION] != '')?$this->REQ[REQ_ACTION]:'';

		# if no  action found in request then we can not process so return
		if($this->REQ_ACTION == '')
			return false;

		# check if ref id is found in request. Ref id is a ID of any kind of  product
		if(isset($this->REQ[REQ_REF_ID]))
			$this->REQ_REF_ID = $this->REQ[REQ_REF_ID];

		# check if ref type is found in request. Ref type define product type. What kind of product it is
		if(isset($this->REQ[REQ_REF_TYPE]))
			$this->REQ_REF_TYPE = $this->REQ[REQ_REF_TYPE];

		# check if ref quantity is found in request. if not then set it to 1 as default
		$this->REQ_REF_QTY = 1;
		if(isset($this->REQ[REQ_REF_QTY]))
			$this->REQ_REF_QTY = $this->REQ[REQ_REF_QTY];

		if(isset($this->REQ[REQ_REF_COUPON_CODE]))
			$this->REQ_COUPON_CODE = $this->REQ[REQ_REF_COUPON_CODE];

		return true;
	}
	public function ManipulateShoppingCart()
	{
		# change current cart to shopping cart
		$this->setCurrentCart(CART_KEY_ONLINESHOPPING);

		# now get current cart to add new item in cart
		$cart = $this->getCurrentCart();

		if(isset($cart[CART_SHOPPING_ITEM]) && is_array($cart[CART_SHOPPING_ITEM]) && count($cart[CART_SHOPPING_ITEM]) > 0)
		{
			//dump($cart[CART_SHOPPING_ITEM]);die;
			$arritem = array();
			foreach($cart[CART_SHOPPING_ITEM] as $k => $item)
			{
				$items = $this->getReqItem($item['id'],$item['type'],$item['quantity']);
				if($items != false)
					$arritem[$k] =  $items[$k];
			}

			# add new item in old item list
			$cart[CART_SHOPPING_ITEM] = $arritem;

			# update cart as added new item in item list
			$this->updateCurrentCart($cart,true);

			# PurchaseCalculateTotal using API
			$this->PurchaseCalculateTotal();

			# as new item added in cart calculate required total
			$this->CalculateOrder();

			# manipulate payment detail
			$this->updatePaymentInfo();
		}
		else
		{
			# update cart as added new item in item list
			$this->SetBasketStructure(false);
		}

		# all done save cart
		$this->saveCart();

		return true;
	}
	private function AddItem()
	{
		$new_item_id =  $this->REQ_REF_TYPE.'_'.$this->REQ_REF_ID;
		# get item based of ref id and type
		$item = $this->getReqItem($this->REQ_REF_ID, $this->REQ_REF_TYPE, $this->REQ_REF_QTY);

		# now get current cart to add new item in cart
		$cart = $this->getCurrentCart();

		# add new item in old item list
		$cart[CART_SHOPPING_ITEM] = array_merge($cart[CART_SHOPPING_ITEM], $item);


		# update cart as added new item in item list
		$this->updateCurrentCart($cart,true);

		# as new item added in cart calculate required total
		$this->ManipulateShoppingCart();

		$msg_success = 'Votre video de '.$this->get_ie_rider_title($item[$new_item_id]).' avec '.$this->get_ie_horse_title($item[$new_item_id]).' a été ajouté à votre pannier.';
		$ti = $this->get_total_item_count();

		$return = array('success'=>$msg_success,'total_item'=>$ti);

		return $return;
	}
	private function ApplyCoupon()
	{
		#################################
		# test coupon code is
		#            ILOVEGRANDPRIX1
		#################################
		# now get current cart to add new item in cart
		$cart = $this->getCurrentCart();

		$cart[CART_SHOPPING_APPLIED_COUPON_INFO]['ref_coupon_code'] = $this->REQ_COUPON_CODE;

		# update cart as added new item in item list
		$this->updateCurrentCart($cart,true);

		# as new item added in cart calculate required total
		$this->ManipulateShoppingCart();

		if($this->REQ_COUPON_CODE != '')
			$msg_success = 'Le coupon a été appliqué.';
		else
			$msg_success = 'Le coupon a été supprimé.';

		$return = array('success'=>$msg_success);

		return $return;
	}
	private function RemoveItem()
	{
		# now get current cart to add new item in cart
		$cart = $this->getCurrentCart();

		$item_name='';
		$item_key = $this->REQ_REF_TYPE.'_'.$this->REQ_REF_ID;

		if(isset($cart[CART_SHOPPING_ITEM][$item_key]))
		{

			$item_name = $this->get_i_title($cart[CART_SHOPPING_ITEM][$item_key]);
			unset($cart[CART_SHOPPING_ITEM][$item_key]);

		}

		# update cart as removed new item from item list
		$this->updateCurrentCart($cart,true);

		# as new item added in cart calculate required total
		$this->ManipulateShoppingCart();

		$msg_success = $item_name.' removed from cart.';
		$ti = $this->get_total_item_count();

		$return = array('success'=>$msg_success,'total_item'=>$ti);

		return $return;
	}
	private function CalculateOrder()
	{
		$cart = $this->getCurrentCart();

		if(is_array($cart[CART_SHOPPING_ITEM]) && count($cart[CART_SHOPPING_ITEM]) > 0)
		{
			$discount_amount = 0;
			$sub_total_amount = 0;
			$total_amount = 0;
			$total_item_quantity = 0;

			foreach($cart[CART_SHOPPING_ITEM] as $k => $item)
			{
				$discount_amount    =   $discount_amount + $item['discount'];
				$sub_total_amount   =   $sub_total_amount + $item['subtotal_amount'];
				$total_amount       =   $total_amount + $item['total_amount'];
				$total_item_quantity=   $total_item_quantity + 1;
			}

			$cal =  array(
				'discount_amount'         =>  $discount_amount,
				'sub_total_amount'        =>  $sub_total_amount,
				'total_amount'            =>  $total_amount,
				'total_item_quantity'     =>  $total_item_quantity,
				'total_shipment_weight'   =>  0,
				'tax_amount'              =>  0,
				'shipping_amount'         =>  0,
			);

			$cart[CART_SHOPPING_GRAND_TOTAL] = array_merge($cart[CART_SHOPPING_GRAND_TOTAL],$cal);

			$this->updateCurrentCart($cart,true);
			return true;
		}
	}
	public function updatePaymentInfo()
	{
		$cart = $this->getCurrentCart();

		$pay=array();

		if(isset($this->REQ['useOnFileCard']))
		{
			$pay['useOnFileCard'] = true;
			$pay['creditCardNumber'] = '';
			$pay['creditCardMonth'] = '';
			$pay['creditCardYear'] = '';
			$pay['CVC'] = '';
			$pay['saveCreditCardOnFile'] = false;
			$pay['useNewCard'] = false;
		}
		elseif(isset($this->REQ['useNewCard']))
		{
			$pay['useNewCard'] = true;
			$pay['useOnFileCard'] = false;
			$pay['creditCardNumber'] = $this->REQ['number'];

			$exp = explode('/',$this->REQ['expiry']);
			$pay['creditCardMonth'] = trim($exp[0]);
			$pay['creditCardYear'] = trim($exp[1]);

			$pay['CVC'] = $this->REQ['cvc'];

			if(isset($this->REQ['saveCreditCardOnFile']))
				$pay['saveCreditCardOnFile'] = true;
			else
				$pay['saveCreditCardOnFile'] = false;

		}
		$cart[CART_ORDER_PAYMENT_GATEWAY_INFO] = $pay;

		$this->updateCurrentCart($cart,true);
		return true;
	}

	#######################################################################
	#######################################################################
	#######################################################################

	private function PurchaseCalculateTotal()
	{
		# get current user, whether it is logged or not because need to decide price based on that
		$user = $this->tokenStorage->getToken()->getUser();

		# If user is not logged in
		if($user == 'anon.')
		{
			return false;
		}
		# If user if logged in
		else
		{
			$profile_detail = $this->getUserProfile();
			$product_code = $profile_detail->getProfileProductCodeDownload();

			$cart = $this->getCurrentCart();

			# set Post Data
			$_post['UserId'] = $user->getID();
			$_post['CustomerNumber'] = $user->getCustomerNumber();
			$_post['Coupon'] = $this->get_applied_coupon_code();

			$_post['Items'] = array();
			foreach($cart[CART_SHOPPING_ITEM] as $k=>$v)
			{
				$_post['Items'][$k]['ProductCode'] = $product_code;
				$_post['Items'][$k]['VideoId'] = $v['id'];
			}

			//dump(json_encode($_post)); exit;
			$resp = $this->API->PurchaseCalculateTotal($_post);

			$cart[CART_SHOPPING_PURCHASECALCULATETOTAL] = (array) $resp;

			$this->updateCurrentCart($cart, true);

			return true;
		}
	}
	private function PurchasePlaceOrder()
	{
		# get current user, whether it is logged or not because need to decide price based on that
		$user = $this->tokenStorage->getToken()->getUser();

		# If user is not logged in
		if($user == 'anon.')
		{
			return false;
		}
		# If user if logged in
		else
		{
			# manipulate full cart before we place order
			$this->ManipulateShoppingCart();

			# now get full cart to place order using API
			$cart = $this->getCurrentCart();

			$profile_detail = $this->getUserProfile();
			$product_code = $profile_detail->getProfileProductCodeDownload();

			$cart = $this->getCurrentCart();

			# set Post Data
			$_post['UserId'] = $user->getID();
			$_post['CustomerNumber'] = $user->getCustomerNumber();
			$_post['Coupon'] = $this->get_applied_coupon_code();

			$_post['useOnFileCard']     =   $this->get_pay_useOnFileCard();
			$_post['creditCardNumber']  =   $this->get_pay_creditCardNumber();
			$_post['creditCardMonth']   =   $this->get_pay_creditCardMonth();
			$_post['creditCardYear']    =   $this->get_pay_creditCardYear();
			$_post['CVC']               =   $this->get_pay_CVC();
			$_post['saveCreditCardOnFile']  =   $this->get_pay_saveCreditCardOnFile();

			$_post['profileId']         =   $profile_detail->getId();

			$_post['Items'] = array();
			foreach($cart[CART_SHOPPING_ITEM] as $k=>$v)
			{
				$_post['Items'][$k]['ProductCode'] = $product_code;
				$_post['Items'][$k]['VideoId'] = $v['id'];
			}

			# api call to place order
			$resp = $this->API->PurchasePlaceOrder($_post);
			$response = (array) $resp;


			if(isset($response['ResultCode']) && $response['ResultCode'] == RES_STATUS_CODE_SUCCESS)
			{
				$cart[CART_SHOPPING_PLACEDORDER] = $response;

				$this->updateCurrentCart($cart, true);

				###############################################################################
				# as order is placed, we need to update in local database and make video entry as purchased
				###############################################################################

				# now get full cart again to process data
				$cart = $this->getCurrentCart();

				if(strpos($_SERVER['HTTP_HOST'], '.project:') != false)
				{
					$now = new DateTime();

					foreach($cart[CART_SHOPPING_ITEM] as $k => $v)
					{
						$video = $this->videoRepository->getVideo($v['id']);

						$videoPurchase = new VideoPurchase($user, $video);
						$videoPurchase->setPurchaseSeeDate(clone $now);
						$videoPurchase->setPricePayVideo($v['price']);
						$videoPurchase->setDownloadable(1);
						$videoPurchase->setPurchaseDownloadDate(clone $now);

						$this->entityManager->persist($videoPurchase);

						$this->entityManager->flush();
					}
				}

				$purchasevideoorder = new PurchaseVideoOrder();
				$purchasevideoorder->setUserId($user->getID());
				$purchasevideoorder->setTransactionId($this->get_transaction_id());
				$purchasevideoorder->setOrderData(serialize($cart));

				$this->entityManager->persist($purchasevideoorder);

				$this->entityManager->flush();

				# As order is placed and we have successfull response we need to clear cart to prevent same multiple order
				$this->clearCart(CART_KEY_ONLINESHOPPING);

				$this->SetBasketStructure();

				$msg_success = 'Order Successfully Placed. Transaction Number : '.$this->get_transaction_id();

				$return = array('success' => $msg_success, 'id' => $purchasevideoorder->getId());
			}
			else
			{
				$msg_error = $response['ReultMessage'];

				$return = array('error' => $msg_error);
			}

			return $return;
		}
	}

	#######################################################################
	#######################################################################
	#######################################################################

	private function populateCart()
	{
		$this->Basket = $this->session->get(CART_KEY_NAME);

		return true;
	}
	private function saveCart()
	{
		return $this->session->set(CART_KEY_NAME, $this->Basket);
	}
	private function clearCart($cart_id=false, $save=true)
	{
		if($cart_id == false)
			$this->Basket 	= '';
		else
			$this->Basket[CART_ITEM][$cart_id] = array();

		# Save cart info in database
		if($save === true)
			$this->saveCart();

		return true;
	}
	private function SetBasketStructure($force=false)
	{
		# Set initial search as RecentlyViewedListing
		if(!$this->Basket || $force == true)
		{
			# KEY : 1 - Shopping Cart
			$this->Basket[CART_ITEM][CART_KEY_ONLINESHOPPING] =
				array(  CART_SHOPPING_STEP          =>  1,
				        CART_SHOPPING_ITEM          =>  array(),
				        CART_SHOPPING_GRAND_TOTAL   =>
					        array(
						        'sub_total_amount'        =>  0,
						        'tax_amount'              =>  0,
						        'discount_amount'         =>  0,
						        'shipping_amount'         =>  0,
						        'total_amount'            =>  0,
						        'total_shipment_weight'   =>  0,
						        'total_item_quantity'     =>  0,
								),
				        CART_SHOPPING_APPLIED_COUPON_INFO   =>  array('ref_coupon_code' => ''),
				        CART_SHOPPING_PURCHASECALCULATETOTAL    =>  array(),
				        CART_SHOPPING_PLACEDORDER   =>  array(),
				        CART_ORDER_BILLING_INFO      =>  array(),
				        CART_ORDER_SHIPPING_INFO     =>  array(),
				        CART_ORDER_PAYMENT_GATEWAY_INFO =>  array(),
				);
		}
	}
	public function setCurrentCartToOnlineShopping()
	{
		$this->setCurrentCart(CART_KEY_ONLINESHOPPING);
		return true;
	}
	public function setCurrentCartToPrevOnlineShopping()
	{
		$this->setCurrentCart(CART_KEY_ONLINESHOPPING_PREV);
		return true;
	}
	private function setCurrentCart($cart_id)
	{
		if($cart_id != '')
		{
			$this->Basket[CART_CURCART]	= $cart_id;
			return true;
		}
		return false;
	}
	public function getCurrentCart()
	{
		if(isset($this->Basket[CART_ITEM][$this->Basket[CART_CURCART]]))
			return $this->Basket[CART_ITEM][$this->Basket[CART_CURCART]];

		return false;
	}
	private function getCartByCartId($cart_id)
	{
		if($cart_id !='' && isset($this->Basket[CART_ITEM][$cart_id]))
			return $this->Basket[CART_ITEM][$cart_id];

		return false;
	}
	public function updateCurrentCart($cart, $UpdateFullCart = false)
	{
		if($UpdateFullCart === true)
		{
			$this->Basket[CART_ITEM][$this->Basket[CART_CURCART]] = $cart;
		}
		elseif(is_array($cart))
		{
			foreach($cart as $key => $val)
				$this->Basket[CART_ITEM][$this->Basket[CART_CURCART]][$key] = $val;
		}

		return true;
	}

	#######################################################################
	#######################################################################
	#######################################################################

	public function is_cart_empty()
	{
		$cart = $this->getCurrentCart();
		if(isset($cart[CART_SHOPPING_ITEM]) && is_array($cart[CART_SHOPPING_ITEM]) && count($cart[CART_SHOPPING_ITEM]) > 0)
			return false;
		else
			return true;
	}
	public function get_total_item_count()
	{
		$cart = $this->getCurrentCart();
		return (isset($cart[CART_SHOPPING_GRAND_TOTAL]['total_item_quantity'])?$cart[CART_SHOPPING_GRAND_TOTAL]['total_item_quantity']:0);
	}
	public function get_applied_coupon_code()
	{
		$cart = $this->getCurrentCart();
		return (isset($cart[CART_SHOPPING_APPLIED_COUPON_INFO]['ref_coupon_code'])?$cart[CART_SHOPPING_APPLIED_COUPON_INFO]['ref_coupon_code']:false);
	}
	public function get_pay_useOnFileCard()
	{
		$cart = $this->getCurrentCart();
		return (isset($cart[CART_ORDER_PAYMENT_GATEWAY_INFO]['useOnFileCard'])?$cart[CART_ORDER_PAYMENT_GATEWAY_INFO]['useOnFileCard']:false);
	}
	public function get_pay_creditCardNumber()
	{
		$cart = $this->getCurrentCart();
		return (isset($cart[CART_ORDER_PAYMENT_GATEWAY_INFO]['creditCardNumber'])?$cart[CART_ORDER_PAYMENT_GATEWAY_INFO]['creditCardNumber']:false);
	}
	public function get_pay_creditCardMonth()
	{
		$cart = $this->getCurrentCart();
		return (isset($cart[CART_ORDER_PAYMENT_GATEWAY_INFO]['creditCardMonth'])?$cart[CART_ORDER_PAYMENT_GATEWAY_INFO]['creditCardMonth']:false);
	}
	public function get_pay_creditCardYear()
	{
		$cart = $this->getCurrentCart();
		return (isset($cart[CART_ORDER_PAYMENT_GATEWAY_INFO]['creditCardYear'])?$cart[CART_ORDER_PAYMENT_GATEWAY_INFO]['creditCardYear']:false);
	}
	public function get_pay_CVC()
	{
		$cart = $this->getCurrentCart();
		return (isset($cart[CART_ORDER_PAYMENT_GATEWAY_INFO]['CVC'])?$cart[CART_ORDER_PAYMENT_GATEWAY_INFO]['CVC']:false);
	}
	public function get_pay_saveCreditCardOnFile()
	{
		$cart = $this->getCurrentCart();
		return (isset($cart[CART_ORDER_PAYMENT_GATEWAY_INFO]['saveCreditCardOnFile'])?$cart[CART_ORDER_PAYMENT_GATEWAY_INFO]['saveCreditCardOnFile']:false);
	}
	public function get_pay_useNewCard()
	{
		$cart = $this->getCurrentCart();
		return (isset($cart[CART_ORDER_PAYMENT_GATEWAY_INFO]['useNewCard'])?$cart[CART_ORDER_PAYMENT_GATEWAY_INFO]['useNewCard']:false);
	}
	public function get_item()
	{
		$cart = $this->getCurrentCart();
		if(isset($cart[CART_SHOPPING_ITEM]) && is_array($cart[CART_SHOPPING_ITEM]) && count($cart[CART_SHOPPING_ITEM]) > 0)
			return $cart[CART_SHOPPING_ITEM];
		else
			return false;
	}
	public function get_total_ttc()
	{
		$cart = $this->getCurrentCart();
		return (isset($cart[CART_SHOPPING_PURCHASECALCULATETOTAL]['TotalTTC'])?$cart[CART_SHOPPING_PURCHASECALCULATETOTAL]['TotalTTC']:0);
	}
	public function get_transaction_id()
	{
		$cart = $this->getCurrentCart();
		return (isset($cart[CART_SHOPPING_PLACEDORDER]['TransactionId'])?$cart[CART_SHOPPING_PLACEDORDER]['TransactionId']:false);
	}
	public function get_i_title($i)
	{
		return (isset($i['title'])?$i['title']:false);
	}
	public function get_i_id($i)
	{
		return (isset($i['id'])?$i['id']:false);
	}
	public function get_i_type($i)
	{
		return (isset($i['type'])?$i['type']:false);
	}
	public function get_i_image($i)
	{
		return (isset($i['image'])?$i['image']:false);
	}
	public function get_ie_event_id($i)
	{
		return (isset($i['etc']['event']['id'])?$i['etc']['event']['id']:false);
	}
	public function get_ie_event_title($i)
	{
		return (isset($i['etc']['event']['title'])?$i['etc']['event']['title']:false);
	}
	public function get_ie_round_id($i)
	{
		return (isset($i['etc']['round']['id'])?$i['etc']['round']['id']:false);
	}
	public function get_ie_round_title($i)
	{
		return (isset($i['etc']['round']['title'])?$i['etc']['round']['title']:false);
	}
	public function get_ie_rider_id($i)
	{
		return (isset($i['etc']['rider']['id'])?$i['etc']['rider']['id']:false);
	}
	public function get_ie_rider_title($i)
	{
		return (isset($i['etc']['rider']['title'])?$i['etc']['rider']['title']:false);
	}
	public function get_ie_horse_id($i)
	{
		return (isset($i['etc']['horse']['id'])?$i['etc']['horse']['id']:false);
	}
	public function get_ie_horse_title($i)
	{
		return (isset($i['etc']['horse']['title'])?$i['etc']['horse']['title']:false);
	}
}