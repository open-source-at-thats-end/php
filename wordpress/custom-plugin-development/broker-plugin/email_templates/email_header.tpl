{if (isset($logo) && $logo != '') || (isset($title) && $title != '') }
	<table align="center" width="100%" class="full" {*style="background-color: #676767;"*}>
		<tr style="/*padding:5px 10px; text-align:center;*//*background-color: #676767;*/">
			<td class="logo250-" style="text-align: center; line-height: 1px;width: 100%;/*border-bottom:1px solid #ccc; padding: 5px;*/">
				{if isset($logo) && $logo != ''}
					<img src="{$uploadPath}{$logo}" style="width: 300px;height:auto;border-bottom: 1px solid #f2f2f2;"/>
				{elseif $title != ''}
					<h1> {$title} </h1>
				{/if}

			</td>
		</tr>
	</table>
{/if}