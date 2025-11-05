<?php

function smarty_function_html_pager_responsive($params, &$smarty){
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
	if ( $total_pages > 5 )
	{
        $min_range = 3;
        if($on_page <= $min_range)
        {
            $j = $min_range;
            if($on_page == $min_range)
                $j++;

            for($i=1; $i<=$j; $i++)
                $page_string .= ( $i == $on_page ) ? '<li class="active"><span class="btn-container"><span class="page-numbers current"><a class="page-numbers" href="JavaScript: void(0);">' . $i . '</a></span></span></li>' : '<li><span class="btn-container"><a class="page-numbers" href="' . $base_url. "page=". $i . '" data-page="'.$i.'">' . $i . '</a></span></li>';

            $page_string .= '<li class="disabled"><span class="btn-container"><a class="page-numbers">...</a></span></li>';
            $page_string .= '<li><span class="btn-container"><a class="page-numbers" href="' . $base_url. 'page='. $total_pages . '" data-page="'.$total_pages.'">' . $total_pages . '</a></span></li>';
        }
        elseif($on_page == $total_pages || $on_page > ($total_pages-$min_range))
        {
            $min_range--;

            $page_string .= '<li><span class="btn-container"><a class="page-numbers" href="'.$base_url.'"page="1" data-page="1">1</a></span></li>';
            $page_string .= '<li class="disabled"><span class="btn-container"><a class="page-numbers">...</a></span></li>';

            $j=$total_pages-$min_range;
            if($on_page == ($total_pages-$min_range))
                $j--;

            for($i=$j; $i<=$total_pages; $i++)
                $page_string .= ( $i == $on_page ) ? '<li class="active"><span class="btn-container"><span class="page-numbers current"><a class="page-numbers" href="JavaScript: void(0);">' . $i . '</a></span></span></li>' : '<li><span class="btn-container"><a class="page-numbers" href="' . $base_url. "page=". $i . '" data-page="'.$i.'">' . $i . '</a></span></li>';
        }
        /*else
        {
    		$init_page_max = ( $total_pages > 1 ) ? 1 : $total_pages;
    		for($i = 1; $i < $init_page_max + 1; $i++)
    		{
    			$page_string .= ( $i == $on_page ) ? '<li class="active"><span>' . $i . '</span></li>' : '<li><a href="' . $base_url. "page=". $i . '" data-page="'.$i.'">' . $i . '</a></li>';
    //			if ( $i <  $init_page_max )
    //				$page_string .= ' ';
    		}

    		if ( $on_page > 1  && $on_page < $total_pages )
    		{
    			$page_string .= ( $on_page > 3 ) ? '<li class="disabled"><span>...</span></li>' : '';
    			$init_page_min = ( $on_page > 3 ) ? $on_page : 4;
    			$init_page_max = ( $on_page < $total_pages - 4 ) ? $on_page : $total_pages - 4;

    			for($i = $init_page_min - 1; $i < $init_page_max + 2; $i++)
    			{
    				$page_string .= ($i == $on_page) ? '<li class="active"><span>' . $i . '</span></li>' : '<li><a href="' . $base_url. "page=". $i. '" data-page="'.$i.'">' . $i . '</a></li>';
    //				if ( $i <  $init_page_max + 1 )
    //					$page_string .= ' ';
    			}
    			$page_string .= ( $on_page < $total_pages - 4 ) ? '<li class="disabled"><span>...</span></li>' : '';
    		}
    		else
    			$page_string .= '<li class="disabled"><span>...</span></li>';

    		for($i = $total_pages-1; $i < $total_pages + 1; $i++)
    		{
    			$page_string .= ( $i == $on_page ) ? '<li class="active"><span>' . $i . '</span></li>'  : '<li><a href="' . $base_url. "page=". $i. '" data-page="'.$i.'">' . $i . '</a></li>';
    //			if( $i <  $total_pages )
    //				$page_string .= " ";
    		}

        }*/
        else
        {
            $page_string .= '<li><span class="btn-container"><a class="page-numbers" href="'.$base_url.'"page="1" data-page="1">1</a></span></li>';
            $page_string .= '<li class="disabled"><span class="btn-container"><a class="page-numbers">...</a></span></li>';

            for($i=$on_page-1; $i<=$on_page+1; $i++)
                $page_string .= ( $i == $on_page ) ? '<li class="active"><span class="btn-container"><span class="page-numbers current"><a class="page-numbers" href="JavaScript: void(0);">' . $i . '</a></span></span></li>' : '<li><span class="btn-container"><a class="page-numbers" href="' . $base_url. "page=". $i . '" data-page="'.$i.'">' . $i . '</a></span></li>';


            $page_string .= '<li class="disabled"><span class="btn-container"><a class="page-numbers">...</a></span></li>';
            $page_string .= '<li><span class="btn-container"><a class="page-numbers" href="' . $base_url. 'page='. $total_pages . '" data-page="'.$total_pages.'">' . $total_pages . '</a></span></li>';
        }

	}
	else
	{
		for($i = 1; $i < $total_pages + 1; $i++)
		{
			$page_string .= ( $i == $on_page ) ? '<li class="active"><span class="btn-container"><span class="page-numbers current"><a class="page-numbers" href="JavaScript: void(0);">' . $i . '</a></span></span></li>' : '<li><span class="btn-container"><a class="page-numbers" href="' . $base_url. "page=". $i. '" data-page="'.$i.'">' . $i . '</a></span></li>';
//			if ( $i <  $total_pages )
//					$page_string .= " ";
		}
	}
	if( $add_prevnext_text )
	{
		if( $on_page > 1 )
		{
			$page_string = '<li><span class="btn-container"><a class="page-numbers" href="' . $base_url. 'page='.($on_page - 1).'" data-page="'.($on_page - 1).'"><span class="glyphicon glyphicon-chevron-left"></span></a></span></li>'
						. $page_string;
		}
		else
			$page_string = '<li class="disabled"><span class="btn-container"><a href="JavaScript: void(0);"><span class="glyphicon glyphicon-chevron-left"></span></a></span></li>'
						. $page_string;

		if( $on_page < $total_pages )
		{
			$page_string .= '<li><span class="btn-container"><a class="page-numbers" href="' . $base_url. 'page='.($on_page + 1).'" data-page="'.($on_page + 1).'"><span class="glyphicon glyphicon-chevron-right"></span></a></span></li>';
		}
		else
			$page_string .= '<li class="disabled"><span class="btn-container"><a href="JavaScript: void(0);"><span class="glyphicon glyphicon-chevron-right"></span></a></span></li>';
	}
	/*if ( $add_prevnext_text )
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
			$page_string .= '<li class="disabled"><a href="JavaScript: void(0);"><i class="fa fa-chevron-right"></a></li>';
	}*/

	echo $page_string;
}

?>
