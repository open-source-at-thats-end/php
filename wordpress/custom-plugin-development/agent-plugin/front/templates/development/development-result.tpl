<script type="text/javascript">
    {*var isloginReq 	= '{$isloginReq}';*}
	{*var Site_Url 	= '{$Site_Url}';*}
	var user_log_in = '{$user_log_in}';
	var TPL_images = '{$TPL_images}';
	var OtherConfig = {$OtherConfig|json_encode};
</script>

<div class="content">
	<div class="single-property-gallery-container">
		<div class="single-property-gallery" itemscope itemtype="https://schema.org/ImageGallery">
			{if $arrDevelopment.PictureArr|count > 0}
				{assign var=count value=1}
				{section name=pic loop=$arrDevelopment.PictureArr|count}
					{assign var=photo_large value=$arrDevelopment.PictureArr[pic]}
					{assign var=photo_thumb value=$arrDevelopment.PictureArr[pic]|default:$Record.PictureArr[pic]}
					{if  $smarty.section.pic.total > 0}
						<figure itemprop="associatedMedia" itemscope itemtype="https://schema.org/ImageObject" class="{if $smarty.section.pic.index == 0}sp-gallery-main-img{/if}{if $smarty.section.pic.index > 4}d-none{/if} {if $Record.ListingStatus == 'Closed'}disabled-sold{/if}">
							<a aria-label="button" href="{$photo_large}" itemprop="contentUrl" data-size="1920x1280" class="te-cover image-size " style="background-image: url({$photo_large});"></a>
							<figcaption itemprop="caption description te-font-family">{$arrDevelopment.dev_title} - {$count}</figcaption>
						</figure>
						{assign var=tmpIndex value=$tmpIndex+1}
						{assign var=count value=$count+1}
						{if $tmpIndex >= $cntKeyword}{assign var=tmpIndex value=0}{/if}
					{/if}
				{/section}
			{else}
				<div class="pdetail-no-img text-center">
					<a aria-label="button" href="{$arrDevelopment.Pic}no-photo/0/0/" itemprop="contentUrl" data-size="1920x1280" class="te-cover ">
						<img src="{$arrDevelopment.PhotoBaseUrl}/no-photo/no-property-img.jpg" alt="">
					</a>
				</div>
			{/if}
		</div>
		{if $arrDevelopment.PictureArr|count > 0}
			<a class="btn btn-sm sp-gallery-btn te-btn text-white- text-uppercase p-2 shadow-none rounded-0 position-absolute te-font-size-14 te-pd-gallery-view-more lpt-btn lpt-btn-txt " href="javascript::void(0);" role="button">{$arrDevelopment.PictureArr|count} more photos</a>
		{/if}
		<div class="clearfix"></div>
	</div>
