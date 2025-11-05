<div style="text-align: center; "></div>
<div style="text-align: center; ">
	&nbsp; &nbsp;Dear <span style="color: rgb(6, 112, 188); "><strong>{$display_name|replace:'_':' '}</strong></span>
</div>
<div style="text-align: center; padding-left: 1em; "></div>
<div style="padding-left: 1em; ">
	<div style="text-align: center; margin: 0px; padding: 0px; ">&nbsp;</div>
	<div style="text-align: center; ">
		Here are your login details.
	</div>
	<table align="center" border="0" cellpadding="5" cellspacing="2" style="text-align: center; " width="50%">
		<tbody>
		<tr>
			<td align="right" style="padding: 5px; background-color: rgb(234, 234, 234); ">
				<strong>Email :</strong>
			</td>
			<td align="left">{if $user_email}{$user_email}{else}{$frmData.user_email}{/if}</td>
		</tr>
		<tr>
			<td align="right" style="padding: 5px; background-color: rgb(234, 234, 234); ">
				<strong>New Password :</strong>
			</td>
			<td align="left">{if $password}{$password}{/if}</td>
		</tr>
		</tbody>
	</table>
	<div style="text-align: center; "></div>
	<div style="text-align: center; ">
		<span style="line-height: 1.3em;">We are always looking to improve, if you have any suggestions on how to improve our site, please let us know.</span>
	</div>
</div>
<p></p>
