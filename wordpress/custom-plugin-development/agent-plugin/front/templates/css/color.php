<?php
$absolute_path = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);

$wp_load = $absolute_path[0] . 'wp-load.php';
require_once($wp_load);
header('Content-type: text/css');
header('Cache-control: must-revalidate');

class Color
{
    private static $instance ;
    public $btn_color;
    public $btn_txt_color;
    public $txt_color;
    public $link_color;
    public $link_hover;
    public $hover_color;
    public $hover_text_color;
    public $heading_txt_color;
    public $quick_head_title;
    public $quick_sub_title;
    public $quick_style;

	public $quick2_head_title;
	public $quick2_sub_title;
	public $quick2_style;

	public $quick3_style;

	public $qsrch_title_size;
	public $qsrch_title_style;
	public $qsrch_title_align;

	public $quick3_title_size;
	public $quick3_title_style;

    public $quick4_title_size;
    public $quick4_title_style;
    public $quick5_title_size;
    public $quick5_title_style;

    public $quick3_hover_color;

    public $quick_text_color;
    public $quick_btn_color;
    public $quick_font_size;
    public $quick_font_family;

    public $style9_text_color;
    public $style9_btn_color;
    public $style9_bg_color;
    public $style9_bdr_color;
    public $style9_bdr_hvr_color;
    public $style9_bg_hvr_color;

    public $style12_text_dark;
    public $style12_font_family_dark;
    public $style12_font_size_dark;

    public $style12_text_light;
    public $style12_font_family_light;
    public $style12_font_size_light;

    public $pre_market_text_light;
    public $pre_market_text_dark;
    public $pre_market_border_dark;
    public $pre_market_border_light;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Color();
        }
        return self::$instance;
    }
    public function initialize()
    {
        $opt = get_option(Constants::OPTIONS)['OtherConfig'];

        $this->btn_color = (strpos($opt['btn_color'], '#') !== false) ? $opt['btn_color'] : "#".$opt['btn_color'];
        $this->btn_txt_color = (strpos($opt['btn_txt_color'], '#') !== false) ? $opt['btn_txt_color'] : "#".$opt['btn_txt_color'];
        $this->txt_color = (strpos($opt['text_color'], '#') !== false) ? $opt['text_color'] : "#".$opt['text_color'];
        $this->heading_txt_color = (strpos($opt['heading_txt_color'], '#') !== false) ? $opt['heading_txt_color'] : "#".$opt['heading_txt_color'];
        $this->link_color = (strpos($opt['link_color'], '#') !== false) ? $opt['link_color'] : "#".$opt['link_color'];
        $this->link_hover = $opt['link_hover'];
        $this->main_font_family = $opt['main_font_family'];
        $this->hover_color = $opt['hover_color'];
        $this->hover_text_color = $opt['hover_text_color'];
        $this->quick_head_title = $opt['quick_head_title'];
        $this->quick_sub_title = $opt['quick_sub_title'];
        $this->quick_style = $opt['quick_style'];
	    $this->quick2_head_title = $opt['quick2_head_title'];
	    $this->quick2_sub_title = $opt['quick2_sub_title'];
	    $this->quick2_style = $opt['quick2_style'];
	    $this->quick3_style = $opt['quick3_text_style'];
	    $this->qsrch_title_size = $opt['qsrch_title_size'];
	    $this->qsrch_title_style = $opt['qsrch_title_style'];
	    $this->qsrch_title_align = $opt['qsrch_title_align'];
        $this->quick3_title_size = $opt['quick3_title_size'];
        $this->quick3_title_style = $opt['quick3_title_style'];
        $this->quick3_hover_color = $this->hex2rgb($opt['btn_color'],'0.6');
        $this->quick4_title_size = $opt['quick4_title_size'];
        $this->quick4_title_style = $opt['quick4_title_style'];
        $this->quick5_title_size = $opt['quick5_title_size'];
        $this->quick5_title_style = $opt['quick5_title_style'];
        $this->quick_text_color = $opt['quick_text_color'];
        $this->quick_btn_color = $opt['quick_btn_color'];
        $this->quick_font_size = $opt['quick_font_size'];
        $this->quick_font_family = $opt['quick_font_family'];

        $this->style9_text_color = $opt['style9_text_color'];
        $this->style9_btn_color = $opt['style9_btn_color'];
        $this->style9_bg_color = $opt['style9_bg_color'];
        $this->style9_bdr_color = $opt['style9_bdr_color'];
        $this->style9_bdr_hvr_color = $opt['style9_bdr_hvr_color'];
        $this->style9_bg_hvr_color = $opt['style9_bg_hvr_color'];

        $this->style12_text_dark = $opt['style12_text_dark'];
        $this->style12_font_family_dark = $opt['style12_font_family_dark'];
        $this->style12_font_size_dark = $opt['style12_font_size_dark'];
        $this->style12_text_light = $opt['style12_text_light'];
        $this->style12_font_family_light = $opt['style12_font_family_light'];
        $this->style12_font_size_light = $opt['style12_font_size_light'];

        $this->pre_market_text_dark = $opt['pre_market_light'];
        $this->pre_market_border_dark = $opt['market_border_light'];

        $this->pre_market_text_light = $opt['pre_market_dark'];
        $this->pre_market_border_light = $opt['market_border_dark'];

    }
    public function hex2rgb( $colour, $opcity ) {
		if ( $colour[0] == '#' ) {
			$colour = substr( $colour, 1 );
		}
		if ( strlen( $colour ) == 6 ) {
			list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
		} elseif ( strlen( $colour ) == 3 ) {
			list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
		} else {
			return false;
		}
		$r = hexdec( $r );
		$g = hexdec( $g );
		$b = hexdec( $b );
		return 'rgba('.$r.','. $g.','. $b.','.$opcity.')';
	}
}
Color::getInstance()->initialize();
?>
<style>.quick-head-title{
font-size: <?php echo Color::getInstance()->quick_head_title ?>px !important;
}
.quick-sub-title{
font-size: <?php echo Color::getInstance()->quick_sub_title ?>px !important;
}
.quick-style{
font-style: <?php echo Color::getInstance()->quick_style ?> !important;
}
.quick2-head-title{
font-size: <?php echo Color::getInstance()->quick2_head_title ?>px !important;
}
.quick2-sub-title{
font-size: <?php echo Color::getInstance()->quick2_sub_title ?>px !important;
}
.quick2-style{
font-style: <?php echo Color::getInstance()->quick2_style ?> !important;
}
.quick3-style{
font-family: <?php echo Color::getInstance()->quick3_style ?> !important;
}

