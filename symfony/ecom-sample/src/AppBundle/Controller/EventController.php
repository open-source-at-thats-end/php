<?php
/*
* This file is part of the GrandPrixTV project
*
 * For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
use AppBundle\Entity\Streaming;
use Mmoreram\ControllerExtraBundle\Annotation\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Intl\Intl;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Search;
use AppBundle\Entity\Country;
use AppBundle\Entity\ViewCountries;
use AppBundle\Entity\ViewCities;

/**
 * Class EventController.
 */
class EventController extends Controller
{

	/**
	 * All actu.
	 *
	 * @Route(
	 *      "event/{id}",
	 *      name = "event",
	 *      defaults = {
	 *          "id" = null
	 *      }
	 * )
	 */
	public function mainAction(?int $id)
	{
		$video = $publi = null;
		$events = $this
			->get('repository.event')
			->getPastAndCurrent();
		//dump($events);die;
		return $this->render(':event:event.html.twig', [
			'page' => 'event',
		    'events'=>$events
		]);
		//die;
	}
	/**
	 * Events block.
	 *
	 * @Route("/carousel/events", name="carousel_events")
	 */
	public function blockAction(
		Request $request
	)
	{

        $events = $this
			->get('repository.event')
			->getCurrentAndFutureEvent();

		/*$past_events = $this
			->get('repository.event')
			->find('1111');*/
        //dump($events);die;
		$border = (bool)$request->query->get('border');

		return $this->render('::event/carousel.html.twig', [
			'events' => $events,
			'border' => $border,
            //'past_events'=>$past_events,
		]);
	}
	/**
	 * Events listing.
	 *
	 * @Route("/events", name="list_events")
	 */
	public function EventAction(
		Request $request
	)
	{
		$countries = $this->getDoctrine()
		                  ->getRepository('AppBundle:ViewCountries')
		                  ->findBy(array(), array('name' => 'ASC'));

		$events = $this
			->get('repository.event')
			->getAllEventsData();

		$border = (bool)$request->query->get('border');
		//dump($events);die;
		return $this->render('::event/event_listing.html.twig', [
			'events' => $events,
		    //'latest_event'=>$latest_event,
		    'countries'=>$countries
		]);
	}
	/**
	 *
	 * @Route(
	 *      "/beehive/events/past",
	 *      name = "beehive_past_events",
	 *
	 * )
	 */
	public function BeehivePastEventsAction(Request $request)
	{
		$query = $request->query;

		$past_events = $this
			->get('repository.event')
			->getPastEvents(
				$query->get('limit'),
				$query->get('offset'),
				false
			);

		$total_past_events = $this
			->get('repository.event')
			->getPastEvents(
				null,
				0,
				true
			);
		$icon = $query->get('icon');
		if( $icon == '' )  $icon = 'rider';

		$border = (bool)$query->get('border');

		return $this
			->get('domain.video_beehive')
			->createResponse(
				$request,
				$past_events,
				"event", // Video url
				[], // Video url params
				$total_past_events,
				'',
				'beehive_past_events',
				[],
				$icon,
				$border,
				'past_events'
			);
	}
	/**
	 *
	 * @Route(
	 *      "/city",
	 *      name = "city_list_from_country",
	 *
	 * )
	 */

	public  function cityAction()
	{
		//dump($_GET['countryid']);die;
		$cities = $this->getDoctrine()
		                  ->getRepository('AppBundle:ViewCities')
		                  ->findBy(
							array('country'=> $_GET['countryid']),
							array('name' => 'ASC')
		                  );
		                  //->findBy(array('country'=>$_GET['countryid'],'name'=>'ASC'));
		$responseArray = array();
		foreach($cities as $city){
			$responseArray[] = array(
				"id" => $city->getId(),
				"name" => $city->getName()
			);
		}
		return new JsonResponse($responseArray);
	}
	/**
	 * Events search.
	 *
	 * @Route("/events/search", name="event_search")
	 */
	public  function EventSerachAction(Request $request)
	{
		
		$countries = $this->getDoctrine()
		                  ->getRepository('AppBundle:ViewCountries')
		                  ->findBy(array(), array('name' => 'ASC'));

		return $this->render(':event-search:main.html.twig', [
			'event_search' => Search::create($request),
			'page' => 'search',
			'countries'=> $countries
		]);
	}
	/**
	 * Event Search beehive
	 *
	 * @Route(
	 *      "/beehive/event/search",
	 *      name = "beehive_event_search"
	 * )
	 */
	public function beehiveView(Request $request)
	{
		$query = $request->query;
		$search = Search::create($request);

		$events = $this
			->get('repository.event')
			->search(
				$search,
				$query->get('limit'),
				$query->get('offset'),
				false
			);

		$totalEvents = $this
			->get('repository.event')
			->search(
				$search,
				null,
				0,
				true
			);
		//dump($totalEvents);die;
		//echo $query->get('offset') . ' + ' . $query->get('limit') . ' < ' . $totalVideos;
		$title = '';
		if($search->country != '')
		{
			$arrcountry = $this->getDoctrine()
			               ->getRepository('AppBundle:Country')
			               ->find($search->country);

			$title .= trim('' .
			              '+ '.$arrcountry->getName(), '/ ');
		}
		if($search->city != '')
		{
			$arrcity = $this->getDoctrine()
			                   ->getRepository('AppBundle:City')
			                   ->find($search->city);

			$title .= trim('' .
			               '+ '.$arrcity->getName(), '/ ');
		}
		$title .= trim('' .
		               ($search->getEvent() ? '+ '.$search->getEvent().' ' : ''), '/ ');
		$title = empty($title) ? 'Resultats de votre recherche' : $title;

		return $this
			->get('domain.video_beehive')
			->createResponse(
				$request,
				$events, // Videos
				'video', // Video url
				[], // Video url params
				$totalEvents, // Total videos
				$title, // Title of the beehive
				'beehive_event_search', // Next page url
				$search->all(), // Next page url params
				'search',
				false,// Icon
				'past_events'
			);
	}

}
?>