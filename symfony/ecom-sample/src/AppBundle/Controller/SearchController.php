<?php
/**
 * File header placeholder
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
use AppBundle\Entity\Horse;
use AppBundle\Entity\Rider;
use AppBundle\Entity\Round;
use AppBundle\Entity\Video;
use AppBundle\Entity\AdditionalStreaming;
use AppBundle\Search;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class SearchController
 */
class SearchController extends Controller
{


	/**
     * Main action
     *
     * @Route("/search", name="search")
     */
    public function mainAction(Request $request)
    {
    	return $this->render(':search:main.html.twig', [
            'search' => Search::create($request),
            'page' => 'search'
        ]);
    }

    /**
     * Search beehive
     *
     * @Route(
     *      "/beehive/search",
     *      name = "beehive_search"
     * )
     */
    public function beehiveView(Request $request)
    {

        $query = $request->query;
        $search = Search::create($request);

        // buscamos los videos de mis caballos
        $idsMyHorsesVideos = $this
            ->get('domain.myrides_manager')
            ->getUserHorsesVideosId($this->getUser());

        $videos = $this
            ->get('repository.video')
            ->search(
                $search,
                $query->get('limit'),
                $query->get('offset'),
                false,
                $idsMyHorsesVideos
            );


        $totalVideos = $this
            ->get('repository.video')
            ->search(
                $search,
                $query->get('limit'),
                $query->get('offset'),
                true,
                $idsMyHorsesVideos
            );

        //echo $query->get('offset') . ' + ' . $query->get('limit') . ' < ' . $totalVideos;

        $title = trim('' .
            ($search->getRider() ? $search->getRider().' ' : '') .
            ($search->getHorse() ? '+ '.$search->getHorse().' ' : '') .
            ($search->getEvent() ? '+ '.$search->getEvent().' ' : ''), '/ ');
        $title = empty($title) ? 'Resultats de votre recherche' : $title;

        return $this
            ->get('domain.video_beehive')
            ->createBeehiveResponse(
                $request,
                $videos, // Videos
                'video', // Video url
                [], // Video url params
                $totalVideos, // Total videos
                $title, // Title of the beehive
                'beehive_search', // Next page url
                $search->all(), // Next page url params
                'search'  // Icon
            );
    }

    /**
     * Search api . buscador barra header
     *
     * @Route("/api/search-old", name="api_search_old")
     */
    public function apiActionOld(Request $request)
    {
        $search = Search::create($request);
        $videos = $this
            ->get('repository.video')
            ->search($search, 8, 0);

        //print_r($videos); die;

        $stack = [];

        /**
         * @var Video[] $videos
         */
        foreach ($videos as $video) {
            /**
             * Rider found
             */
            $rider = $video->getRider();
            $riderName = strtolower($rider->getName());
            if (
                !isset($stack['rider_' . $rider->getId()]) &&
                (
                    (
                        !empty($search->getQuery()) &&
                        strpos($riderName, $search->getQuery()) !== false
                    ) ||
                    (
                        !empty($search->getRider()) &&
                        strpos($riderName, $search->getRider()) !== false
                    )
                )
            ) {
                $stack['rider_' . $rider->getId()] = [
                    'id' => $rider->getId(),
                    'value' => $rider->getName(),
                    'type' => 'rider',
                ];
            }

            /**
             * Horse found
             */
            $horse = $video->getHorse();
            $horseName = strtolower($horse->getName());
            if (
                !isset($stack['horse_' . $horse->getId()]) &&
                (
                    (
                        !empty($search->getQuery()) &&
                        strpos($horseName, $search->getQuery()) !== false
                    ) ||
                    (
                        !empty($search->getHorse()) &&
                        strpos($horseName, $search->getHorse()) !== false
                    )
                )
            ) {
                $stack['horse_' . $horse->getId()] = [
                    'id' => $horse->getId(),
                    'value' => $horse->getName(),
                    'type' => 'horse',
                ];
            }

            /**
             * Event found
             */
            $event = $video->getEvent();
            $eventName = strtolower($event->getTitle());
            if ($video->getRound() instanceof Round) {
                $eventName .= ' ' . strtolower($video->getRound()->getTitle());
            }

            if (
                !isset($stack['event_' . $event->getId()]) &&
                (
                    (
                        !empty($search->getQuery()) &&
                        strpos($eventName, $search->getQuery()) !== false
                    ) ||
                    (
                        !empty($search->getEvent()) &&
                        strpos($eventName, $search->getEvent()) !== false
                    )
                )
            ) {
                $stack['event_' . $event->getId()] = [
                    'id' => $event->getId(),
                    'value' => $event->getTitle(),
                    'type' => 'event',
                ];
            }

            if (count($stack) >= 8) {
                break;
            }
        }

        return new JsonResponse([
            'total' => count($stack),
            'results' => array_values($stack),
        ]);
    }

