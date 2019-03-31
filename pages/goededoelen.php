<?php
if ($user_id && $user['gebruiker']['is_organisatie']) {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$goededoelen->set($_POST['organisatie_id'], $_POST['naam'], $_POST['beschrijving'], $_POST['logo'], $_POST['url_homepage']);
	}
	echo '
		<h1>Goede doelen beheren: '.$user['organisatie']['naam'].'</h1>
		<form method="post" action="index.php?page=goededoelen">
			<input type="hidden" name="organisatie_id" value="'.$user['organisatie']['id'].'" />
			<fieldset>
				<legend>Nieuw goed doel toevoegen</legend>
				<div class="control-group">
					<label class="control-label" for="organisatie-naam">Naam:</label>
					<div class="controls">
						<input type="text" class="input-xlarge" name="naam">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="organisatie-beschrijving">Beschrijving:</label>
					<div class="controls">
						<!--<input type="text" class="input-xlarge" name="organisatie-beschrijving">-->
						<textarea rows="5" cols="50" class="input-xlarge" name="beschrijving"></textarea>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="organisatie-naam">Logo:</label>
					<div class="controls">
						<input type="text" class="input-xlarge" name="logo">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="organisatie-naam">Goed doel actiepagina:</label>
					<div class="controls">
						<input type="text" class="input-xlarge" name="url_homepage">
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="submit" class="btn btn-primary" value="Maak aan" />
					</div>
				</div>
			</fieldset>
		</form>
	';
	
	$gdoelen = $goededoelen->getByOrganisatie($user['organisatie']['id']);
	if ($gdoelen) {
		echo '<h3>Overzicht van goede doelen</h3>';
		echo '<ul>';
			foreach ($gdoelen as $gdoel) {
				echo '<li>'.$gdoel['naam'].'</li>';
			}
		echo '</ul>';
	}
} else {
	echo '
		<h1>Sorry..</h1>
		<p>
			U heeft geen toegang tot dit gedeelte van de website.
		</p>
	';
}
?>