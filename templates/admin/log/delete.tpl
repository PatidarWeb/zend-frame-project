<form action="{SITE_URL}/admin/log/delete/id/{IDACTIVITY_LOG}" method="post" >
<fieldset style="width: 600px">
<legend>Delete Log</legend>
	<table class="medium_table">
		<tr>
			<td>
				<strong>Are you sure you want to delete this log ?</strong>
				<br/>
				<input type="checkbox" name="confirm">Confirm deletion
			</td>
			<td style="vertical-align: middle;">
				<input type="submit" class="button" value="YES" style="float: left; margin-right:10px;">
				<input type="button" onclick="window.location = '{SITE_URL}/admin/log/view'" class="button" value="Cancel">
			</td>
		</tr>
	</table>
</fieldset>
</form>
