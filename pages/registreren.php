<?php
$form = true;
if ($_SERVER['REQUEST_METHOD'] == "POST") {


	if ($_POST['optionsRadios'] == 'gebruiker') {
		$user_id = $gebruikers->signup($_POST['email'], $_POST['password']);
		$gebruikers->addGebruikerData($user_id, 0, $_POST['aanhef'], $_POST['Voornaam'], $_POST['Achternaam'], $_POST['Rekeningnummer']);
		if ($user_id) {
			$_SESSION['gdp_uid'] = $user_id;
			$form = false;
			echo '<meta http-equiv="refresh" content="0;URL=index.php" />';
		}
	} elseif ($_POST['optionsRadios'] == 'organisatie') {
		$user_id = $gebruikers->signup($_POST['email'], $_POST['password']);
		$gebruikers->addGebruikerData($user_id, 1, $_POST['orgaanhef'], $_POST['orgVoornaam'], $_POST['orgAchternaam']);
		$organisaties->set($user_id, $_POST['organisatie-naam'], $_POST['organisatie-beschrijving'], $_POST['organisatie-cbf'], $_POST['organisatie-bank'], $_POST['organisatie-straat'], $_POST['organisatie-huisnr'], $_POST['organisatie-postcode'], $_POST['organisatie-plaats'], $_POST['organisatie-telefoon'], $_POST['organisatie-emailadres'], $_POST['organisatie-url-homepage'], $_POST['organisatie-url-twitter'], $_POST['organisatie-url-facebook'], $_POST['logo']);
		if ($user_id) {
			$_SESSION['gdp_uid'] = $user_id;
			$form = false;
			echo '<meta http-equiv="refresh" content="0;URL=index.php" />';
		}
	}
}
?>

