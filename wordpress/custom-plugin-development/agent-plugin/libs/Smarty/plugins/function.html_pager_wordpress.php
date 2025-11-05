<?php

function smarty_function_html_pager_wordpress($params, &$smarty){
	extract($params);

	$path_parts = explode('?', $_SERVER['REQUEST_URI']);
	$qArr = explode('&', $path_parts[1]);
	$qString = '?';
	
	//$path_parts = pathinfo($_SERVER['SCRIPT_FILENAME']);
	//$base_url = $path_parts['basename'] . '?' . substr($_SERVER['QUERY_STRING'], 0, strpos($_SERVER['QUERY_STRING'],'&start')===false?strlen($_SERVER['QUERY_STRING']):strpos($_SERVER['QUERY_STRING'],'&start'));
	//$total_pages = ceil($num_items/$per_page);

	// Added
	$curPage = $_GET['cpage'] ? $_GET['cpage'] : ($_POST['cpage'] ? $_POST['cpage'] : 1);
	
	foreach($qArr as $qStr) {
		$arr = explode('=', $qStr);		
		if($arr[0] != 'cpage' && $qStr != '')
			$qString .= $qStr. '&';		
	}
			
	$base_url = $path_parts[0]. $qString;
	
	if (!(strpos($base_url,'?')))
		$base_url .= '?';
	
	$total_pages = ceil($num_items/$per_page);

	$on_page = floor($start_item / $per_page) + 1;
	
	$page_string = '';
	if ( $total_pages > 10 )
	{
		$init_page_max = ( $total_pages > 3 ) ? 3 : $total_pages;
		for($i = 1; $i < $init_page_max + 1; $i++)
		{
			$page_string .= ( $i == $on_page ) ? '<a class="page-numbers active" href="JavaScript: void(0);">' . $i . '</a>' : '<a class="page-numbers" href="' . $base_url. 'cpage='. ($i) . '" data-page="'.$i.'">' . $i . '</a>';
//			if ( $i <  $init_page_max )
//				$page_string .= ' ';
		}

		if ( $on_page > 1  && $on_page < $total_pages )
		{
			$page_string .= ( $on_page > 5 ) ? '<a class="page-numbers"> ... </a>' : '';
			$init_page_min = ( $on_page > 4 ) ? $on_page : 5;
			$init_page_max = ( $on_page < $total_pages - 4 ) ? $on_page : $total_pages - 4;

			for($i = $init_page_min - 1; $i < $init_page_max + 2; $i++)
			{
				$page_string .= ($i == $on_page) ? '<a class="page-numbers active" href="JavaScript: void(0);">' . $i . '</a>' : '<a class="page-numbers" href="' . $base_url. 'cpage='. ($i) . '" data-page="'.$i.'">' . $i . '</a>';
//				if ( $i <  $init_page_max + 1 )
//					$page_string .= ' ';
			}
			$page_string .= ( $on_page < $total_pages - 4 ) ? '<a class="page-numbers"> ... </a>' : '';
		}
		else
			$page_string .= '<a class="page-numbers"> ... </a>';

		for($i = $total_pages; $i < $total_pages + 1; $i++)
		{
			$page_string .= ( $i == $on_page ) ? '<a class="page-numbers active" href="JavaScript: void(0);">' . $i . '</a>'  : '<a class="page-numbers" href="' . $base_url. 'cpage='. ($i) . '" data-page="'.$i.'">' . $i . '</a>';
//			if( $i <  $total_pages )
//				$page_string .= ' ';
		}
	}
	else
	{
		for($i = 1; $i < $total_pages + 1; $i++)
		{
			$page_string .= ( $i == $on_page ) ? '<a class="page-numbers active" href="JavaScript: void(0);">' . $i . '</a>' : '<a class="page-numbers" href="' . $base_url. 'cpage='. ($i) . '" data-page="'.$i.'">' . $i . '</a>';
//			if ( $i <  $total_pages )
//					$page_string .= ' ';
		}
	}
	
    
    if ( $add_prevnext_text )
	{
		if ( $on_page > 1 )
		{
			$page_string = '<a class="prev-page" href="' . $base_url. 'cpage='.($on_page - 1).'" data-page="'.($on_page - 1).'"><i class="fa fa-angle-left"></i></a>'
						. $page_string;
		}
		else
			$page_string = '<a class="prev-page" href="JavaScript: void(0);"><i class="fa fa-angle-left"></i></a>'. $page_string;

		if ( $on_page < $total_pages )
		{
			$page_string .= '<a class="last-page" href="' . $base_url. 'cpage='.($on_page + 1).'" data-page="'.($on_page + 1).'"><i class="fa fa-angle-right"></i></a>';
		}
		else
			$page_string .= '<a class="last-page" href="JavaScript: void(0);"><i class="fa fa-angle-right"></i></a>';
	}
   
	
	echo $page_string;
}

?>