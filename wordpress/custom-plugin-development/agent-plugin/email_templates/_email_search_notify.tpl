{if $arrListing.total_record > 0}
<table width="100%" align="center" style="/*background: #fff;*/padding: 15px;width: 650px;">
	<tr>
		<td class="logo250" style="text-align: center; line-height: 1px;width: 100%;border-bottom:1px solid #e6e6e6; padding: 5px;">
			<img src="{$AgentInfo['agent_print_photo']}" style="/*width: 300px;*/ height: 43px;border-bottom: 1px solid #f2f2f2;"/>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<div style="padding-bottom: 6px;padding-top: 22px">Hi {if isset($user_name)}{$user_name|replace:'_':' '|ucfirst},{/if}</div>
			<div>Check out the newest activity for <strong>{$recSearch['search_title']|ucfirst}.</strong></div>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: center">
			<h2 style="margin-bottom: 10px;">Newest Listings</h2>
		</td>
	</tr>
	{foreach from=$arrListing.rs key=Num item=Record}
		{assign var="rsAttributes" value=Utility::obj()->generateListingAttributes($Record)}
		<tr>
			<td width="50%" class="td-responsive -bg-color" style="padding-bottom: 30px;">
{*				<a href="{$host_url}/{$rsAttributes.SFUrl}" style="background: linear-gradient(to bottom, rgba(0,0,0,0.1) 0%,rgba(0,0,0,0.6) 100%);top: 0%;left: 0;right: 0;bottom: 0;height: 268px;position: relative;color: #fff;box-shadow: none;overflow: hidden;display: block;">*}
				<div style="color: #585858;box-shadow: none;overflow: hidden;display: block;text-decoration: none;background: #fff;">
					<a href="{$host_url}/{$rsAttributes.SFUrl}" style="color: #585858;box-shadow: none;overflow: hidden;display: block;text-decoration: none;background: #fff;">
						{if $Record.mls_is_pic_url_supported == 'Yes'}

							{assign var=photo_url value=$Record.MainPicture.large.url}

							{if $photo_url != ''}
								<img src="{$photo_url}" alt="{if isset($imgAlt)}{$imgAlt}{else}MLS# {$Record.MLS_NUM}{/if}" width="100%" style="min-height: 350px;max-height: 350px;width: 100%;"/>
							{else}
								<img src="{$PhotoBaseUrl}no-photo/0/" alt="{if isset($imgAlt)}{$imgAlt}{else}MLS# {$Record.MLS_NUM}{/if}" width="100%" style="min-height: 350px;max-height: 350px;max-width: 100%;height: auto; !important;"/>
							{/if}
						{else}
							<img src="{$Record.MainPicture}" alt="{if isset($imgAlt)}{$imgAlt}{else}MLS# {$Record.MLS_NUM}{/if}" width="100%" style="min-height: 350px;max-height: 350px;max-width: 245%;height: auto; !important;"/>
						{/if}
						{*					<div style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0.05) 0%, rgba(0, 0, 0, 0.35) 100%);z-index: 99;position: absolute !important;bottom: 0;top: 0;right: 0;left: 0;">*}
						<div style="padding: 10px;">
							{*						<div style="position: absolute !important;bottom: 0;right: 0;left: 0;padding: 8px;">*}
							<div style="padding: 8px;">
								<div class="te-property-details-price" style="font-size: 16px;font-weight: 700;color: #000;">{$currency}{$Record.ListPrice|number_format:'0'}</div>
								<div class="te-property-details-features te-font-size-14" style="font-size: 16px;font-weight: 700;">{if isset($Record.Beds) && $Record.Beds > 0 }{$Record.Beds}{else}0{/if} Beds, {if isset($Record.Baths) && $Record.Baths > 0}
										{rtrim(rtrim($Record.Baths,'0'),'.')}{else}0{/if} Baths, {if isset($Record.SQFT) && $Record.SQFT != ''}{$Record.SQFT|number_format:'0'} {else} 0 {/if} Sq Ft</div>
								<div class="te-property-title text-truncate te-font-size-14" style="font-size: 16px;font-weight: 700;color: #0261df;">{if $rsAttributes.AddressFull != ''}{$rsAttributes.AddressFull}{/if}</div>
							</div>

						</div>
					</a>
					<div style="padding: 14px;text-align: center;">
						<div style="background: #f5f5f5; padding: 10px;">
							<a href="{$host_url}/{$rsAttributes.SFUrl}" style="color: #3c3b3b;text-decoration: none;">
								View Details
							</a>
						</div>
					</div>
				</div>
			</td>
			{*<td width="65%" valign="top" class="pd-sm-5 td-responsive" style="padding-bottom: 10px">
				<table style="background-color: #DBDBDB;height:110px;padding-left:5px;font-size: 15px;" width="100%">
					{if $rsAttributes.AddressSmall != ''}
						<tr>
							<td>
								<a href="{$host_url}/{$rsAttributes.SFUrl}"><div> {$rsAttributes.AddressSmall}</div></a>
							</td>
						</tr>
					{/if}
					{if $Record.CityName != '' || $Record.State != '' || $Record.State != ''}
						<tr>
							<td>
								<div>{if isset($Record.CityName)}{$Record.CityName},&nbsp;{/if}{if isset($Record.State)}{$Record.State} - {/if}{$Record.ZipCode} </div>
							</td>
						</tr>
					{/if}
					<tr>
						<td>
							<div>
								<span style="font-family: ElegantIcons;">
									<span style="font-weight:bold;font-size:14px;">

									</span>
									<span style="font-size:14px;">
										| {if isset($Record.Beds) && $Record.Beds > 0 }{$Record.Beds}{else}0{/if} Beds | {if isset($Record.Baths) && $Record.Baths > 0}
											{rtrim(rtrim($Record.Baths,'0'),'.')}{else}0{/if} Baths | {if isset($Record.SQFT) && $Record.SQFT != ''}{$Record.SQFT} {else} 0 {/if} Sq Ft
									</span>
								</span>
							</div>
						</td>
					</tr>
				</table>
			</td>*}
		</tr>
	{/foreach}
	<tr>
		<td  style="padding-bottom: 25px;text-align: center;" colspan="2"><a href="{$host_url}/{$recSearch['search_page_slug']}/{if isset($recSearch['search_url']) && $recSearch['search_url'] != ''}?{$recSearch['search_url']}{/if}" style="padding: 10px; font-weight: 600; font-family: sans-serif; color: rgb(255, 255, 255); background-color:#0261df; text-decoration: none; padding-left: 20px; padding-right: 20px; font-weight: normal; font-size: 14px;">VIEW ALL {$countNew|number_format:'0'} MATCHING PROPERTIES</a></td>
	</tr>

	<tr>
		<td>
			<table width="100%">
				<tr>
					<td width="30%" class=" bg-color">
						{if isset($AgentInfo) && $AgentInfo['agent_photo'] != ''}
							<img src="{$AgentInfo['agent_photo']}" alt="{$AgentInfo['agent_name']}" width="100%" style="box-shadow: 0 0 5px #d8d8d8;height: 170px;"/>
						{else}
							<img src="{$AgentImgUrl}agent-placeholder.jpg" alt="{$AgentInfo['agent_name']}" width="100%" style="box-shadow: 0 0 5px #d8d8d8;height: 170px;"/>
						{/if}
					</td>
					<td width="70%" valign="top" class="pd-sm-5 " style="background-color: #DDD;">
						<table style="height:170px;padding-left:16px ;" width="100%">
							<tr>
								<td>
									<div style="">
										<strong>{$AgentInfo['agent_name']|capitalize}</strong>
									</div>
									<div>{if isset($AgentInfo['agent_about']) && $AgentInfo['agent_about'] != ''}<span>{$AgentInfo['agent_about']}</span>{/if}</div>
									<div style="padding-top: 25px;">
										{if isset($AgentInfo['agent_email']) && $AgentInfo['agent_email'] != ''}<div>{$AgentInfo['agent_email']}</div>{/if}
										{if isset($AgentInfo['agent_phone']) && $AgentInfo['agent_phone'] != ''}<div>{$AgentInfo['agent_phone']}</div>{/if}
										{if isset($AgentInfo['agent_address']) && $AgentInfo['agent_address'] != ''}<div>{$AgentInfo['agent_address']}</div>{/if}
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>

	</tr>
	<tr>
		<td>
			<div style="text-align: center;padding-top: 10px;">
				<span>We respect your privacy. </span><a style="text-decoration: none;" href="{$login_url}">Manage your email preferences.</a>
			</div>
		</td>
	</tr>

</table>
{*	<table width="70%" style="text-align: center" class="full">

	</table>*}
{/if}