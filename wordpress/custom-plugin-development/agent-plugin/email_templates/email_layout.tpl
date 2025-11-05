<!DOCTYPE HTML>
<meta http-equiv="content-type" content="text/html" />
<meta name="author" content="" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"/>
<head>
	<meta name="lead_information_version" content="1.0" />
	<meta name="lead_name"   content={$user_name|replace:'_':' '|lower|ucwords} />
	<meta name="lead_email"  content={$user_email} />
	<meta name="lead_phone"  content={$user_pass} />
	<meta name="lead_source"  content={$RegistrationPage} />
</head>
{if isset($Host_Url)}
<link rel='stylesheet' id='chld_thm_cfg_parent-css'  href='{$Host_Url}/wp-content/themes/Divi-2/style.css' type='text/css' media='all' />
{/if}

{literal}
	<style type="text/css">
	.stdEmail tr td {
		font-family:Arial, Helvetica, sans-serif;
		font-size:9pt;
		color:#333
	}
	.border, .border td, .border th	{ border:1px solid #efefef; padding:0.5em }
	body{width: 100%; height: 100%; margin:0; padding:0; -webkit-font-smoothing: antialiased;}
	html{width: 100%; }
	</style>
	<style type="text/css">
		/*.stdEmail tr td {
			font-family:Arial, Helvetica, sans-serif;
			font-size:9pt;
			color:#333
		}
		.border, .border td, .border th	{ border:1px solid #efefef; padding:0.5em }*/
	</style>

	<style type="text/css"> @media only screen and (max-width: 479px){
			body{width:auto!important;  }
			table[class=full] {width: 100%!important; clear: both; }
			table[class=mobile] {width: 100%!important; clear: both; }
			table[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; }
			td[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; }
			.td-responsive{width:100%;display: block}
		}
	</style>
	<style type="text/css"> @media only screen and (max-width: 640px){
			body{width:auto!important;}
			table[class=full] {width: 100%!important; clear: both; }
			table[class=mobile] {width: 100%!important; clear: both; }
			td[class=mobile] {width: 100%!important; clear: both; }
			table[class=fullCenter] {width:100%!important; text-align: center!important; clear: both; }
			td[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; }
		} </style>
	<style type="text/css">@media screen and (max-width: 1024px) and (min-width: 768px) {
			body{width:auto!important; }
			table[class=full] {width: 100%!important; clear: both; }
			td[class=mobile] {width: 100%!important; clear: both; }
			table[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; }
			td[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; }
		} </style>
	<style type="text/css">@media screen and (max-width: 1366px) and (min-width: 1024px) {
			body{width:auto!important;  }
			table[class=full] {width: 100%!important; clear: both; }
			td[class=mobile] {width: 100%!important; clear: both; }
			table[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; }
			td[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; }
		} </style>
	<style type="text/css">@media screen and (max-width: 1024px) and (min-width: 1024px) {
			body{width:auto!important;  }
			table[class=full] {width: 100%!important; clear: both; }
			td[class=mobile] {width: 100%!important;  clear: both; }
			table[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; }
			td[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; }
		} </style>
{/literal}
<div class="wrapper" style="width: 100%;margin: 0 auto;font-size: 15px; font-style: normal;">
	{include file="$Email_Header"}
	<table class="full" cellpadding="0" cellspacing="0" width="100%" height="100%" align="center" border="0">
		<tr>
			<td>
				{if $isContent === true}
					<br />
					{$Email_Body}
				{else}
					{include file="$Email_Body"}
				{/if}
				<br />&nbsp;
			</td>
		</tr>
	</table>

		{if isset($Email_Footer)}
		{include file="$Email_Footer"}
	{/if}
</div>