<div class="row-fluid">
	<?php
	if ($form) {
		echo '
		


		<form method="post" action="index.php?page=registreren">
			<fieldset>
				<legend>Registratie formulier</legend>
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
					<label class="control-label" for="optionsOrganisatie"></label>
					<div class="controls">
						<label class="radio">
							<input type="radio" name="optionsRadios" value="gebruiker" id="rd-gebruiker" checked="checked">
							Ik ben een Gebruiker
						</label>
						<label class="radio">
							<input type="radio" name="optionsRadios" value="organisatie" id="rd-organisatie">
							Ik ben een Organisatie
						</label>
					</div>
				</div>

				<div id="view-gebruiker-form">
					<div class="control-group">
						<label class="control-label" for="aanhef">Aanhef:</label>
						<div class="controls">
							<!--<input type="text" class="input-xlarge" id="aanhef">-->
							<select name="aanhef" class="input-xlarge">
								<option>Dhr.</option>
								<option>Mvr.</option>
								<option>Ms.</option>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="Voornaam">Voornaam:</label>
						<div class="controls">
							<input type="text" class="input-xlarge" name="Voornaam">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="Achternaam">Achternaam:</label>
						<div class="controls">
							<input type="text" class="input-xlarge" name="Achternaam">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="Rekeningnummer">Rekeningnummer:</label>
						<div class="controls">
							<input type="text" class="input-xlarge" name="Rekeningnummer" id="gebruiker-bank">
							<i class="popOver icon-info-sign" rel="popover" data-content="Bank rekeningnummer van U organisatie" data-original-title="Info"></i>
						</div>
					</div>
				</div>
				

				<div id="view-organisatie-form">

					<div id="accordion">
						<h3><a href="#">Contactpersoon gegevens</a></h3>
						<div>
							<div class="control-group">
								<label class="control-label" for="aanhef">Aanhef:</label>
								<div class="controls">
									<!--<input type="text" class="input-xlarge" id="aanhef">-->
									<select name="orgaanhef" class="input-xlarge">
										<option>Dhr.</option>
										<option>Mvr.</option>
										<option>Ms.</option>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="Voornaam">Voornaam:</label>
								<div class="controls">
									<input type="text" class="input-xlarge" name="orgVoornaam" id="test">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="Achternaam">Achternaam:</label>
								<div class="controls">
									<input type="text" class="input-xlarge" name="orgAchternaam">
								</div>
							</div>
						</div>

						<h3><a href="#">Organisatie gegevens</a></h3>
						<div>
							<div class="control-group">
								<label class="control-label" for="organisatie-naam">Organisatienaam:</label>
								<div class="controls">
									<input type="text" class="input-xlarge" name="organisatie-naam">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="organisatie-beschrijving">Beschrijving:</label>
								<div class="controls">
									<!--<input type="text" class="input-xlarge" name="organisatie-beschrijving">-->
									<textarea rows="5" cols="50" class="input-xlarge" name="organisatie-beschrijving"></textarea>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="organisatie-naam">Logo:</label>
								<div class="controls">
									<input type="text" class="input-xlarge" name="logo">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="organisatie-cbf">CBF nummer:</label>
								<div class="controls">
									<input type="text" class="input-xlarge" name="organisatie-cbf" id="organisatie-cbf">
									<i class="popOver icon-info-sign" rel="popover" data-content="Aanmeldingsnummer" data-original-title="Info"></i>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="organisatie-bank">Bank/giro:</label>
								<div class="controls">
									<input type="text" class="input-xlarge" name="organisatie-bank" id="organisatie-bank">
									<i class="popOver icon-info-sign" rel="popover" data-content="Bank rekeningnummer van U organisatie" data-original-title="Info"></i>
								</div>
							</div>
						</div>

						<h3><a href="#">Contact gegevens</a></h3>
						<div>
							<div class="control-group">
								<label class="control-label" for="organisatie-straat">Straat + huisnr:</label>
								<div class="controls">
									<input type="text" class="input-medium" name="organisatie-straat">
									<input type="text" class="input-small" name="organisatie-huisnr">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="organisatie-postcode">Postcode:</label>
								<div class="controls">
									<input type="text" class="input-medium" placeholder="AAAA 11" name="organisatie-postcode">
								</div>
							</div>
								<div class="control-group">
								<label class="control-label" for="organisatie-plaats">Plaats:</label>
								<div class="controls">
									<input type="text" class="input-xlarge" name="organisatie-plaats">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="organisatie-telefoon">Telefoon:</label>
								<div class="controls">
									<input type="text" class="input-xlarge" name="organisatie-telefoon">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="organisatie-emailadres">E-mailadres organisatie:</label>
								<div class="controls">
									<input type="text" class="input-xlarge" name="organisatie-emailadres">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="organisatie-url-homepage">Website:</label>
								<div class="controls">
									<input type="text" class="input-xlarge" name="organisatie-url-homepage">
								</div>
							</div>
						</div>

						<h3><a href="#">Social media</a></h3>
						<div>
							<div class="control-group">
								<label class="control-label" for="organisatie-url-twitter">Twitter:</label>
								<div class="controls">
									<input type="text" class="input-xlarge" name="organisatie-url-twitter">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="organisatie-url-facebook">Facebook:</label>
								<div class="controls">
									<input type="text" class="input-xlarge" name="organisatie-url-facebook">
								</div>
							</div>
						</div>
					</div>
				
				</div>

				<div class="form-actions">
					<input type="submit" class="btn btn-primary" value="Opslaan" />
				</div>
			</fieldset>
		</form>
		';
	}
	?>
</div>	

<script type="text/javascript">
	$(function() {
		$( "#accordion" ).accordion({
			autoHeight: false,
			navigation: true
		});

		$('.popOver').popover({
			selector: true
		});

		

		$("#organisatie-cbf").keyup(function() {
			var obj = $(this).parent().parent();
			showError(obj, $(this).val());
		});


		$("#organisatie-bank").keyup(function() {
			var obj = $(this).parent().parent();
			showError(obj, $(this).val());
		});

		$("#gebruiker-bank").keyup(function() {
			var obj = $(this).parent().parent();
			showError(obj, $(this).val());
		});

	});

	function showError(obj, value){
		if(isNaN(Number(value)))
		{
			if (!obj.hasClass("error")){
				obj.addClass('error');
			}
		}
		else
		{
			obj.removeClass('error');
		}
	}

	function onlyNumbers(value){
		return(Number(value));
	}


</script>