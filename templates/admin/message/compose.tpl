<form action="{SITE_URL}/admin/message/compose" method="post" >
<input type="hidden" name="userToken" value="{USERTOKEN}">
<fieldset style="width: 500px">
<legend>Compose Message</legend>
	<table class="medium_table">
		<tr>
			<td width="148px"><b>From</b><span class="required">*</span></td>
			<td><input type="text" name="message_from" value="{MESSAGE_FROM}"></td>
		</tr>
		<tr>
			<td><b>From Email</b><span class="required">*</span></td>
			<td><input type="text" name="message_from_email" value="{MESSAGE_FROM_EMAIL}"></td>
		</tr>
		<tr>
			<td width="148px"><b>To</b><span class="required">*</span></td>
			<td><input type="text" name="message_to" value="{MESSAGE_TO}"></td>
		</tr>
		<tr>
			<td><b>To Email</b><span class="required">*</span></td>
			<td><input type="text" name="message_to_email" value="{MESSAGE_TO_EMAIL}"></td>
		</tr>
		<tr>
			<td><b>Subject</b><span class="required">*</span></td>
			<td><input type="text" name="subject" value="{SUBJECT}"></td>
		</tr>
		<tr>
			<td><b>Message</b><span class="required">*</span></td>
			<td><textarea rows="10" cols="60" name="message_text">{MESSAGE_TEXT}</textarea></td>
		</tr>	
		<tr>
			<td></td>
			<td>
				<input type="submit" class="button" value="Send">
			</td>
		</tr>
	</table>
</fieldset>
</form>