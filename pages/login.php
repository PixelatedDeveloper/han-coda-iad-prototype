<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$user_id = $gebruikers->login($_POST['email'], $_POST['password']);
	$_SESSION['gdp_uid'] = $user_id;
}
?>

<div class="row-fluid">
   	<div class="span6">
	<?php
	if ($user_id) {
		$user = $gebruikers->get($user_id);
		echo '
			<p>Welkom terug, <strong>'.$user['gebruiker']['form_voornaam'].' '.$user['gebruiker']['form_achternaam'].'</strong>!</p>
			<meta http-equiv="refresh" content="1;URL=index.php" />
		';
		$form = false;
	} else {
		$form = true;
	}
	if ($form) {
	echo '
		<form method="post" action="index.php?page=login">
			<fieldset>
				<legend>Inloggen</legend>
				<div class="control-group">
					<label class="control-label" for="email">E-mail:</label>
					<div class="controls">
						<input type="text" class="input-xlarge" name="email">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="password">Wachtwoord:</label>
					<div class="controls">
						<input type="password" class="input-xlarge" name="password">
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="submit" class="btn btn-primary" value="Log in" />
					</div>
				</div>
			</fieldset>
		</form>
	';
	}
	?>
	</div>
</div>