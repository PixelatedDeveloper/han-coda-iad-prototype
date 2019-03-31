<?php
	$id = (isset($_REQUEST['id']) && $_REQUEST['id'] > 0) ? $_REQUEST['id'] : 0;
	$doel = $goededoelen->get($id);
	
	if ($id && $doel) {
		if ($doel['logo']) {
			//$logo = '<img src="'.$doel['logo'].'" style="float: left; width: 200px; height: 200px;" alt="'.$doel['naam'].'" title="'.$doel['naam'].'" />';
			$logo = '
					<ul class="thumbnails" style="float: right;">
						<li style="width: 260px;">
							<div class="thumbnail">
								<div style="margin: auto; width: 250px; height: 200px; background: url('.$doel['logo'].') no-repeat 50% 50%;">&nbsp;</div>
								<small><a target="_blank" href="'.$doel['logo'].'">Vergroot afbeelding</a></small>
							</div>
						</li>
					</ul>
			';
		} else {
			$logo = '';
		}
		echo '
			<div class="row-fluid">
				<h1>'.$doel['naam'].'</h1>
				'.$logo.'
				<p>'.$doel['beschrijving'].'</p>
				<p><strong>Homepage</strong> <a href="'.$doel['url_homepage'].'" target="_blank">'.$doel['url_homepage'].'</a></p>
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
					<p>We konden deze doelisatie niet vinden..</p>
					<ul>
						<li>Zoek een nieuwe doelisatie hier links</li>
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
			$.get('ajax.php', { action: 'doneren', type: 'doel', id: <?php echo $id; ?>, bedrag: val, comment: $("#comment").val() }, function(data){
				
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