.lpt-btn{
background-color: <?php echo Color::getInstance()->btn_color ?> !important;
border: 1px solid <?php echo Color::getInstance()->btn_color ?> !important;
}
.quick3-style.lpt-btn:hover
{
background-color: <?php echo Color::getInstance()->quick3_hover_color ?> !important;
}
.lpt-btn-txt{
color: <?php echo Color::getInstance()->btn_txt_color ?> !important;
}
.lpt-quick-color{
color: <?php echo Color::getInstance()->btn_color ?> !important;
border-color: <?php echo Color::getInstance()->btn_color ?> !important;
border-bottom-width: medium !important;
}
.f-arrow{
color: <?php echo Color::getInstance()->btn_color ?> !important;
}
select.lpt-quick-color:focus{
color: <?php echo Color::getInstance()->btn_color ?> !important;
}
.page-item.active .page-link, .pricetag{
background-color: <?php echo Color::getInstance()->btn_color ?> !important;
border: 1px solid <?php echo Color::getInstance()->btn_color ?> !important;
color: <?php echo Color::getInstance()->btn_txt_color ?> !important;
}

.te-admin-pages aside .nav-pills .nav-link.active, .te-draw-radius-button a:hover{
background-color: <?php echo Color::getInstance()->btn_color ?> !important;
color: <?php echo Color::getInstance()->btn_txt_color ?> !important;
}

.heading_txt_color{
color: <?php echo Color::getInstance()->heading_txt_color ?> !important;
}

.txt-color{
color: <?php echo Color::getInstance()->txt_color ?> !important;
}

.link-color{
color: <?php echo Color::getInstance()->link_color ?> !important;
}

