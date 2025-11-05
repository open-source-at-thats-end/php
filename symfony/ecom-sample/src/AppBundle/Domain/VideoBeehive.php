<?php
/**
 * File header placeholder
 */

namespace AppBundle\Domain;
use AppBundle\Entity\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig_Environment;
use Doctrine\ORM\EntityRepository;

/**
 * Class VideoBeehive
 */
class VideoBeehive
{
    /**
     * @var Twig_Environment
     *
     * Twig
     */
    private $twig;

    /**
     * @var UrlGeneratorInterface
     *
     * Url generator
     */
    public $urlGenerator;

	/**
	 * @var EntityRepository
	 *
	 * Repository
	 */
	private $profileRepository;

    /**
     * VideoBeehive constructor.
     *
     * @param Twig_Environment  $twig
     * @param UrlGeneratorInterface $urlGenerator
     */

    public function __construct(
        Twig_Environment  $twig,
        UrlGeneratorInterface $urlGenerator,
        EntityRepository $profileRepository
    )
    {
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
	    $this->profileRepository = $profileRepository;
    }

    /**
     * Create a response
     */
    public function createBeehiveResponse(
        Request $request,
        ?array $videos,
        string $videoUrl,
        array $videoUrlParams,
        ?int $totalVideos,
        string $title,
        string $nextUrl,
        array $nextUrlParams,
        string $icon = '',
        bool $border = false
    )
    {
        $query = $request->query;

        $limit = $query->get('limit');
        $offset = $query->get('offset');
        $notid = (int)$query->get('notid');
        if( $notid > 0 ) {
            $offset += 1;
        }

        $nextUrlParams = array_merge(
            $nextUrlParams,
            [
                'limit' => $limit,
                'offset' => $limit + $offset,
                'frame' => false
            ]
        );

        $nextUrl = ($offset + count($videos) < $totalVideos)
            ? $this
                ->urlGenerator
                ->generate(
                    $nextUrl,
                    $nextUrlParams
                )
            : null;

	    $profile_detail = $this
		    ->profileRepository
		    ->find(1);

	    $download_price = $profile_detail->getParcourHDDownload();
	    //$download_price = '';
        $response = new Response($this
            ->twig
            ->render(':video:beehive_framed.html.twig', [
                'videos' => $videos,
                'video_url' => $videoUrl,
                'video_url_params' => [],
                'frame' => $query->get('frame'),
                'next_page_url' => $nextUrl,
                'limit' => $limit,
                'offset' => $offset,
                'total' => $totalVideos,
                'title' => $title,
                'icon' => $icon,
                'border' => $border,
                'download_price'=>$download_price
            ])
        );

        $response->headers->set('next', $nextUrl);

        return $response;
    }
	public function createResponse( Request $request,
	                                array $videos,
	                                string $videoUrl,
	                                array $videoUrlParams,
	                                int $totalVideos,
	                                string $title,
	                                string $nextUrl,
	                                array $nextUrlParams,
	                                string $icon = '',
	                                bool $border = false,
	                                string $file,
									Request $masterRequest=null
)
	{
		$query = $request->query;
		$limit = $query->get('limit');
		$offset = $query->get('offset');

		$notid = (int)$query->get('notid');
		if( $notid > 0 ) {
			$offset += 1;
		}

		$nextUrlParams = array_merge(
			$nextUrlParams,
			[
				'limit' => $limit,
				'offset' => $limit + $offset,
				'frame' => false
			]
		);

		$nextUrl = ($offset + count($videos) < $totalVideos)
			? $this

				->urlGenerator
				->generate(
					$nextUrl,
					$nextUrlParams
				)
			: null;

		if($file=='cheval')
		{
			$file = ':cheval:beehive_framed.html.twig';
		}
		elseif($file=='cavalier'){
			$file = ':cavalier:beehive_framed.html.twig';
		}
		elseif($file=='concours'){
			$file = ':concours:beehive_framed.html.twig';
		}
		elseif($file=='round'){
			$file = ':round:beehive_framed.html.twig';
		}
        elseif($file=='Eventround'){
			$file = ':concours:round-listing.html.twig';
		}
		elseif($file=='past_events'){
			$file = ':event:past_events.html.twig';
		}

		$profile_detail = $this
			->profileRepository
			->find(1);

		$download_price = $profile_detail->getParcourHDDownload();

		$response = new Response($this
			                         ->twig
			                         ->render($file, [
				                         'videos' => $videos,
				                         'video_json'=>json_encode($videos),
				                         'video_url' => $videoUrl,
				                         'video_url_params' => [],
				                         'frame' => $query->get('frame'),
				                         'next_page_url' => $nextUrl,
				                         'limit' => $limit,
				                         'offset' => $offset,
				                         'total' => $totalVideos,
				                         'title' => $title,
				                         'icon' => $icon,
				                         'border' => $border,
			                             'masterRequest'=>$masterRequest,
			                             'download_price'=>$download_price
			                         ])
		);

		$response->headers->set('next', $nextUrl);

		return $response;
	}
    public function createRoundResponse( Request $request,
	                                array $rounds,
	                                string $roundUrl,
	                                array $roundsParams,
	                                int $totalrounds,
	                                string $title,
	                                string $nextUrl,
	                                array $nextUrlParams,
	                                string $icon = '',
	                                bool $border = false,
                                     string $file,
                                     Event $events
)
	{
	   	$query = $request->query;
        $limit = $query->get('limit');
		$offset = $query->get('offset');


		$notid = (int)$query->get('notid');
		if( $notid > 0 ) {
			$offset += 1;
		}

		$nextUrlParams = array_merge(
			$nextUrlParams,
			[
				'limit' => $limit,
				'offset' => $limit + $offset,
				'frame' => false
			]
		);

		$nextUrl = ($offset + count($rounds) < $totalrounds)
			? $this

				->urlGenerator
				->generate(
					$nextUrl,
					$nextUrlParams
				)
			: null;

	//echo $nextUrl;die;
        if($file=='Eventround'){
			$file = ':concours:round-listing.html.twig';
		}

		$profile_detail = $this
			->profileRepository
			->find(1);
		//echo "<pre>";print_r($profile_detail);die;

		$download_price = $profile_detail->getParcourHDDownload();

		//$download_price = '';

		$response = new Response($this
			                         ->twig
			                         ->render($file, [
				                         'rounds' => $rounds,
				                         'video_json'=>json_encode($rounds),
				                         'video_url' => $roundUrl,
				                         'video_url_params' => [],
				                         'frame' => $query->get('frame'),
				                         'next_page_url' => $nextUrl,
				                         'limit' => $limit,
				                         'offset' => $offset,
				                         'total' => $totalrounds,
				                         'title' => $title,
				                         'icon' => $icon,
				                         'border' => $border,
				                         'event'=>$events,
			                             'download_price'=>$download_price
			                         ])
		);

		$response->headers->set('next', $nextUrl);

		return $response;
	}

}