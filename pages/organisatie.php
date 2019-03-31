<?php
	$id = (isset($_REQUEST['id']) && $_REQUEST['id'] > 0) ? $_REQUEST['id'] : 0;
	$organ = $organisaties->get($id);
	
	if ($id && $organ) {
		if ($organ['logo']) {
			//$logo = '<img src="'.$organ['logo'].'" style="float: left;" alt="'.$organ['naam'].'" title="'.$organ['naam'].'" />';
			$logo = '
					<ul class="thumbnails" style="float: right;">
						<li style="width: 260px;">
							<div class="thumbnail">
								<div style="margin: auto; width: 250px; height: 200px; background: url('.$organ['logo'].') no-repeat 50% 50%;">&nbsp;</div>
								<small><a target="_blank" href="'.$organ['logo'].'">Vergroot afbeelding</a></small>
							</div>
						</li>
					</ul>
			';
		} else {
			$logo = '';
		}
		echo '
			<div class="row-fluid">
				<h1>'.$organ['naam'].'</h1>
				'.$logo.'
				<p>'.$organ['beschrijving'].'</p>
				<div style="clear: both;">&nbsp;</div>
				<address style="float: right;">
					<p>
						'.$organ['naw_straat'].' '.$organ['naw_huisnummer'].' <br />
						'.$organ['naw_postcode'].' <br />
						'.$organ['naw_plaats'].'
					</p>
					<p>
						T: '.$organ['telefoon'].'<br />
						E: <a href="mailto:'.$organ['emailadres'].'">'.$organ['emailadres'].'</a>
					</p>
				</address>
				<ul>
					<li><strong>Homepage</strong> <a href="'.$organ['url_homepage'].'" target="_blank">'.$organ['url_homepage'].'</a></li>
					<li><strong>Twitter</strong> <a href="'.$organ['url_twitter'].'" target="_blank">'.$organ['url_twitter'].'</a></li>
					<li><strong>Facebook</strong> <a href="'.$organ['url_facebook'].'" target="_blank">'.$organ['url_facebook'].'</a></li>
				</ul>
				<br/>

				<div class="modal hide fade in" id="modalDonatie">
					<div class="modal-header">
						<a class="close" data-dismiss="modal">x</a>
						<h3>Doneren</h3>
					</div>
						<div class="modal-body">
						<p>Kies het gewenste bedrag!</p>
						<input type="radio" name="bedrag" checked="checked" value="5" /> €5,-
						<br /><input type="radio" name="bedrag" value="10" /> €10,-
						<br /><input type="radio" name="bedrag" value="25" /> €25,-
						<br /><input type="radio" name="bedrag" value="50" /> €50,-
						<br /><input style="display: none;" type="radio" id="eigenx" name="bedrag" value="x" />Anders, namelijk <div class="input-prepend"><span class="add-on">&euro;</span><input type="text" class="input-mini" id="eigenbedrag" name="eigenbedrag" /></div>
						<p>Wil je nog iets kwijt?</p>
						<textarea id="comment" rows="3" cols="80"></textarea>
					</div>
					<div class="modal-footer">
						<a href="#" class="btn" data-dismiss="modal">Annuleer</a>
						<a href="#" id="doneerbutton" class="btn btn-primary">Doneer</a>
					</div>
				</div>

				<a class="btn btn-warning btn-large" data-toggle="modal" href="#modalDonatie">Doneren</a>
			</div>
		';
		
		$doelen = $goededoelen->getByOrganisatie($organ['id']);
		if ($doelen) {
			echo '
				<div class="row-fluid">
					<h2>Goede doelen van '.$organ['naam'].'</h2>
					<ul class="thumbnails">
			';
				foreach ($doelen as $doel) {
					echo '
						<li style="width: 260px;">
							<div class="thumbnail">
								<div style="margin: auto; width: 250px; height: 200px; background: url('.$doel['logo'].') no-repeat 50% 50%;">&nbsp;</div>
								<h3><a href="index.php?page=goeddoel&id='.$doel['id'].'">'.$doel['naam'].'</a></h3>
							</div>
						</li>
					';
				}
			echo '
					</ul>
				</div>
			';
		}
		
		// Agenda stuff
$items = $publiekeagenda->getByOrganisatie($id);

if ($items) {
	echo '
	<h2>Agenda items</h2>
	<div class="row">
		<ul class="thumbnails">
	';
	foreach ($items as $item) {
		$foto = ($item['foto']) ? '<img src="'.$item['foto'].'" width="100"  height="100" alt="'.$item['naam'].'" title="'.$item['naam'].'" style="float: right; margin: 10px; "/>' : '';
		$prijs = ($item['entree'] == 0) ? 'gratis' : '€ '.$item['entree'];
		//$datum = ($item['datum_begin'] == $item['datum_eind']) ? $item['datum_begin'] : $item['datum_begin'].' &mdash; '.$item['datum_eind'];
		// Datum
		if ($item['datum_begin'] == $item['datum_eind']) {
			$datum = date('d-m-Y', strtotime($item['datum_begin']));
		} else {
			$datum = date('d-m', strtotime($item['datum_begin'])).' &mdash; '.date('d-m-Y', strtotime($item['datum_eind']));
		}
		// Tijd
		if ($item['heledag']) {
			$tijd = 'hele dag';
		} else {
			$tijd = $item['tijd_begin'].' &mdash; '.$item['tijd_eind'];
		}
		// Goed doel / stichting
		if ($item['goeddoel_id']) {
			$doel = $goededoelen->get($item['goeddoel_id']);
			$organiser = '<a href="index.php?page=goeddoel&id='.$doel['id'].'">'.$doel['naam'].'</a>';
		} else {
			$doel = $organisaties->get($item['stichting_id']);
			$organiser = '<a href="index.php?page=organisatie&id='.$doel['id'].'">'.$doel['naam'].'</a>';
		}
		echo '
		<li class="span4">
	  		<div class="thumbnail" style="position: relative; height: 200px; overflow: auto;">
				'.$foto.'
				<h3><a href="index.php?page=agenda&id='.$item['id'].'">'.$item['naam'].'</a></h3>
				<p>
					'.$item['beschrijving'].'
				</p>
				<p>
					<em><strong>Entree</strong>: '.$prijs.'</em>
					<br />
					<em><strong>Datum</strong>: '.$datum.'</em>
					<br />
					<em><strong>Tijd</strong>: '.$tijd.'</em>
					<br />
					<em><strong>Locatie</strong>: '.$item['locatie'].'</em>
				</p>
				</p>
					<strong>Organisator</strong>: '.$organiser.'
				</p>
	    	</div>
	    </li>
		';
	}
	echo '
		</ul>
	</div>
	';
} 

		/*echo '<pre>';
		print_r($doelen);
		print_r($organ);
		echo '</pre>';*/
		
		echo '
			<div id="disqus_thread"></div>
			<script type="text/javascript">
				var disqus_shortname = "gdportal"; 

				(function() {
					var dsq = document.createElement("script"); dsq.type = "text/javascript"; dsq.async = true;
					dsq.src = "http://" + disqus_shortname + ".disqus.com/embed.js";
					(document.getElementsByTagName("head")[0] || document.getElementsByTagName("body")[0]).appendChild(dsq);
				})();
			</script>
			<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
			<a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a>
		';
	} else {
		echo '
			<div class="row-fluid">
				<div class="span9">
					<h2>Oeps..</h2>
					<p>We konden deze organisatie niet vinden..</p>
					<ul>
						<li>Zoek een nieuwe organisatie hier links</li>
						<li>Of als u zeker bent dat deze link hoort te werken, vertel het <a href="mailto:webmaster@goededoelenportal.nl">de webmaster</a>.</li>
					</ul>
				</div>
			</div>
		';
	}
?>

<script type="text/javascript">
$(document).ready(function(){
	$("#eigenbedrag").focus(function(){
		$("#eigenx").attr('checked', 'checked');
	});
	$("#doneerbutton").click(function(){
		var val = $("input[name=bedrag]:checked").val();
		if (val == 'x') {
			val = $("#eigenbedrag").val();
		}
		if (confirm('Weet je zeker dat je €'+val+' euro wilt doneren?')) {
			$.get('ajax.php', { action: 'doneren', type: 'organisatie', id: <?php echo $id; ?>, bedrag: val, comment: $("#comment").val() }, function(data){
			
				if (Number(data) == 1)
				{
					$('#modalDonatie').modal('hide');
				}
			});
		}
		return false;
	});
});
</script>