.hover-text-color:hover{
    color: <?php echo Color::getInstance()->hover_text_color ?> !important;
}

.hover-color:hover{
    background-color: <?php echo Color::getInstance()->hover_color ?> !important;
}

.advanced-search-link .link-hover:hover{
border-bottom: 1px solid #ffffff !important;
color : #ffffff !important;
}
.lpt-hbtn{
background-color: <?php echo Color::getInstance()->btn_color ?> !important;
}
.lpt-hbtn-sell{
background-color: <?php echo Color::getInstance()->btn_color ?> !important;
opacity: <?php echo '.5'; ?> !important;
}
.lpt-hbtn-sell:hover{
background-color: <?php echo Color::getInstance()->btn_color ?> !important;
color: <?php echo Color::getInstance()->btn_txt_color ?> !important;
}
.home-search-tab .active{
background-color: <?php echo '#ffffff'; ?> !important;
color: <?php echo '#000'; ?> !important;
}
.qsrch_title{
font-size: <?php echo Color::getInstance()->qsrch_title_size ?>px !important;
font-family: <?php echo Color::getInstance()->qsrch_title_style ?> !important;
text-align: <?php echo Color::getInstance()->qsrch_title_align ?> !important;
}
.quick3_title{
font-size: <?php echo Color::getInstance()->quick3_title_size ?>px !important;
font-family: <?php echo Color::getInstance()->quick3_title_style ?> !important;
}
.quick4_title{
    font-size: <?php echo Color::getInstance()->quick4_title_size ?>px !important;
    font-family: <?php echo Color::getInstance()->quick4_title_style ?> !important;
    }