    /**
     * Search api . buscador barra header
     *
     * @Route("/api/search", name="api_search")
     */
    public function apiAction(Request $request)
    {
        $stack = $riders = $horses = $events = [];

        $query = $request->query->get('query');

        // Riders
        $items = $this
            ->get('repository.rider')
            ->findByName($query, 10);

        foreach( $items as $rider ) {
            /**
             * @var Rider $rider
             */
            $stack['rider_' . $rider->getId()] = [
                'id' => $rider->getId(),
                'value' => $rider->getName(),
                'type' => 'rider',
            ];
        }

        // Events
        $items = $this
            ->get('repository.event')
            ->findByTitle($query, 10);

        foreach( $items as $event ) {
            /**
             * @var Event $event
             */
            $stack['event_' . $event->getId()] = [
                'id' => $event->getId(),
                'value' => $event->getTitle(),
                'type' => 'event',
            ];
        }

        // Horses
        $items = $this
            ->get('repository.horse')
            ->findByName($query, 10);

        foreach( $items as $horse ) {
            /**
             * @var Horse $horse
             */
            $stack['horse_' . $horse->getId()] = [
                'id' => $horse->getId(),
                'value' => $horse->getName(),
                'type' => 'horse',
            ];
        }

        // only 15 firsts elements
        $stack = array_chunk($stack, 10, true)[0];

        return new JsonResponse([
            'total' => count($stack),
            'results' => array_values($stack),
        ]);
    }

