<form id="mailchimp-form">
	<div class="form-group">
		<label for="email">Email:</label>
		<input id="email" name="email_mailchimp" type="text" style="width:200px" placeholder="<?=$placeholder; ?>"/>
		<div class="error-box"></div>
	</div>
	<input type="hidden" name="success" value="<?=$success; ?>">
	<input type="hidden" name="error" value="<?=$error; ?>">
	<div>
		<input id="send" class="btn btn-lg btn-default" type="submit" value="<?=$submit ?>"/>
	</div>
</form>
<div class="result-mailchimp"></div>