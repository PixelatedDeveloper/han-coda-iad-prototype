<?php
if ($user_id && $user['gebruiker']['is_organisatie']) {
	$dons = $donaties->getAllByOrganisatie($user['organisatie']['id']);
	$doelen = $goededoelen->getByOrganisatie($user['organisatie']['id']);
	$cdoelen = array();
	if ($doelen) {
		foreach ($doelen as $doel) {
			$cdoelen[$doel['id']] = $doel;
		}
	}
	
	$tempusers = array();
	
	echo '
		<h1 class="page-header">Donatiesgeschiedenis</h1>
	';
	
	echo '
		<table class="table table-striped table-bordered table-condensed">
		<tr>
			<th>Doel</th>
			<th>Bedrag</th>
			<th>Opmerking</th>
			<th>Door</th>
			<th>Datum</th>
		</tr>
	';
	$piechart = array();
	$piechartorg = 0;
	$totaal = 0;
	if ($dons) {
		foreach ($dons as $don) {
			if ($don['stichting_id']) {
				$doel = '<a href="index.php?page=organisatie&id='.$user['organisatie']['id'].'">'.$user['organisatie']['naam'].'</a>';
				$piechartorg = $piechartorg + $don['bedrag'];
			} else {
				$doel = '<a href="index.php?page=goeddoel&id='.$don['goeddoel_id'].'">'.$cdoelen[$don['goeddoel_id']]['naam'].'</a>';
				if (!isset($piechart[$don['goeddoel_id']])) {
					$piechart[$don['goeddoel_id']] = $don['bedrag'];
				} else {
					$piechart[$don['goeddoel_id']] = $piechart[$don['goeddoel_id']] + $don['bedrag'];
				}
			}
			
			if ($don['gebruiker_id']) {
				if (!isset($tempusers[$don['gebruiker_id']])) {
					$tempusers[$don['gebruiker_id']] = $gebruikers->get($don['gebruiker_id']);
				}
				$smalluser = $tempusers[$don['gebruiker_id']]['gebruiker'];
				
				$donor = '<a href="index.php?page=gebruikers&id='.$don['gebruiker_id'].'">'.$smalluser['form_voornaam'].' '.$smalluser['form_achternaam'].'</a>';
			} else {
				$donor = '';
			}
			echo '
				<tr>
					<td>'.$doel.'</td>
					<td>€ '.$don['bedrag'].'</td>
					<td>'.htmlentities($don['opmerking']).'</td>
					<td>'.$donor.'</td>
					<td>'.$don['datum'].'</td>
				</tr>
			';
			$totaal = $totaal + $don['bedrag'];
		}
	} else {
		echo '<tr><td colspan="5">Er zijn nog geen donaties! :(</td></tr>';
	}
	echo '</table>';
	
	
	if ($dons) {
		echo '
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script type="text/javascript">
		  google.load("visualization", "1", {packages:["corechart"]});
		  google.setOnLoadCallback(drawChart);
		  function drawChart() {
			var data = new google.visualization.DataTable();
			data.addColumn("string", "Task");
			data.addColumn("number", "Hours per Day");
			data.addRows([
		'; 
		echo '["Stichting: '.$user['organisatie']['naam'].'", '.$piechartorg.'],';
		foreach ($piechart as $id => $bedrag) {
			echo '["Goed doel: '.$cdoelen[$id]['naam'].'", '.$bedrag.'],';
		}
		echo '
			]);

			var options = {
			  title: "Donaties per goed doel/stichting. Totaal: € '.$totaal.'"
			};

			var chart = new google.visualization.PieChart(document.getElementById("chart_div"));
			chart.draw(data, options);
		  }
		</script>
		<div id="chart_div" style="width: 600px; height: 400px;"></div>
		';
	}
	
	/*echo '<pre>';
	print_r($dons);
	echo '</pre>';*/
} else {
	echo '
		<h1>Sorry..</h1>
		<p>
			U heeft geen toegang tot dit gedeelte van de website.
		</p>
	';
}
?>
