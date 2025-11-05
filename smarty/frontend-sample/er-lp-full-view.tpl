<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 co-lg-12 col-xl-12 pfv-a">
        <div class="row">
			<div class="col-xs-12 col-xs-offset-0 {if isset($LVT_ShowQRCodeArea)}col-sm-6 col-sm-offset-0 col-md-7 col-md-offset-0{else}col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3{/if} col-lg-3 col-lg-offset-0 col-xl-4 col-xl-offset-0">
				<div class="clearfix">
					<textarea style="display: none" id="oe-images-json-ps">{json_encode($arrImg_PS)}</textarea>
					<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
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
									{*<button class="pswp__button pswp__button--share" title="Share"></button>*}
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
								<button class="pswp__button pswp__button--arrow--left" title="Previous"></button>
								<button class="pswp__button pswp__button--arrow--right" title="Next"></button>
								<div class="pswp__caption"><div class="pswp__caption__center"></div></div>
							</div>
						</div>
					</div>
				</div>
				{if cw::$screen == CW_S_LG || cw::$screen == CW_S_XL}
                    <textarea style="display: none" id="oe-images-json">{json_encode($arrImg)}</textarea>
					<figure id="az_mouseOverZoomParent" class="m-b-0">
						{*if cw::$screen == CW_S_XS || cw::$screen == CW_S_SM}
							<div id="az_mouseOverZoomContainer">Loading Images...</div>
							<div id="az_mouseOverZoomGallery" class="az_horizontal">Loading Gallery...</div>
						{else}
							<div id="az_mouseOverZoomGallery" class="az_vertical">Loading Gallery...</div>
							<div id="az_mouseOverZoomContainerParentGalleryLeft">
								<div id="az_mouseOverZoomContainer" class="text-xs-center">Loading Images...</div>
							</div>
						{/if*}
						<div id="az_mouseOverZoomContainer">Loading Images...</div>
						<div id="az_mouseOverZoomGallery" class="az_horizontal">Loading Gallery...</div>
					</figure>
					<p class="text-xs-center"><a href="javascript:void(0);" data-pswp="0" class="f-s-10" ><i class="fa fa-image"></i> Start Slide Show</a></p>
                {else}
					<div id="pimg-slider" class="card card-white owl-theme-3">
					{foreach name="imgpswp" from=$arrImg key=k item=v}
						<figuar class="item">
							<a href="javascript:void(0);" data-pswp="{$k}">
								<img class="img-fluid" src="{$v.preview}" title="{$v.title}" alt="{$v.title}" />
							</a>
						</figuar>
					{/foreach}
					</div>
					<p class="text-xs-center"><a href="javascript:void(0);"><i class="fa fa-search-plus"></i> Click on image to zoom in</a></p>
				{/if}
            </div>
            {if isset($arrLFVInfo[ProductStyleGroup::obj()->Data[$smarty.const.F_P_KEY]]) && !empty($arrLFVInfo[ProductStyleGroup::obj()->Data[$smarty.const.F_P_KEY]])}
                {$TESGID = ProductStyleGroup::obj()->StyleGroupId('E',$arrLFVInfo[ProductStyleGroup::obj()->Data[$smarty.const.F_P_KEY]])}
            {/if}
			{if isset($LVT_ShowQRCodeArea) || isset($arrLFVInfo.product_busm_id) && isset($LVT_ShowSellerCodeArea)}
            <div class="col-xs-12 col-sm-6 col-md-5 col-lg-2 col-lg-push-7 col-xl-2 col-xl-push-6">
                {if isset($LVT_ShowQRCodeArea)}
                    <div class="card card-white">
    					<div class="card-block">
    						<div class="row pfv-qrc">
    							<img class="img-fluid" src="{$CDN_Url}/{QR_RW_URL}/0/L/3/1/?d={$Main_Host_Url}{$smarty.server.REQUEST_URI}" alt="QR Code">
    							<small>Scan QR code with any barcode/QR scanner application for quick access.</small>
    						</div>
    					</div>
    				</div>
                {/if}
                {if isset($arrLFVInfo.product_busm_id)}
                    <div class="card card-white pfv-seller">
                        {$img_path = Utility::obj()->dt_folder($arrLFVInfo.product_busm_dt_added)}
                        
                        {*foreach name='pro_img' from=$img_info key=id item=info}
                            {$_info = explode('|',$info)}
                            {if $_info[0] == $rsLP->f(ProductMaster::obj()->Data[$smarty.const.F_P_KEY])}
                                {$pimg_product_id[] =  $_info[0]}{$imgPath[] = Utility::obj()->dt_folder($_info[1])}{$image_id[] = $_info[2]|default:''}{$image_file[] = $_info[3]|default:''}{*$image_title[] = $_info[2]|default:''*}
                            {*/if}
                        {/foreach*}
                        {if isset($arrLFVInfo.product_busm_logo) && $arrLFVInfo.product_busm_logo != ''}
    					<div class="card-header">
    						<div class="row">
    							<a href="javascript:void(0);">
                                    <img class="img-fluid" src="{$MDN_Url}{$Business_IMG_RW_URL}/{BusinessMaster::obj()->EncodeDecodeBusinessId('E',$arrLFVInfo.product_busm_id)}/0/{IMAGE_SIZE_128X128}/2x{PRODUCT_IMAGE_QUALITY}/{$img_path}/{$arrLFVInfo.product_busm_logo|default:''}">
                                </a>
    						</div>
    					</div>
                        {/if}
    					<div class="card-block">
    						<div class="row">
    							<div class="text-xs-center"><small>By</small></div>
                                <div class="text-xs-center"><a href="javascript:void(0);"><b>{$arrLFVInfo.product_busm_name}</b></a></div>
    							{*<div class="score">
    								<label class="label label-info"><b>4.3</b>/5</label>
    								<small>Seller Score</small>
    							</div>
    							<div class="fullfilled">
    								<img src="images/logo-small2.png" alt="">
    								<span class="text-small">thatsend Fulfilled</span>
    							</div>
    							<div class="view-store clearfix">
    								<a class="pull-left" href="javascript:void(0);">&nbsp;View other Seller(5)</a>
    								<a class="pull-right" href="javascript:void(0);">View Store&nbsp;</a>
    							</div>*}
    						</div>
    					</div>
    					{*<div class="card-footer">
    						<div class="row">
    							<a href="javascript:void(0);">Wholesaleonly Guarantees</a>
    							<div>
    								<img src="images/Security-Checked.png" alt="">
    								<ul>
    									<li><a href="#">TrustPay: 100%</a></li>
    									<li><a href="#">Moneyback, 7 Days</a></li>
    									<li><a href="#">Easy Return Policy</a></li>
    								</ul>
    							</div>
    						</div>
    					</div>*}
    				</div>
                {/if}
            </div>
			{/if}
            <div class="col-xs-12 col-sm-12 col-md-12 {if isset($LVT_ShowQRCodeArea)}col-lg-7 col-lg-pull-2 col-xl-6 col-xl-pull-2{else}col-md-12 col-lg-9 col-xl-8{/if}">
                <div class="card card-white pfv-main">
					<div class="card-header">
						<div class="{if cw::$screen == CW_S_LG || cw::$screen == CW_S_XL}clearfix{else}row{/if}">
							<h1>{$arrLFVInfo[ProductMaster::obj()->Data[$smarty.const.F_P_FIELD]]}</h1>
							{if {$arrLFVInfo.product_second_line} != ''}<h2>{$arrLFVInfo.product_second_line}</h2>{/if}
						</div>
					</div>
                    <div class="card-block" data-ref-id="{Ocrypt::enc($arrLFVInfo[ProductMaster::obj()->Data[$smarty.const.F_P_KEY]])}" data-ref-type="{AREATE_ID_ECOM_RETAIL}">
                        <div class="{if cw::$screen == CW_S_LG || cw::$screen == CW_S_XL}clearfix{else}row{/if}">
    						<div class="clearfix">
    							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
    								{*<div class="row review">
    									<span data-star="3">
    										<i class="fa fa-star"></i>
    										<i class="fa fa-star"></i>
    										<i class="fa fa-star"></i>
    										<i class="fa fa-star"></i>
    										<i class="fa fa-star"></i>
    									</span>
    									<a href="#">(5 ratings) <i class="fa fa-play"></i> </a>
    								</div>*}
									{if isset($LVT_ShowSpecifications)}
    								<div class="row">
    									<a href="javascript:void(0);" rel="vid">View all details for item <i class="fa fa-play"></i></a>
    								</div>
									{/if}
    							</div>
    							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 pfv-b-action">
    								<div class="row">
    									<a href="javascript:void(0);" data-add-to-wish-list="true"><i class="fa fa-heart"></i><small> Add to Wishlist</small></a>
    									<a href="javascript:void(0);" data-add-to-compare="true"><i class="fa fa-clone"></i><small> Add to Compare</small></a>
    								</div>
    							</div>
    						</div>
                            <div class="clearfix pfv-require" data-ref-required="true">
                                {if isset($arrLFVInfo['product_required_feature']) && is_array($arrLFVInfo['product_required_feature'])}
                                    {if isset($arrUrlArgs[$smarty.const.QP_FEATURE]) && !empty($arrUrlArgs[$smarty.const.QP_FEATURE])}
                                        {foreach name='pro_ftr' from=$arrUrlArgs[$smarty.const.QP_FEATURE] key=fid item=finfo}
                                            {$SFTR[$fid] = $finfo[0]}
                                        {/foreach}
                                    {elseif is_array($arrPFList) && count($arrPFList) > 0}
                                        {foreach name='product_ftr' from=$arrPFList key=fid item=finfo}
    										{if $finfo.is === FEATUREIS_REQUIRED && $finfo.type === FEATURETYPE_REGULAR}
                                                {$SFTR[$fid] = key($finfo['list'])}
                                            {/if}
                                        {/foreach}
                                    {/if}
                                    {foreach name='pro_reqftr' from=$arrLFVInfo['product_required_feature'] key=fid item=finfo}
                                        {$tmprSFTR = $SFTR}
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                    		<div class="row">
                                                {block assign='reqftr' name='reqftr'}
                                                    {foreach from=$finfo['list'] key=fvk item=fvinfo}
                                                        {if array_key_exists($fid,$SFTR) && in_array($fvk,$SFTR)}
                                                            {$IsActive = true}{$sfval[$fid] = $fvk}
                                                        {/if}
                                                        {$a = end($SFTR)}
                                                        {*if isset($availableFeature) && key($availableFeature) == $fid *}
                                                        {if isset($availableFeature) && key($availableFeature) !=  key($SFTR)}
                                                            {if array_key_exists($fid,$availableFeature) && !in_array($fvk,$availableFeature[$fid])}{$disabled = true}{else}{$disabled = false}{/if}
                                                        {/if}
                                                        <li class="{if isset($IsActive) && $IsActive == true}active{/if} {if isset($disabled) && $disabled == true}disabled{/if}">
                                                            {$tmprSFTR.$fid = null}
                                                            {$tmprSFTR = array_filter($tmprSFTR)}
                                                            <a {if (isset($IsQuickView) && $IsQuickView == true) || (isset($disabled) && $disabled == true) || (count($SFTR) == count($arrLFVInfo['product_required_feature']) && isset($IsActive) && $IsActive == true)}href="JavaScript:void(0);" {if (!isset($disabled) || $disabled == false) && (!isset($IsActive) || $IsActive == null)}data-quick-view="true" data-ref-additional="{SURL_FULL_VIEW_PAGE}/{$TESGID}/{QP_FEATURE}/{if is_array($tmprSFTR) && count($tmprSFTR) > 0 && ((isset($IsActive) && $IsActive == true) || (isset($disabled) && $disabled == false))}{key($tmprSFTR)}[]{$tmprSFTR[key($tmprSFTR)]}*{/if}{$fid}[]{$fvk}"{/if}{else} href="{$Main_Host_Url}/{SU_ER_FULL_VIEW_PAGE}/{$TESGID}/{QP_FEATURE}/{if is_array($tmprSFTR) && count($tmprSFTR) > 0 && ((isset($IsActive) && $IsActive == true) || (isset($disabled) && $disabled == false))}{key($tmprSFTR)}[]{$tmprSFTR[key($tmprSFTR)]}*{/if}{$fid}[]{$fvk}"{/if} >
                                                                {if strpos(strtolower($finfo['title']),'color')!== false}
                                                                    {*<label title="{$fvinfo['title']}" style="background: {str_replace(' ','',$fvinfo['title'])}"></label>*}
                                                                    {$imgPath = Utility::obj()->dt_folder($fvinfo['p_adt'])}
                                                                    <img class="img-fluid" src="{$MDN_Url}{$ProductImg_IMG_RW_URL}/0/0/{PRODUCT_IMAGE_SIZE_32X32}/2x{PRODUCT_IMAGE_QUALITY}/{$imgPath}/{$fvinfo['img_file']|default:''}" alt="{$fvinfo['title']}" title="{$fvinfo['title']}" data-tooltip="true" data-placement="bottom" />
                                                                {else}
                                                                    <label>{$fvinfo['title']}</label>
                                                                {/if}
                                                            </a>
                                                        </li>
                                                        {$disabled = null}
                                                        {$IsActive = null}
                                                    {/foreach}
                                                    <input type="hidden" name="ref_required[{$fid}]" value="{if isset($sfval) && is_array($sfval) && count($sfval) > 0 && array_key_exists($fid,$sfval)}{$sfval[$fid]}{/if}">
                                                {/block}
                                                <strong>
                                    				{$finfo['title']}
                                                    {if isset($sfval) && is_array($sfval) && count($sfval) == count($finfo) && isset($arrPFList[$fid]['sub']) && $arrPFList[$fid]['sub'] != '' && isset($arrPFList[$arrPFList[$fid]['sub']]['list'])}
    												    <small> - {implode('/',$arrPFList[$arrPFList[$fid]['sub']]['list'])}</small>
                                                    {/if}
												</strong>
                                                <ul class="">
                                                    {$reqftr}
                                                </ul>
                                            </div>
                                        </div>    
                                    {/foreach}
                                    <input type="hidden" name="ref_required_total" value="{Ocrypt::enc(count($arrLFVInfo['product_required_feature']))}"/>                                    
                                {/if}
                            </div>
    						{*<div class="clearfix pfv-require" data-ref-required="true">
								{if is_array($arrPFList) && count($arrPFList) > 0}
                                    {foreach name='pro_ftr' from=$arrPFList key=fid item=finfo}
										{if $finfo.is === FEATUREIS_REQUIRED && $finfo.type === FEATURETYPE_REGULAR}
											<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
												<div class="row">
                                                    {if is_array($finfo.list) && count($finfo.list) > 0}
														{*if cw::$screen == CW_S_XS || cw::$screen == CW_S_SM}
															<strong>
																{$finfo['title']}
																{if $finfo.sub!='' && isset($arrPFList[$finfo.sub]['list'])}
																	<small> - {implode('/',$arrPFList[$finfo.sub]['list'])}</small>
																{/if} :
															</strong>
															<select class="form-control hidden-md-up required" id="ref_required[{$fid}]" name="ref_required[{$fid}]" data-msg-required="Please select {$fid}">
																<option value="" selected="selected">- select -</option>
																{html_options options=$finfo['list']|default:'' selected=''}
															</select>
														{else}

														{/if*}
														{*foreach name='pro_ftrv' from=$finfo['list'] key=fvid item=fvinfo}
															<strong>
																{$finfo['title']}
																{if $finfo.sub!='' && isset($arrPFList[$finfo.sub]['list'])}
																	<small> - {implode('/',$arrPFList[$finfo.sub]['list'])}</small>
																{/if} :
															</strong>
															<ul class="">
																<li class="active">
																	{if strpos(strtolower($fid),'color')!==false}
																	   <a href="javascript:void(0);"><label title="{$fvinfo}" style="background: {str_replace(' ','',$fvinfo)}">&nbsp;</label></a>
																	{else}
																		<a href="javascript:void(0);"><label>{$fvinfo}</label></a>
																	{/if}
																</li>
															</ul>
														{/foreach}
													{/if}
												</div>
											</div>
										{/if}
									{/foreach}
								{/if}
    						</div>*}
    						<div class="clearfix">
    							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
    								<div class="row pfv-price text-xs-center text-sm-left ">
    									<ins>{$config.site_currency_symbol} {number_format($arrLFVInfo.product_selling_price)}</ins>
    									<s>{$config.site_currency_symbol} {number_format($arrLFVInfo.product_max_retail_price)}</s>
                                        {if $arrLFVInfo.product_discount > 0}
    									<span class="alert-2">{number_format($arrLFVInfo.product_discount)}% OFF</span>
                                        {/if}
    									{*<strong><i class="fa fa-inr"></i> 1998</strong>*}
    								</div>
    							</div>
    							<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pfv-points">
                                    {*if $arrLFVInfo.product_cm_safe_url != ''}
                                        {$arrCat = explode(',',$arrLFVInfo.product_cm_safe_url)}
                                        {$arrCatName = explode(',',$arrLFVInfo.product_cm_name)}
                                    {/if*}
                                    <div class="row">
    									<ul>
    										<li><b>SKU : </b> {if (isset($IsQuickView) && $IsQuickView == true)}<a title="{$arrLFVInfo[ProductMaster::obj()->Data[$smarty.const.F_P_FIELD]]}" href="{$Main_Host_Url}/{SU_ER_FULL_VIEW_PAGE}/{$TESGID}/{SURL_FVP_ITEM}/{ProductMaster::obj()->SystemSKU('E',$arrLFVInfo[ProductMaster::obj()->Data[$smarty.const.F_P_KEY]])}/{SURL_FVP_ITEM_URL}/{$arrLFVInfo[ProductMaster::obj()->Data[$smarty.const.F_S_URL]]}" target="{rla::obj()->HL_TARGET}">{ProductMaster::obj()->SystemSKU('E',$arrLFVInfo[ProductMaster::obj()->Data[$smarty.const.F_P_KEY]])} <i class="fa fa-external-link" title="{$arrLFVInfo[ProductMaster::obj()->Data[$smarty.const.F_P_FIELD]]}"></i></a>{else}{ProductMaster::obj()->SystemSKU('E',$arrLFVInfo[ProductMaster::obj()->Data[$smarty.const.F_P_KEY]])}{/if}</li>
    										<li><b>Inside : </b><a rel="index" target="{rla::obj()->HL_TARGET}" href="{$Main_Host_Url}/{SU_ER_LISTING_PAGE}/{QP_CATEGORY}/{$arrLFVInfo.product_cm_safe_url}">{$arrLFVInfo.product_cm_name} <i class="fa fa-external-link" title="View more"></i></a></li>
    										<li><b>Availability : </b><small>{if $arrLFVInfo.product_enable_inquiry == YES || $arrLFVInfo.product_quantity <= '0'}Not Available{else}In Stock{/if}</small></li>
                                            <li><b>MOQ : </b>{$arrLFVInfo.product_min_order_qty}</li>
    									</ul>
    								</div>
    							</div>
    						</div>
    						<div class="clearfix">
    							<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 col-xl-5">
    								<div class="row pfv-action">
                                        {if $arrLFVInfo.product_quantity > 0 && $arrLFVInfo.product_enable_purchase == YES && $arrLFVInfo.product_quantity >= $arrLFVInfo.product_min_order_qty}
    									   	<button type="button" data-buy-now="true" class="btn btn-success btn-icon-stacked" title=""  data-tooltip="true"><i class="fa fa-shopping-bag"></i>&nbsp; BUY NOW</button>
    										<button type="button" data-add-to-cart="true" class="btn btn-info btn-icon-stacked" title=""  data-tooltip="true"><i class="fa fa-shopping-cart"></i>&nbsp; ADD TO CART</button>
                                        {else}
                                             <div class="stock-out-1"><i class="fa fa-ban fa-2x text-danger"></i> <br/><span>Out of Stock</span></div>
                                        {/if}
    									{if $arrLFVInfo.product_enable_inquiry == YES || $arrLFVInfo.product_quantity < $arrLFVInfo.product_min_order_qty}
                                            <button type="button" {if !isset($IsUserLogged) || $IsUserLogged != STATUS_ONLINE}data-toggle="modal" data-target="#site-contact-us"{/if} data-send-enquiry="true" class="btn btn-warning btn-icon-stacked"><i class="fa fa-paper-plane"></i>&nbsp; SEND ENQUIRY</button>
                                        {/if}
    								</div>
    							</div>
    							<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7 col-xl-7 pfv-offer">
    								<div class="col-md-12">
                                        {if $arrLFVInfo.product_discount >= 40}
        									<div class="offer-box">
        										<div class="inner-box">
        											<div class="inner-patch">
        												<a href="{$Main_Host_Url}/{SU_ER_LISTING_PAGE}/{QP_CATEGORY}/{$arrLFVInfo.product_cm_safe_url}/{QP_DISCOUNT}/{number_format($arrLFVInfo.product_discount)}">DISCOUNT : {number_format($arrLFVInfo.product_discount)}% OFF</a>
        											</div>
        										</div>
        										<div class="left-circle"></div>
        										<div class="right-circle"></div>
        									</div>
                                        {/if}
    								</div>
    							</div>
    						</div>
                            {if isset($LFV_ShowSDesc) && $arrLFVInfo.product_short_desc != ''}
    						<div class="clearfix">
    							<div class="col-md-12">
                                    <div class="row"><p class="m-a-0 text-justify">{$arrLFVInfo.product_short_desc}</p></div>
                                </div>
    						</div>
                            {/if}
                        </div>
					</div>
                </div>
            </div>
        </div>
		{if isset($LFV_ShowSP) && $rsRP->TotalRow > 0}
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<h5 class="h5-title-sm">Other Similar Products</h5>
				<div class="card card-white">
					<div class="card-block p-y-0">
						<div class="row">
							<div id="prf-similar" data-is-slider="true" data-lvt-prc="g" class="col-md-12 col-lg-12 p-x-0 owl-theme-1">
								{include file='tpl_er_lp/er-lp-listing-view.tpl' InSlider=true rsLP=$rsRP PR_ColClass='item' PR_HideQty=true PR_HideSku=true}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		{/if}
		{if isset($LVT_ShowSpecifications)}
        <div id="vid" class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<h5 class="h5-title-sm">Specifications of {$arrLFVInfo[ProductMaster::obj()->Data[$smarty.const.F_P_FIELD]]}</h5>
				<div class="card card-white pfv-details">
					<div class="card-block">
						<div class="table-responsive">
							<table class="table">
								<tbody>
									{if is_array($arrPFList) && count($arrPFList) > 0}
										{foreach from=$arrPFList key=fid item=finfo}
											{if $finfo.is !== FEATUREIS_REQUIRED && $finfo.type === FEATURETYPE_REGULAR}
												{$arrPFListByGroup[$finfo.group][$fid] = $finfo}
											{/if}
										{/foreach}
										{foreach from=$arrPFListByGroup key=gname item=gfinfo}
											{*<tr><td colspan="4" class="f-s-16 bg-gray98">{$gname}</td></tr>*}
											{foreach name='fbygroup' from=$gfinfo key=id item=info}
												<tr>
													<td width="30%" class="border-right text-xs-right">{$info.title}</td>
													<td width="70%">
														{if isset($info.ans) && $info.ans != ''}
															{if strpos($info.ans,'::')===false}
																{$info.ans}
															{else}
																{$ans = explode('::',$info.ans)}
																{implode(', ',$ans)}
															{/if}
														{elseif isset($info.list) && $info.list != ''}
															{implode(',',$info.list)}
														{/if}
													</td>
												</tr>
											{/foreach}
											{*<tr>
												{$i=1}
												{foreach name='fbygroup' from=$gfinfo key=id item=info}
													{if $i==3}{$i=1}</tr><tr>{/if}
													<td width="15%" class="border-right text-xs-right">{$info.title}</td>
													<td width="35%">
														{if isset($info.ans) && $info.ans != ''}
															{if strpos($info.ans,'::')===false}
																{$info.ans}
															{else}
																{$ans = explode('::',$info.ans)}
																{implode(', ',$ans)}
															{/if}
														{else}
															{implode(',',$info.list)}
														{/if}
													</td>
													{if $smarty.foreach.fbygroup.index + 1 == count($gfinfo) && $i!=2}
														<td colspan="2"></td>
													{/if}
													{$i=$i+1}
												{/foreach}
											</tr>*}
										{/foreach}
									{/if}
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
        </div>
		{/if}
        {if (isset($LFV_ShowFDesc) && $arrLFVInfo.product_full_desc != '') || (isset($rsAddImages) && $rsAddImages->TotalRow > 0)}
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<h5 class="h5-title-sm">About {$arrLFVInfo[ProductMaster::obj()->Data[$smarty.const.F_P_FIELD]]}</h5>
				<div class="card card-white">
					<div class="card-block">
						{if isset($LFV_ShowFDesc) && $arrLFVInfo.product_full_desc != ''}
							<p class="m-a-0 text-justify">{$arrLFVInfo.product_full_desc}</p>
                        {/if}
						{if isset($rsAddImages) && $rsAddImages->TotalRow > 0}
                            {while $rsAddImages->next_record()}
                                <figure>
                                    {$imgPath = Utility::obj()->dt_folder($rsAddImages->f(ProductMaster::obj()->Data[$smarty.const.F_ADDED_DATETIME]))}
                                    <img class="img-fluid lzl" data-lzl="{$MDN_Url}{$ProductAddImg_IMG_RW_URL}/0/0/0x0/2x{PRODUCT_IMAGE_QUALITY}/{$imgPath}/{$rsAddImages->f('paddimg_image_file')}" alt="" />
                                </figure>
                            {/while}
                        {/if}
					</div>
				</div>
            </div>
        </div>
		{/if}
		{if isset($LVT_ShowNotice)}
		<div class="row">
			<div class="col-md-12">
				<p class="text-justify"><small class="small text-muted"><i class="fa fa-info-circle"></i> Any information in written or in image/photo can be little different or can have some changes in real. Images are only representative. Due to various types of lightings and flash used while photo shoot, the color shade of the product may vary. The brightest shade seen is the closest colour of the product. Designs and patterns on the actual product may slightly vary from designs shown in the image. Some accessory shown in image might not found in product box as it is just for demonstration purpose.</small></p>
			</div>
		</div>
		{/if}
        {if isset($LVT_ShowQuickLinks)}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
				<h5 class="h5-title-sm">Quick Links</h5>
				<div class="card card-white">
					<div class="card-block">
						<div class="row">
							<ul class="quick-links">
                                {*<li class="col-xs-12 col-sm-6 col-md-6 col-lg-3 col-xl-4">
									<span>Brand : </span>
									<a target="{rla::obj()->HL_TARGET}" href="{$Main_Host_Url}/{SU_ER_LISTING_PAGE}/{QP_CATEGORY}/{$arrLFVInfo.product_cm_safe_url}/{QP_BRAND}/{$arrLFVInfo[ProductMaster::obj()->Data[FIELD_PREFIX]|cay:BrandMaster::obj()->Data[F_S_URL]]}">
										{$arrLFVInfo[ProductMaster::obj()->Data[FIELD_PREFIX]|cat:BrandMaster::obj()->Data[F_P_FIELD]]} <i class="fa fa-angle-right"></i>
                                    </a>
								</li>*}
                                {if is_array($arrPFList) && count($arrPFList) > 0}
                                    {foreach name='pro_ftr' from=$arrPFList key=fid item=finfo}
										{if $finfo.search === YES && $finfo.type === FEATURETYPE_REGULAR && isset($finfo.list) && is_array($finfo.list)}
											{foreach from=$finfo.list key=fvalid  item=fvalInfo}
												<li class="col-xs-12 col-sm-6 col-md-6 col-lg-3 col-xl-4">
													{$url_addi=''}{$title_addi=''}
													{if $finfo.sub!='' && isset($arrPFList[$finfo.sub]['list'])}
														{$url_addi='*'|cat:$finfo.sub|cat:'[]'}
														{$url_addi = $url_addi|cat:implode('|',array_keys($arrPFList[$finfo.sub]['list']))}
														{$title_addi = '<small> - '|cat:implode('/',$arrPFList[$finfo.sub]['list'])|cat:'</small>'}
													{/if}
													<span>{$finfo['title']}{$title_addi} : </span>
													<a target="{rla::obj()->HL_TARGET}" href="{$Main_Host_Url}/{SU_ER_LISTING_PAGE}/{QP_CATEGORY}/{$arrLFVInfo.product_cm_safe_url}/{QP_FEATURE}/{$fid}[]{$fvalid}{$url_addi}">
														{$fvalInfo} {$arrLFVInfo.product_cm_name} <i class="fa fa-angle-right"></i>
													</a>
												</li>
											{/foreach}
										{/if}
                                    {/foreach}
                                {/if}
							</ul>
						</div>
                        {if is_array($arrPTagList) && count($arrPTagList) > 0}
                            <div class="row b-dotted-t m-t-1 p-t-1">
                                <ul class="quick-links">
                                    {foreach name='pro_tag' from=$arrPTagList key=tid item=tinfo}
                                    {*$a = rand(1,20)*}
                                    <li class="col-xs-12 col-sm-6 col-md-6 col-lg-3 col-xl-4">
                                        <a target="{rla::obj()->HL_TARGET}" href="{$Main_Host_Url}/{SU_ER_LISTING_PAGE}/{QP_CATEGORY}/{$arrLFVInfo.product_cm_safe_url}/{QP_TAG}/{$tinfo[TagMaster::obj()->Data[$smarty.const.F_P_KEY]]}">
                                            {$tinfo[TagMaster::obj()->Data[$smarty.const.F_P_FIELD]]} <i class="fa fa-angle-right"></i>{*&nbsp;{str_repeat('&nbsp;',$a)*}
    									</a>
                                    </li>
                                    {/foreach}
                                </ul>
                            </div>
                        {/if}
					</div>
				</div>
			</div>
		</div>
		{/if}
        <div class="row">
			{if  isset($LFV_ShowWL) && is_object($rsUW) && $rsUW->TotalRow > 0}
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
					<h5 class="h5-title-sm">My Wishlist</h5>
					<div class="card card-white">
						<div class="card-block p-y-0">
							<div class="row">
								<div data-is-slider="true" data-lvt-prc="g" class="col-md-12 col-lg-12 p-x-0 owl-theme-1 prf-otherlist">
									{if AuthUser::obj()->User_Logged === STATUS_ONLINE  && AuthUser::obj()->User_Perm == USER}
                                        {include file='tpl_er_lp/er-lp-listing-view.tpl' rsLP=$rsUW total_record=$rsuw_total_record PR_ColClass='item' PR_HideSku=true PR_HideDiscount=true InSlider=true}
                                    {else}
                                        {if isset($smarty.cookies.COOKIE_TE_WL) && $smarty.cookies.COOKIE_TE_WL != ''}
                                            {$p_l_info = $rsUW->fetch_record(PDO_FETCH_ALL,PDO_FETCH_ASSOC,ProductMaster::obj()->Data[$smarty.const.F_P_KEY])}

                                            {$wishlist_product = (unserialize(base64_decode($smarty.cookies.COOKIE_TE_WL)))}
                                            {$wl_product = array_reverse($wishlist_product[$smarty.const.AREATE_ID_ECOM_RETAIL], true)}

                                            {foreach name=Wl_Cookie from=$wl_product  key=id item=value}
                                                {$p_id = Ocrypt::ndec($id)}
                                                {if isset($p_l_info[$p_id])}
                                                    {$rs->set_record($p_l_info[$p_id])}
                                                    {include file='tpl_er_lp/er-lp-item.tpl' rsLP=$rs PR_ColClass='item' PR_HideSku=true PR_HideDiscount=true InSlider=true}
                                                {/if}
                                            {/foreach}
                                        {/if}
                                    {/if}
								</div>
							</div>
						</div>
					</div>
				</div>
			{/if}
			{if  isset($LFV_ShowRV) && is_object($rsURV) && $rsURV->TotalRow > 0}
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 ">
					<h5 class="h5-title-sm">Recently Visited</h5>
					<div class="card card-white">
						<div class="card-block p-y-0">
							<div class="row">
								<div data-is-slider="true" data-lvt-prc="g" class="col-md-12 col-lg-12 p-x-0 owl-theme-1 prf-otherlist">
									{if AuthUser::obj()->User_Logged === STATUS_ONLINE  && AuthUser::obj()->User_Perm == USER}
                                        {include file='tpl_er_lp/er-lp-listing-view.tpl' rsLP=$rsURV total_record=$rsurv_total_record PR_ColClass='item' PR_HideSku=true PR_HideDiscount=true InSlider=true }
                                    {else}
                                        {if isset($smarty.cookies.COOKIE_TE_RV) && $smarty.cookies.COOKIE_TE_RV != ''}
                                            {$p_l_info = $rsURV->fetch_record(PDO_FETCH_ALL,PDO_FETCH_ASSOC,ProductMaster::obj()->Data[$smarty.const.F_P_KEY])}

                                            {$rv_product = (unserialize(base64_decode($smarty.cookies.COOKIE_TE_RV)))}
                                            {$rvl_product = array_reverse($rv_product[$smarty.const.AREATE_ID_ECOM_RETAIL], true)}

                                            {foreach name=RV_Cookie from=$rvl_product  key=id item=value}
                                                {$p_id = Ocrypt::ndec($id)}
                                                {if isset($p_l_info[$p_id])}
                                                    {$rs->set_record($p_l_info[$p_id])}
                                                    {include file='tpl_er_lp/er-lp-item.tpl' rsLP=$rs PR_ColClass='item' PR_HideSku=true PR_HideDiscount=true InSlider=true }
                                                {/if}
                                            {/foreach}
                                        {/if}
                                    {/if}
                                </div>
							</div>
						</div>
					</div>
				</div>
			{/if}
        </div>
    </div>
</div>