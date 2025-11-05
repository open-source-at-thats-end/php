<?php

function smarty_function_html_pager_responsive1($params, &$smarty){
	extract($params);

	$path_parts = explode("?", $_SERVER['REQUEST_URI']);
	$qArr = explode("&", $path_parts[1]);
	$qString = '?';

	//$path_parts = pathinfo($_SERVER['SCRIPT_FILENAME']);
	//$base_url = $path_parts["basename"] . "?" . substr($_SERVER['QUERY_STRING'], 0, strpos($_SERVER['QUERY_STRING'],"&start")===false?strlen($_SERVER['QUERY_STRING']):strpos($_SERVER['QUERY_STRING'],"&start"));
	//$total_pages = ceil($num_items/$per_page);

	// Added
	$curPage = $_GET['page'] ? $_GET['page'] : ($_POST['page'] ? $_POST['page'] : '0');

	foreach($qArr as $qStr) {
		$arr = explode("=", $qStr);
		if($arr[0] != "page" && $qStr != "")
			$qString .= $qStr. "&";
	}

	$base_url = $path_parts[0]. $qString;

	if (!(strpos($base_url,"?")))
		$base_url .= '?';

	$total_pages = ceil($num_items/$per_page);

	$on_page = floor($start_item / $per_page) + 1;

	$page_string = '';
	if ( $total_pages > 10 )
	{
		if($on_page > 3)
            $init_page_max = ( $total_pages > 1 ) ? 1 : $total_pages;
        else
            $init_page_max = ( $total_pages > 4 ) ? 4 : $total_pages;

		for($i = 1; $i < $init_page_max + 1; $i++)
		{
			$page_string .= ( $i == $on_page ) ? '<li class="active"><span>' . $i . '</span></li>' : '<li><a href="' . $base_url. "page=". $i . '" data-page="'.$i.'">' . $i . '</a></li>';
		}

		if ( $on_page > 3  && $on_page < $total_pages )
		{
			$page_string .= ( $on_page > 3 ) ? '<li class="disabled"><span>...</span></li>' : '';
			$init_page_min = ( $on_page > 3 ) ? $on_page : 4;
			$init_page_max = ( $on_page < $total_pages - 3 ) ? $on_page : $total_pages - 3;

			for($i = $init_page_min - 1; $i < $init_page_max + 2; $i++)
			{
				$page_string .= ($i == $on_page) ? '<li class="active"><span>' . $i . '</span></li>' : '<li><a href="' . $base_url. "page=". $i. '" data-page="'.$i.'">' . $i . '</a></li>';
			}
			$page_string .= ( $on_page < $total_pages - 2 ) ? '<li class="disabled"><span>...</span></li>' : '';
		}
		else
			$page_string .= '<li class="disabled"><span>...</span></li>';


        if ($on_page > $total_pages - 3  && $on_page < $total_pages)
        {
            for($i = $total_pages - 1; $i < $total_pages + 1; $i++)
    		{
    			$page_string .= ( $i == $on_page ) ? '<li class="active"><span>' . $i . '</span></li>'  : '<li><a href="' . $base_url. "page=". $i. '" data-page="'.$i.'">' . $i . '</a></li>';
    		}
        }
        elseif($on_page == $total_pages)
        {
            for($i = $total_pages - 2; $i < $total_pages + 1; $i++)
    		{
    			$page_string .= ( $i == $on_page ) ? '<li class="active"><span>' . $i . '</span></li>'  : '<li><a href="' . $base_url. "page=". $i. '" data-page="'.$i.'">' . $i . '</a></li>';
    		}
        }
        else
        {
            for($i = $total_pages; $i < $total_pages + 1; $i++)
    		{
    			$page_string .= ( $i == $on_page ) ? '<li class="active"><span>' . $i . '</span></li>'  : '<li><a href="' . $base_url. "page=". $i. '" data-page="'.$i.'">' . $i . '</a></li>';
    		}
        }


	}
	else
	{
		for($i = 1; $i < $total_pages + 1; $i++)
		{
			$page_string .= ( $i == $on_page ) ? '<li class="active"><span>' . $i . '</span></li>' : '<li><a href="' . $base_url. "page=". $i. '" data-page="'.$i.'">' . $i . '</a></li>';
		}
	}

	if ( $add_prevnext_text )
	{
		if ( $on_page > 1 )
		{
			$page_string = '<li><a href="' . $base_url. 'page='.($on_page - 1).'" data-page="'.($on_page - 1).'"><i class="fa fa-chevron-left"></i></a></li>'
						. $page_string;
		}
		else
			$page_string = '<li class="disabled"><a href="JavaScript: void(0);"><i class="fa fa-chevron-left"></i></a></li>'
						. $page_string;

		if ( $on_page < $total_pages )
		{
			$page_string .= '<li><a href="' . $base_url. 'page='.($on_page + 1).'" data-page="'.($on_page + 1).'"><i class="fa fa-chevron-right"></i></a></li>';
		}
		else
			$page_string .= '<li class="disabled"><a href="JavaScript: void(0);"><i class="fa fa-chevron-right"></i></a></li>';
	}

	echo $page_string;
}

?>