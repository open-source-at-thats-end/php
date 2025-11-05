<?php

function smarty_function_html_pager_responsive_CustomWpPlugin($params, &$smarty){

    extract($params);

    $path_parts = explode("?", $_SERVER['REQUEST_URI']);
    $qArr = explode("&", $path_parts[1]);
    $qString = '?';

    // Added
    $curPage = $_GET['cpage'] ? $_GET['cpage'] : ($_POST['cpage'] ? $_POST['cpage'] : 1);

    foreach($qArr as $qStr) {
        $arr = explode('=', $qStr);
        if($arr[0] != 'cpage' && $qStr != '')
            $qString .= $qStr. '&';
    }

    $base_url = $qString;

    if (!is_numeric(strpos($base_url,"?")))
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
                //$page_string .= ( $i == $on_page ) ? '<li class="active"><span class="btn-container"><span class="page-numbers current"><a class="page-numbers" href="JavaScript: void(0);">' . $i . '</a></span></span></li>' : '<li><span class="btn-container"><a class="page-numbers" href="' . $base_url. "page=". $i . '" data-page="'.$i.'">' . $i . '</a></span></li>';
                $page_string .= ( $i == $on_page ) ? '<a class="btn btn-gradient-primary page-num" href="JavaScript: void(0);">'.$i.'</a>' : '<a type="button" class="btn btn-gradient-primary page-num" href="' . $base_url. "cpage=". $i . '" data-page="'.$i.'">' . $i . '</a> ';

            $page_string .= '<a class="disabled"><span class="btn-container"><a class="page-numbers btn btn-gradient-primary page-num">...</a></span></a>';
            //$page_string .= '<li><span class="btn-container"><a class="page-numbers" href="' . $base_url. 'page='. $total_pages . '" data-page="'.$total_pages.'">' . $total_pages . '</a></span></li>';
            $page_string .= '<a><span class="btn-container"><a class="page-numbers btn btn-gradient-primary page-num" href="' . $base_url. 'cpage='. $total_pages . '" data-page="'.$total_pages.'">' . $total_pages . '</a></span></a>';
        }
        elseif($on_page == $total_pages || $on_page > ($total_pages-$min_range))
        {
            $min_range--;

            //$page_string .= '<li><span class="btn-container"><a class="page-numbers" href="'.$base_url.'"page="1" data-page="1">1</a></span></li>';
            $page_string .= '<a class="btn btn-gradient-primary page-num" href="'.$base_url.'"page="1" data-page="1">1</a>';
            $page_string .= '<a class="disabled"><span class="btn-container"><a class="page-numbers btn btn-gradient-primary page-num">...</a></span></a>';

            $j=$total_pages-$min_range;
            if($on_page == ($total_pages-$min_range))
                $j--;

            for($i=$j; $i<=$total_pages; $i++)
                //$page_string .= ( $i == $on_page ) ? '<li class="active"><span class="btn-container"><span class="page-numbers current"><a class="page-numbers" href="JavaScript: void(0);">' . $i . '</a></span></span></li>' : '<li><span class="btn-container"><a class="page-numbers" href="' . $base_url. "page=". $i . '" data-page="'.$i.'">' . $i . '</a></span></li>';
                $page_string .= ( $i == $on_page ) ? '<a class="btn btn-gradient-primary page-num" href="JavaScript: void(0);">'.$i.'</a>' : '<a type="button" class="btn btn-gradient-primary page-num" href="' . $base_url. "cpage=". $i . '" data-page="'.$i.'">' . $i . '</a> ';
        }
        else
        {
            //$page_string .= '<li><span class="btn-container"><a class="page-numbers" href="'.$base_url.'"page="1" data-page="1">1</a></span></li>';
            $page_string .= '<a><span class="btn-container"><a class="page-numbers btn btn-gradient-primary page-num" href="'.$base_url.'"page="1" data-page="1">1</a></span></a>';
            //$page_string .= '<li class="disabled"><span class="btn-container"><a class="page-numbers">...</a></span></li>';
            $page_string .= '<a class="disabled"><span class="btn-container"><a class="page-numbers btn btn-gradient-primary page-num">...</a></span></a>';

            for($i=$on_page-1; $i<=$on_page+1; $i++)
                //$page_string .= ( $i == $on_page ) ? '<li class="active"><span class="btn-container"><span class="page-numbers current"><a class="page-numbers" href="JavaScript: void(0);">' . $i . '</a></span></span></li>' : '<li><span class="btn-container"><a class="page-numbers" href="' . $base_url. "page=". $i . '" data-page="'.$i.'">' . $i . '</a></span></li>';
                $page_string .= ( $i == $on_page ) ? '<a class="btn btn-gradient-primary page-num" href="JavaScript: void(0);">'.$i.'</a>' : '<a type="button" class="btn btn-gradient-primary page-num" href="' . $base_url. "cpage=". $i . '" data-page="'.$i.'">' . $i . '</a> ';


            //$page_string .= '<li class="disabled"><span class="btn-container"><a class="page-numbers">...</a></span></li>';
            $page_string .= '<a class="disabled"><span class="btn-container"><a class="page-numbers btn btn-gradient-primary page-num">...</a></span></a>';
            //$page_string .= '<li><span class="btn-container"><a class="page-numbers" href="' . $base_url. 'page='. $total_pages . '" data-page="'.$total_pages.'">' . $total_pages . '</a></span></li>';
            $page_string .= '<a><span class="btn-container"><a class="page-numbers btn btn-gradient-primary page-num" href="' . $base_url. 'cpage='. $total_pages . '" data-page="'.$total_pages.'">' . $total_pages . '</a></span></a>';
        }

    }
    else
    {
        for($i = 1; $i < $total_pages + 1; $i++)
        {
            //$page_string .= ( $i == $on_page ) ? '<li class="active"><span class="btn-container"><span class="page-numbers current"><a class="page-numbers" href="JavaScript: void(0);">' . $i . '</a></span></span></li>' : '<li><span class="btn-container"><a class="page-numbers" href="' . $base_url. "page=". $i. '" data-page="'.$i.'">' . $i . '</a></span></li>';
            $page_string .= ( $i == $on_page ) ? '<a class="btn btn-gradient-primary page-num" href="JavaScript: void(0);">'.$i.'</a>' : '<a type="button" class="btn btn-gradient-primary page-num" href="' . $base_url. "cpage=". $i . '" data-page="'.$i.'">' . $i . '</a>';
        }
    }
    if( $add_prevnext_text )
    {
        if( $on_page > 1 )
        {
            //$page_string = '<li><span class="btn-container"><a class="page-numbers" href="' . $base_url. 'page='.($on_page - 1).'" data-page="'.($on_page - 1).'"><span class="glyphicon glyphicon-chevron-left">Previous</span></a></span></li>'
            $page_string = '<a class="btn btn-outline-secondary direction-btn" href="' . $base_url. 'cpage='.($on_page - 1).'" data-page="'.($on_page - 1).'">Previous</a>'
                . $page_string;
        }
        else
            //$page_string = '<li class="disabled"><span class="btn-container"><a href="JavaScript: void(0);"><span class="glyphicon glyphicon-chevron-left">Previous</span></a></span></li>'
            $page_string = '<a class="btn btn-outline-secondary direction-btn disabled" href="JavaScript: void(0);">Previous</a>'
                . $page_string;

        if( $on_page < $total_pages )
        {
            //$page_string .= '<li><span class="btn-container"><a class="page-numbers" href="' . $base_url. 'page='.($on_page + 1).'" data-page="'.($on_page + 1).'"><span class="glyphicon glyphicon-chevron-right">Next</span></a></span></li>';
            $page_string .= '<a class="btn btn-outline-secondary direction-btn" href="' . $base_url. 'cpage='.($on_page + 1).'" data-page="'.($on_page + 1).'">Next</a>';
        }
        else
            //$page_string .= '<li class="disabled"><span class="btn-container"><a href="JavaScript: void(0);"><span class="glyphicon glyphicon-chevron-right">Next</span></a></span></li>';
            $page_string .= '<a class="btn btn-outline-secondary direction-btn disabled" href="JavaScript: void(0);">Next</a>';
    }
    echo $page_string;
}
?>