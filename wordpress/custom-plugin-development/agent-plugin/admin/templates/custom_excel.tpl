<table border="1" cellpadding="0" cellspacing="1" width="100%" bordercolor="#000000">
	<tbody id="the-list">
	<tr>
		{foreach name=HeaderInfo from=$F_HeaderItem item=Header}
			<td bgcolor="#DDDDDD"><b>{$Header}</b></td>
		{/foreach}
	</tr>
	{if $total_record > 0}
		{assign var=i value=1}
		{foreach $rsUser as $record}
			<tr>
				<td width="12%">{$record['user_first_name']} {$record['user_last_name']}</td>
				<td width="10%">{$record['user_email']}</td>
				<td width="10%">{$record['user_phone']}</td>
				<td width="10%">{if $record['user_id'] == 0}Unregistered{else}Registered{/if}</td>
			</tr>
			{capture assign=i}{$i+1}{/capture}
		{/foreach}
	{else}
		<tr class="alt"><td colspan="5">No Data Found.</td></tr>
	{/if}
	</tbody>
</table>