</div>
<section class=" te-font-family pt-4 pb-5 py-md-4">
	<div class="container con-div pt-0">
		<div class="row mt-md-4">
			{if isset($arrDevelopment['dev_content_head']) && $arrDevelopment['dev_content_head'] != ''}
				<div class="col-xl-1"></div>
				<div class="col-xl-10 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="text-center my-5">{$arrDevelopment['dev_content_head']}</div>
				</div>
				<div class="col-xl-1"></div>
			{/if}
			<div class="col-xl-1"></div>
			<div class="col-xl-10 col-lg-12 col-md-12 col-sm-12 col-12 link-section">
				<div class="row my-5 " >
					{if isset($arrDevelopment['dev_link1']) && $arrDevelopment['dev_link1'] != ''}
					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 my-2">
{*					<div class="Row rounded link-btn  p-0 ">*}
						<a class="main_btn_sec" href="{$arrDevelopment['dev_link1']}" target="_blank">
							<div class="float-child imgsec1" onmouseover="hover1(this);" onmouseout="unhover1(this);" >
								<img id="img1" class="img1" src="{$TPL_images}fact-sheet-icon.png"  alt="" >
							</div>
							<div class="float-child1 infosec1" onmouseover="hover1(this);" onmouseout="unhover1(this);">
								<div class=" text-uppercase child1-head head1" >Fact Sheet</div>
								<div id="link1" class="btn shadow-none rounded-1 text-capitalize btn-schedule button_link_color p-0">View Fact Sheet</div>
							</div>
						</a>
					</div>
					{/if}
					{if isset($arrDevelopment['dev_link2']) && $arrDevelopment['dev_link2'] != ''}
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 my-2">
{*						<div class="Row rounded link-btn  p-0 ">*}
							{if isset($arrConfig['Listing']['require_reg_for_dev_page']) && $arrConfig['Listing']['require_reg_for_dev_page'] == 'Yes'}
								{if $isUserLoggedIn == true}
									<a class="main_btn_sec" href="{$arrDevelopment['dev_link1']}" target="_blank">
										<div class="float-child imgsec2 " onmouseover="hover2(this);" onmouseout="unhover2(this);">
											<img id="img2" class="img2" src="{$TPL_images}pricing-icon.png"  alt="" />
										</div>
										<div class="float-child1 infosec2" onmouseover="hover2(this);" onmouseout="unhover2(this);">
											<div class=" text-uppercase child1-head head2">Pricing</div>
											<div {*type="button"*} id="link2" {*href="{$arrDevelopment['dev_link2']}" target="_blank"*} class="btn shadow-none rounded-1 text-capitalize btn-schedule button_link_color  p-0">View Pricing</div>
										</div>
									</a>
								{else}
									<a class="popup-modal-sm " data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login" href="JavaScript:void(0);" >
										<div class="float-child imgsec2 " onmouseover="hover2(this);" onmouseout="unhover2(this);">
											<img id="img2" class="img2" src="{$TPL_images}pricing-icon.png"  alt=""  />
										</div>
										<div class="float-child1 infosec2" onmouseover="hover2(this);" onmouseout="unhover2(this);">
											<div class=" text-uppercase child1-head head2">Pricing</div>
											<div class=" btn shadow-none rounded-1 text-capitalize btn-schedule button_link_color  p-0" id="link2" {*aria-label="button" data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login" href="JavaScript:void(0);" role="button"*} title="View Pricing">View Pricing</div>
										</div>
									</a>
								{/if}
							{else}
								<a class="main_btn_sec" href="{$arrDevelopment['dev_link2']}" target="_blank">
									<div class="float-child imgsec2 " onmouseover="hover2(this);" onmouseout="unhover2(this);">
										<img id="img2" class="img2" src="{$TPL_images}pricing-icon.png"  alt=""   />
									</div>
									<div class="float-child1 infosec2" onmouseover="hover2(this);" onmouseout="unhover2(this);">
										<div class=" text-uppercase child1-head head2">Pricing</div>
										<div {*type="button"*} id="link2" {*href="{$arrDevelopment['dev_link2']}" target="_blank"*} class="btn shadow-none rounded-1 text-capitalize btn-schedule button_link_color  p-0">View Pricing</div>
									</div>
								</a>
							{/if}
						</div>
					{/if}
					{if isset($arrDevelopment['dev_link3']) && $arrDevelopment['dev_link3'] != ''}
					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 my-2">
{*						<div class="Row rounded link-btn  p-0 ">*}
							{if isset($arrConfig['Listing']['require_reg_for_dev_page']) && $arrConfig['Listing']['require_reg_for_dev_page'] == 'Yes'}
								{if $isUserLoggedIn == true}
									<a class="main_btn_sec" href="{$arrDevelopment['dev_link3']}" target="_blank">
										<div class="float-child imgsec3" onmouseover="hover3(this);" onmouseout="unhover3(this);">
											<img id="img3" class="img3" src="{$TPL_images}floor-plans-icon.png"  alt=""  >
										</div>
										<div class="float-child1 infosec3" onmouseover="hover3(this);" onmouseout="unhover3(this);">
											<div class=" text-uppercase child1-head head3">Floor Plans</div>
											<div id="link3" class="btn shadow-none rounded-1 text-capitalize btn-schedule button_link_color  p-0">View Floor Plans</div>
										</div>
									</a>
								{else}
									<a class="popup-modal-sm " data-toggle="modal" data-target="MemberLogin" data-url="{$Site_Url}{Constants::TYPE_MEMBER_DETAIL}/?action=member-login" href="JavaScript:void(0);" >
										<div class="float-child imgsec3" onmouseover="hover3(this);" onmouseout="unhover3(this);">
											<img id="img3" class="img3" src="{$TPL_images}floor-plans-icon.png"  alt=""  >
										</div>
										<div class="float-child1 infosec3" onmouseover="hover3(this);" onmouseout="unhover3(this);">
											<div class=" text-uppercase child1-head head3">Floor Plans</div>
											<div class=" btn shadow-none rounded-1 text-capitalize btn-schedule button_link_color  p-0" id="link3" title="View Floor Plans">View Floor Plans</div>
										</div>
									</a>
								{/if}
							{else}
								<a class="main_btn_sec" href="{$arrDevelopment['dev_link3']}" target="_blank">
									<div class="float-child imgsec3" onmouseover="hover3(this);" onmouseout="unhover3(this);">
										<img id="img3" class="img3" src="{$TPL_images}floor-plans-icon.png"  alt=""  >
									</div>
									<div class="float-child1 infosec3" onmouseover="hover3(this);" onmouseout="unhover3(this);">
										<div class=" text-uppercase child1-head head3">Floor Plans</div>
										<div id="link3" class="btn shadow-none rounded-1 text-capitalize btn-schedule button_link_color  p-0">View Floor Plans</div>
									</div>
								</a>
							{/if}
						</div>
					{/if}
				</div>
			</div>
			<div class="col-xl-1"></div>
			{if isset($arrDevelopment['dev_content_build_info']) && $arrDevelopment['dev_content_build_info'] != ''}
				<div class="col-xl-1"></div>
				<div class="col-xl-10 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="text-center my-5">{$arrDevelopment['dev_content_build_info']}</div>
				</div>
				<div class="col-xl-1"></div>
			{/if}
		</div>
	</div>
</section>
{if isset($arrDevelopment['dev_google_map_code']) && $arrDevelopment['dev_google_map_code'] != ''}
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 p-0">
		{*<div class="text-center text-dark te-font-size-22">The Residence at {$arrDevelopment['dev_title']} Location</div>*}
		<div class="text-center map-embeded">
			<iframe width="100%" height="540" id="gmap_canvas" src="https://maps.google.com/maps?key={$google_api_key}&q={if isset($arrDevelopment['dev_google_map_code']) && $arrDevelopment['dev_google_map_code'] != ''}{$arrDevelopment['dev_google_map_code']}{/if}&output=embed" frameborder="0" scrolling="no"></iframe>
		</div>
	</div>
{/if}
<section class=" te-font-family pt-0 pb-5 pb-md-4">
	<div class="row {*mt-md-4*} setbgcolor">
		<div class="container con-div p-5">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-lg-5">
				<div class="card w-100 rounded-0 my-2 mt-md-0  border-0 ">
					<div class="card-header setbgcolor border-0 px-4 pt-4 pb-3">
						<div class="col-xl-12 col-lg-12 col-md-12 sec-title px-0">
							<h5 class="request-detail-title text-center pb-0 mb-0 heading_txt_color">Request Details</h5>
						</div>
					</div>
					{include file="listing/schedule_showing.tpl"}
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		{if isset($arrDevelopment['dev_content_footer']) && $arrDevelopment['dev_content_footer'] != ''}
		<div class="container con-div pt-4">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="text-center my-4">{$arrDevelopment['dev_content_footer']}</div>
			</div>
		</div>
		{/if}
	</div>
</section>
<div class="pswp te-z-index-99999" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="pswp__bg"></div>
	<div class="pswp__scroll-wrap">
		<div class="pswp__container">
			<div class="pswp__item"></div>
			<div class="pswp__item"></div>
			<div class="pswp__item"></div>
		</div>
		<div class="pswp__ui pswp__ui--hidden">
			<div class="pswp__top-bar">
				<div class="pswp__counter"></div>
				<button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
				<button class="pswp__button pswp__button--share" title="Share"></button>
				<button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
				<button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
				<div class="pswp__preloader">
					<div class="pswp__preloader__icn">
						<div class="pswp__preloader__cut">
							<div class="pswp__preloader__donut"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
				<div class="pswp__share-tooltip"></div>
			</div>
			<button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
			<button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
			<div class="pswp__caption">
				<div class="pswp__caption__center"></div>
			</div>
		</div>
	</div>
</div>