    /**
     * Specific Search api - barra negra buscadores
     *
     * @Route("/api/search/{type}", name="api_search_specific")
     */
    public function apiSpcificAction(
        Request $request,
        string $type
    )
    {
        $stack = [];
        $query = $request->query->get('query');

        if ($type == 'rider') {

            $stack = array_map(function(Rider $rider) {
                return $rider->getName();
            }, $this
                ->get('repository.rider')
                ->findByName($query, 10)
            );

        } elseif ($type == 'horse') {

            $stack = array_map(function(Horse $horse) {
                return $horse->getName();
            }, $this
                ->get('repository.horse')
                ->findByName($query, 10)
            );

        } elseif ($type == 'event') {

            $stack = array_map(function(Event $event) {
                return $event->getTitle();
            }, $this
                ->get('repository.event')
                ->findByTitle($query, 10)
            );

        }

        return new JsonResponse([
            'total' => count($stack),
            'results' => array_values($stack),
        ]);
    }
	/**
	 * Horse Search action
	 *
	 * @Route(
	 *     "/cheval/{horse_id}/{horse_name}/{rider}/{rider_id}/{rider_name}",
	 *     name="search_cheval",
	 *     defaults = {
	 *          "horse_name": null,
	 *          "rider":null,
	 *          "rider_id": null,
	 *          "rider_name": null
	 *
	 *      }
	 *     )
	 */
	public function SearchChevalAction(Request $request, int $horse_id, ?string $horse_name, ?int $rider_id, ?string $rider_name)
	{

		$query = $request->query;
		$horse_detail = $this->getDoctrine()
		                    ->getRepository('AppBundle:Horse')
		                    ->find($horse_id);


		if($horse_detail->getBirthDate() != NULL)
		{
			$to   = new \DateTime('today');
			$age =  $horse_detail->getBirthDate()->diff($to)->y;
		}
		else
		{
			$age = 0;
		}


		if($rider_id != '')
		{
			$riderid = [$rider_id];
			$and = true;
		}
		else{

			$riderid = [];
			$and = false;
		}



		$notid = $query->get('notid');
		if( $notid == '' )  $notid = 0;

		$riders = $this
			->get('repository.video')
			-> getRiderByHorse(
				[$horse_id]
			);

		$videos = $this
			->get('repository.video')
			-> getVideosByHorseAndOrRider(
				[$horse_id],
				$riderid,
				20,
				0,
				false,
				$and,
				$notid,
				''
			);

		$totalVideos = $this
			->get('repository.video')
			-> getVideosByHorseAndOrRider(
				[$horse_id],
				$riderid,
				null,
				0,
				true,
				$and,
				$notid,
				''
			);

		return $this->render(':cheval:main.html.twig', [
			'id'    => $horse_id,
			'rider_id'=>$rider_id,
			'title' => $horse_detail->getName(),
			'page' => 'search',
            'horse_detail'=>$horse_detail,
		    'total'=>$totalVideos,
		    'riders'=>$riders,
		    'age'=>$age,
		    'videos'=>$videos,
			'video_json'=>json_encode($videos),
		]);


	}
	/**
	 * Rider Search action
	 *
	 * @Route("/cavalier/{rider_id}/{rider_name}/{horse}/{horse_id}/{horse_name}", name="search_cavalier",
	 *      defaults = {
	 *          "rider_name": null,
	 *          "horse":null,
	 *          "horse_id": null,
	 *          "horse_name": null
	 *
	 *      })
	 */
	public function SearchRiderAction(request $request, int $rider_id, string $rider_name,?string $horse, ?int $horse_id, ?string $horse_name )
	{
		$query = $request->query;
		$rider_detail = $this->getDoctrine()
		                     ->getRepository('AppBundle:Rider')
		                     ->find($rider_id);

		if($rider_detail->getBirthday() != NULL)
		{
			$to   = new \DateTime('today');
			$age =  $rider_detail->getBirthday()->diff($to)->y;
		}
		else
		{
			$age = 0;
		}
		$notid = $query->get('notid');
		if( $notid == '' )  $notid = 0;
		$horses = $this
			->get('repository.video')
			->getNamesHorsesByRider(
				[$rider_id]
			);

		if($horse_id != '')
		{
			$horseid = [$horse_id];
			$and = true;
		}
		else{

			$horseid = [];
			$and = false;
		}

		$videos = $this
			->get('repository.video')
			-> getVideosByHorseAndOrRider(
				$horseid,
				[$rider_id],
				20,
				0,
				false,
				$and,
				$notid,
				''
			);

		$totalVideos = $this
			->get('repository.video')
			-> getVideosByHorseAndOrRider(
				$horseid,
				[$rider_id],
				null,
				0,
				true,
				$and,
				$notid,
				''
			);


		return $this->render(':cavalier:main.html.twig', [
			'id'    => $rider_id,
			'horse_id'=>$horse_id,
			'title' => $rider_detail->getName(),
			'page' => 'search',
			'rider_detail'=>$rider_detail,
			'total'=>$totalVideos,
			'horses'=>$horses,
			'age'=>$age,
			'videos'=>$videos,
			//'video_json'=>json_encode($videos),
		]);

	}
	/**
	 * Rider Search action
	 *
	 * @Route("/concours/{concours_id}/{concours_name}", name="search_concours")
	 */
	public function SearchConcoursAction(
		request $request,
		int $concours_id,
		string $concours_name
	)
	{
		$date = array();
		$query = $request->query;
		$event_detail = $this->getDoctrine()
		                     ->getRepository('AppBundle:Event')
		                     ->find($concours_id);
		//echo"<pre>";print_r(count($event_detail['title']));die;
        /*$rounds = $this
			->get('repository.video')
			->getNamesRoundByEvent(
				[$event_detail->getTitle()]
            );*/

		$mainStreamings = $this
			->get('repository.additional_streaming')
			->getEventAdditonalStreamings($event_detail);

		$rounds = $this
			->get('repository.video')
			->getAllRoundByEvent(
				[$event_detail->getTitle()],
                20,
                0,
                false
            );
        $arrround = array();
    //echo"<pre>";print_r($rounds);die;
		foreach($rounds as $round)
		{
			 $date[] = $round['date']->format('Y-m-d H:i:s');
             $arrround[$round['round_id']] = $round;
             $arrround[$round['round_id']]['total_videos'] = $this
    			->get('repository.video')
    			->getVideosByRound(
    				$round['round_id'],
    				null,
    				0,
    				true
    			);
            /*$arrround[$round['id']]['videos'] = $this
    			->get('repository.video')
    			->getVideosByRound(
    				$round['id'],
    				1,
    				0,
    				false
    			);*/

        }
        $round_date = array_unique($date);

		/*$videos = $this
			->get('repository.video')
			->getVideosByEvent(
				$event_detail,
				5,
				0,
				false
			);*/

		$totalVideos = $this
			->get('repository.video')
			->getVideosByEvent(
				$event_detail,
				null,
				0,
				true
			);

         $totalrounds = $this
			->get('repository.video')
			->getAllRoundByEvent(
				[$event_detail->getTitle()],
                null,
                0,
                true
            );
        return $this->render(':concours:main.html.twig', [
			'total' =>count($event_detail),
			'mainStreamings'=>$mainStreamings,
			'title' => $event_detail->getTitle(),
			'page' => 'search',
			'event_detail'=>$event_detail,
            'event_id'=>$concours_id,
		    'rounds'=>$arrround,
		    'dates'=>$round_date,
            'totalrounds'=>$totalrounds,
            'total_video'=>$totalVideos
		]);


	}
	/**
	 * Rider Search action
	 *
	 * @Route("/round/{round_id}/{round_name}", name="search_round")
	 */
	public function SearchRoundAction(
		request $request,
		int $round_id,
		string $round_name
	)
	{
		$query = $request->query;
		$round_detail = $this->getDoctrine()
		                     ->getRepository('AppBundle:Round')
		                     ->find($round_id);

		$videos = $this
			->get('repository.video')
			->getVideosByRound(
				$round_id,
				20,
				0,
				false
			);

		$totalVideos = $this
			->get('repository.video')
			->getVideosByRound(
				$round_id,
				null,
				0,
				true
			);

        //echo"<pre>";print_r($videos);die;
		/*$v=array();
		foreach($videos as $k=> $obj)
			$v[$k] =  (array) $obj;

		dump($videos); exit;
		if(is_array($videos))
		{
			echo "array";
			dump($videos);
		}

		if(is_object($videos))
		{
			echo "object";
		}
		exit;*/
		//dump($round_detail->getEvent()->getCity());die;
		return $this->render(':round:main.html.twig', [
			'total' =>$totalVideos,
			'title' => $round_detail->getTitle(),
			'page' => 'search',
			'round_detail'=>$round_detail,
			'videos'=>$videos,
			'serialize_video' => serialize($videos),
			'round_id'=>$round_id,
		    'event'=>$round_detail->getEvent(),
		]);
	}
}