.quick5_title{
    font-size: <?php echo Color::getInstance()->quick5_title_size ?>px !important;
    font-family: <?php echo Color::getInstance()->quick5_title_style ?> !important;
}
.line_or:before{
    background: <?php echo Color::getInstance()->btn_color ?> !important;
}
.line{
    background: <?php echo Color::getInstance()->btn_color ?> !important;
}
    /*.p9.properties-slider .btn-style9{
        border: 2px solid <?php echo Color::getInstance()->btn_color ?> !important;
}*/
    /*.p9 .icon-2x{
        border: 2px solid <?php echo Color::getInstance()->btn_color ?> !important;
}*/
    /*.p9.properties-slider .slick-arrow.slick-prev::before{
        border-color: transparent transparent <?php echo Color::getInstance()->btn_color ?> <?php echo Color::getInstance()->btn_color ?> !important;
}
.p9.properties-slider .slick-arrow.slick-next::before{
    border-color: <?php echo Color::getInstance()->btn_color ?> <?php echo Color::getInstance()->btn_color ?> transparent transparent !important;
}*/
#condo-building .nav-tabs .nav-link.active/*, a:hover*/{
    background-color: <?php echo Color::getInstance()->btn_color ?> !important;
    color: <?php echo Color::getInstance()->btn_txt_color ?> !important;
    border-color: unset !important;
    border: unset !important;
}
#condo-building #viewTab .nav-link.active{
    background-color: unset !important;
    color: <?php echo Color::getInstance()->btn_color ?> !important;
}
#condo-building .nav-tabs .nav-link:hover{
    color: <?php echo Color::getInstance()->btn_txt_color ?> !important;
    background-color: <?php echo Color::getInstance()->btn_color ?> !important;
}
    /*Quick Search start*/
    .quick_text_color {
        color: <?php echo Color::getInstance()->quick_text_color ?> !important;

    }

    .quick_text_color.arrow-clr{
        color: <?php echo Color::getInstance()->quick_text_color ?> !important;

    }
    .quick_text_color select{
        color: <?php echo Color::getInstance()->quick_text_color ?> !important;
        border-bottom: 1.5px solid <?php echo Color::getInstance()->quick_text_color ?> !important;
    }

    .quick_text_color select:focus{
        color: <?php echo Color::getInstance()->quick_text_color ?> !important;
        border-bottom: <?php echo Color::getInstance()->quick_text_color ?> !important;
    }

    .quick_btn_color {
        color: <?php echo Color::getInstance()->quick_btn_color ?> !important;
    }
    .quick_btn_color.quick_text_color{
        color: <?php echo Color::getInstance()->quick_text_color ?> !important;
        border: 1.5px solid <?php echo Color::getInstance()->quick_btn_color ?> !important;
    }
    .quick_btn_color.quick_text_color:hover{
        color: <?php echo Color::getInstance()->quick_text_color ?> !important;
        border: 1.5px solid <?php echo Color::getInstance()->quick_btn_color ?> !important;
    }
    select.quick_font_size{
        font-size: <?php echo Color::getInstance()->quick_font_size ?>px !important;
    }
    .quick-btn .quick_font_size{
        font-size: <?php echo Color::getInstance()->quick_font_size ?>px !important;
    }

    select.quick_font_family{
        font-family: <?php echo Color::getInstance()->quick_font_family ?> !important;
    }
    .quick-btn .quick_font_family{
        font-family: <?php echo Color::getInstance()->quick_font_family ?> !important;
    }
    .quick_font_family{
        font-family: <?php echo Color::getInstance()->quick_font_family ?> !important;
    }
    .head-title.quick_title_space {
        padding-bottom:  <?php echo Color::getInstance()->quick_title_space ?>px !important;
    }
    .head-sub-title.quick_title_space {
        padding-top:  <?php echo Color::getInstance()->quick_title_space ?>px !important;

    }
    .quick_title_transform {
        text-transform:  <?php echo Color::getInstance()->quick_title_transform ?> !important;
    }
    .quick_search_transform {
        text-transform:  <?php echo Color::getInstance()->quick_search_transform ?> !important;
    }
    /*Quick Search End*/

    /* Property Style 9 start*/
    .style9_btn_color {
        color: <?php echo Color::getInstance()->style9_btn_color ?> !important;
    }
    .style9_text_color {
        color: <?php echo Color::getInstance()->style9_text_color ?> !important;
    }
    /*.p9.properties-slider .style9_text_color.slick-prev::before {
        border-color: transparent transparent <?php echo Color::getInstance()->style9_text_color ?> <?php echo Color::getInstance()->style9_text_color ?> !important;
    }
    .p9.properties-slider .style9_text_color.slick-next::before{
        border-color: <?php echo Color::getInstance()->style9_text_color ?> <?php echo Color::getInstance()->style9_text_color ?> transparent transparent !important;
    }*/

    .p9.properties-slider .style9_bdr_color.slick-prev::before {
        border-color: transparent transparent <?php echo Color::getInstance()->style9_bdr_color ?> <?php echo Color::getInstance()->style9_bdr_color ?> !important;
    }
    .p9.properties-slider .style9_bdr_color.slick-next::before{
        border-color:  <?php echo Color::getInstance()->style9_bdr_color ?> <?php echo Color::getInstance()->style9_bdr_color ?> transparent transparent !important;
    }
    .p9.properties-slider .style9_bdr_color.slick-prev:hover::before {
        border-color: transparent transparent <?php echo Color::getInstance()->style9_bdr_hvr_color ?> <?php echo Color::getInstance()->style9_bdr_hvr_color ?> !important;
    }
    .p9.properties-slider .style9_bdr_color.slick-next:hover::before{
        border-color: <?php echo Color::getInstance()->style9_bdr_hvr_color ?> <?php echo Color::getInstance()->style9_bdr_hvr_color ?> transparent transparent !important;
    }

    .p9.properties-slider .style9_bdr_color{
        border-color: 2px solid  <?php echo Color::getInstance()->style9_bdr_hvr_color ?> !important;
    }

    .p9 .style9_bdr_color {
        border: 2px solid <?php echo Color::getInstance()->style9_bdr_color ?> !important;
    }
    .p9.properties-slider .style9_bdr_color{
        border: 2px solid <?php echo Color::getInstance()->style9_bdr_color ?> !important;
    }
    .p9.properties-slider .style9_bdr_color:hover{
        border: 2px solid <?php echo Color::getInstance()->style9_bdr_hvr_color ?> !important;
        color: <?php echo Color::getInstance()->style9_bdr_hvr_color ?> !important;

    }
    .border-right.style9_text_color{
        border-right: 1px solid <?php echo Color::getInstance()->style9_text_color ?> !important;

    }
    .p9.properties-slider .style9_bg_color{
        background-color: <?php echo Color::getInstance()->style9_bg_color?> !important;
    }
    .p9.properties-slider .style9_bg_color:hover{
        background-color: <?php echo Color::getInstance()->style9_bg_hvr_color?> !important;

    }
    @media (max-width: 768px){
        .te-style-9 .border-right.style9_text_color{
            border-right: 1px solid <?php echo Color::getInstance()->style9_bdr_color ?> !important;
        }
        .te-style-9 .border-right.style9_text_color:hover{
            border-right: 1px solid <?php echo Color::getInstance()->style9_bdr_hvr_color ?> !important;
        }
    }
    /*Property Style 9 End*/

    /*Property Style 12 Start*/

    .style12_text_dark{
        color: <?php echo Color::getInstance()->style12_text_dark ?> !important;

    }
    .style12_text_dark:hover{
        color: <?php echo Color::getInstance()->style12_text_dark ?> !important;

    }
    .style12_font_size_dark{
        font-size: <?php echo Color::getInstance()->style12_font_size_dark ?>px !important;;
    }

    .style12_font_family_dark{
        font-family: <?php echo Color::getInstance()->style12_font_family_dark ?> !important;;
    }

    .style12_text_light{
        color: <?php echo Color::getInstance()->style12_text_light ?> !important;

    }
    .style12_text_light:hover{
        color: <?php echo Color::getInstance()->style12_text_light ?> !important;

    }
    .style12_font_size_light{
        font-size: <?php echo Color::getInstance()->style12_font_size_light ?>px !important;;
    }

    .style12_font_family_light{
        font-family: <?php echo Color::getInstance()->style12_font_family_light ?> !important;;
    }
    /* Property Style 12 End*/

    /* Global font-family start*/
    /*.listings-box .te-font-family{
        font-family: <?php echo Color::getInstance()->main_font_family ?>!important;
    }
    .te-font-family{
        font-family: <?php echo Color::getInstance()->main_font_family ?>!important;
    }*/
    .te-font-family, .listings-box .te-font-family, .properties-slider.te-font-family, .properties-slider h3, .style2-property-box.te-font-family, .properties-slider-3.te-font-family, .slick-slide .te-font-family, .te-font-family h5{
        font-family: <?php if(Color::getInstance()->main_font_family == 'Poppins' || Color::getInstance()->main_font_family == 'poppins'){echo Color::getInstance()->main_font_family.', sans-serif';}else{echo Color::getInstance()->main_font_family;} ?>!important;
    }

    .te-font-family *{
        font-family: <?php if(Color::getInstance()->main_font_family == 'Poppins' || Color::getInstance()->main_font_family == 'poppins'){echo Color::getInstance()->main_font_family.', sans-serif';}else{echo Color::getInstance()->main_font_family;} ?>!important;
    }
    /* Global font-family end*/
    /*Predefind market report start font-color start*/
    .pre_market_text_dark{
        color: <?php echo Color::getInstance()->pre_market_text_dark ?> !important;
        border-bottom-color: <?php echo Color::getInstance()->pre_market_border_dark ?> !important;

    }
    .text-border-bottom.market-title{
        border-bottom:2px solid <?php echo Color::getInstance()->pre_market_border_dark ?> !important;
    }
    .pre_market_text_dark:hover{
        color: <?php echo Color::getInstance()->pre_market_text_dark ?> !important;
        border-bottom-color: <?php echo Color::getInstance()->pre_market_border_dark ?> !important;

    }
    .pre_market_text_light{
        color: <?php echo Color::getInstance()->pre_market_text_light ?> !important;
        border-bottom-color: <?php echo Color::getInstance()->pre_market_border_light ?> !important;

    }
    .pre_market_text_light:hover{
        color: <?php echo Color::getInstance()->pre_market_text_light ?> !important;
        border-bottom-color: <?php echo Color::getInstance()->pre_market_border_light ?> !important;

    }
    .text-border-bottom.market-title{
        border-bottom:2px solid <?php echo Color::getInstance()->pre_market_border_light ?> !important;
    }
    /*Predefind market report start font-color end*/
</style>