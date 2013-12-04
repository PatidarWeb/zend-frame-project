<form action="{SITE_URL}/admin/translation/delete/id/{IDTRANSLATIONS}" method="post" >
<input type="hidden" name="userToken" value="{USERTOKEN}">
<fieldset style="width: 600px">
<legend>Delete Translation: {ORIGINAL_STRING}</legend>
	<table class="medium_table">
		<tr>
			<td>
				<strong>Are you sure you want to delete this translation ?</strong>
				<br/>
				<input type="checkbox" name="confirm">Confirm deletion
			</td>
			<td style="vertical-align: middle;">
				<input type="submit" class="button" value="YES" style="float: left; margin-right:10px;">
				<input type="button" onclick="window.location = '{SITE_URL}/admin/translation/list'" class="button" value="Cancel">
			</td>
		</tr>
	</table>
</fieldset>
</form>
