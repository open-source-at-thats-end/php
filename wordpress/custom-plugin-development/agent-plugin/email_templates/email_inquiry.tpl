<table align="center" width="50%" border="0" cellspacing="5" cellpadding="0" style="margin-top: 10px;" align="center">
    <tr height="10">
        <td></td>
    </tr>
    <tr>
        <td colspan="2" style="color:#000; text-align:left; font-size:1em; font-weight:700">Dear <font color="#094B6B">Sir/Madam</font></td>
    </tr>
    <tr>
        <td colspan="2"><strong>Inquiry has been received for MLS Number# {$Record.MLS_NUM}.</strong></td>
    </tr>
    <tr>
        <td width="44%">&nbsp;</td>
        <td width="56%">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2"><font color="#094B6B">User Details :</font></td>
    </tr>
    <tr>
        <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Name :</strong></td>
        <td>{$frmData.lead_first_name|lower|ucwords} {$frmData.lead_last_name|lower|ucwords}</td>
    </tr>
    {if $frmData.lead_home_phone != ''}
        <tr>
            <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Phone :</strong></td>
            <td>{$frmData.lead_home_phone}</td>
        </tr>
    {/if}
    {if $frmData.lead_work_phone != ''}
        <tr>
            <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Work Phone :</strong></td>
            <td>{$frmData.lead_work_phone}</td>
        </tr>
    {/if}
    {if $frmData.lead_mobile != ''}
        <tr>
            <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Mobile :</strong></td>
            <td>{$frmData.lead_mobile}</td>
        </tr>
    {/if}
    <tr>
        <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Email :</strong></td>
        <td>{$frmData.lead_email}</td>
    </tr>
    <tr>
        <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Comments :</strong></td>
        <td>{$frmData.lead_comment|nl2br}</td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr>
        <td colspan="2"><font color="#094B6B">Property Details :</font></td>
    </tr>
	<tr>
		<td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Address :</strong></td>
		<td>{$Record.StreetNumber} {$Record.StreetName}</td>
	</tr>
	<tr>
		<td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>City :</strong></td>
		<td>{$Record.CityName}</td>
	</tr>
	<tr>
		<td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>County :</strong></td>
		<td>{$Record.County}</td>
	</tr>
	<tr>
		<td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>State :</strong></td>
		<td>{$Record.State}</td>
	</tr>
	<tr>
		<td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Price :</strong></td>
		<td>{*{$Config.site_currency}*}{$site_currency}{$Record.ListPrice|number_format:0}</td>
	</tr>
	{*<tr>
		<td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Listing Agent :</strong></td>
		<td>{$Record.Agent_FullName|lower|ucwords}</td>
	</tr>*}
	<tr>
		<td width="44%">&nbsp;</td>
		<td width="56%">&nbsp;</td>
	</tr>

</table>