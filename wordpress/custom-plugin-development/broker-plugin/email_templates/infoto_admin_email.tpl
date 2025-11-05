<table align="center" width="50%" border="0" cellspacing="5" cellpadding="0" style="margin-top: 10px;" align="center">
    <tr height="10">
        <td></td>
    </tr>
    <tr>
        <td colspan="2" style="color:#000; text-align:left; font-size:1em; font-weight:700">Dear <font color="#094B6B">Sir/Madam</font></td>
    </tr>
    <tr>
        <td colspan="2"><strong>{$Subject}.</strong></td>
    </tr>
    <tr>
        <td width="44%">&nbsp;</td>
        <td width="56%">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2"><font color="#094B6B">Agent Details :</font></td>
    </tr>
    <tr>
        <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Name :</strong></td>
        <td>{$frmData.email_to_agtname|lower|ucwords}</td>
    </tr>
    <tr>
        <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Email :</strong></td>
        <td>{$frmData.email_to_agent}</td>
    </tr>
    {if $frmData.email_to_agtphone != ''}
        <tr>
            <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Mobile :</strong></td>
            <td>{$frmData.email_to_agtphone}</td>
        </tr>
    {/if}
    {if $frmData.email_to_lender !=''}
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
            <td colspan="2"><font color="#094B6B">Lender Details :</font></td>
        </tr>
        <tr>
            <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Name :</strong></td>
            <td>{$frmData.email_to_lendname|lower|ucwords}</td>
        </tr>
        <tr>
            <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Email :</strong></td>
            <td>{$frmData.email_to_lender}</td>
        </tr>
        {if $frmData.email_to_lendphone != ''}
            <tr>
                <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Mobile :</strong></td>
                <td>{$frmData.email_to_lendphone}</td>
            </tr>
        {/if}
    {/if}
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr>
        <td colspan="2"><font color="#094B6B">User Details :</font></td>
    </tr>
    <tr>
        <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Name :</strong></td>
        <td>{$frmData.lead_first_name|lower|ucwords} {$frmData.lead_last_name|lower|ucwords}</td>
    </tr>
    <tr>
        <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Email :</strong></td>
        <td>{$frmData.lead_email}</td>
    </tr>
    {if $frmData.lead_phone != ''}
        <tr>
            <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Mobile :</strong></td>
            <td>{$frmData.lead_phone}</td>
        </tr>
    {/if}

    <tr>
        <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Comments :</strong></td>
        <td>{$frmData.lead_comment|nl2br}</td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr>
        <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Website :</strong></td>
        <td>{$frmData.email_from_website}</td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
	{if isset($frmData.lead_date_time) && $frmData.lead_date_time != ''}
		<tr>
			<td colspan="2" style="color:#094B6B">Preferred Date : </td>
		</tr>
		<tr>
			<td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Date :</strong></td>
			<td>{$frmData.lead_date_time|date_format:'%d %b %Y'}</td>
		</tr>
	{/if}
	<tr><td colspan="2">&nbsp;</td></tr>
    <tr>
        <td colspan="2"><font color="#094B6B">Property Details :</font></td>
    </tr>
    <tr>
        <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Plan Name :</strong></td>
        <td>{$Record.hp_name} {$Record.hp_name|lower|ucwords}</td>
    </tr>
    <tr>
        <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Beds :</strong></td>
        <td>{$Record.hp_beds|lower|ucwords}</td>
    </tr>
    <tr>
        <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Baths :</strong></td>
        <td>{$Record.hp_baths|lower|ucwords}</td>
    </tr>
    <tr>
        <td align="right" valign="top" style="padding:5px; background-color:#eaeaea"><strong>Price :</strong></td>
        <td>${$Record.harop_price|number_format:0}</td>
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