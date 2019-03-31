<?php
session_start();

foreach (glob('classes/class.*.php') as $class) {
	include($class);
}

$db = new db; // Initiate database
$organisaties = new organisaties;
$gebruikers = new gebruikers;
$goededoelen = new goededoelen;
$donaties = new donaties;
$publiekeagenda = new publiekeagenda;
$agenda = new agenda;
$reacties = new reacties;

// User session
$user_id = 0;
if (isset($_SESSION['gdp_uid']) && $_SESSION['gdp_uid'] > 0) {
	$user_id = $_SESSION['gdp_uid'];
	$user = $gebruikers->get($user_id);
}

// Page system
$start_page = ($user_id) ? 'agendaoverzicht' : 'home';
$page = (isset($_REQUEST['page'])) ? $_REQUEST['page'] : $start_page;
$page = (file_exists('pages/'.$page.'.php')) ? $page : '404';

// Search
$q = (isset($_GET['q'])) ? $_GET['q'] : 0;
if ($q) {
	$searchdoelen = $goededoelen->search($q);
	$searchorgs = $organisaties->search($q);
	$foundd = (is_array($searchdoelen)) ? count($searchdoelen) : 0;
	$foundo = (is_array($searchorgs)) ? count($searchorgs) : 0;
	$found = $foundd + $foundo;
	if ($searchdoelen) {
		foreach ($searchdoelen as $searchdoel) {
			if ($found == 1) {
				// Redirect straight away
				header('Location: index.php?page=goeddoel&id='.$searchdoel['id']);
			}
		}
	}
	if ($searchorgs) {
		foreach ($searchorgs as $searchorg) {
			if ($found == 1) {
				// Redirect straight away
				header('Location: index.php?page=organisatie&id='.$searchorg['id']);
			}
		}
	}
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>GoedeDoelenPortal.nl</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="GoedeDoelenPortal.nl is een website met een overzicht van alle goede doelen, kies bewust!">
    <meta name="author" content="GoedeDoelenPortal.nl">

    <!-- Le styles -->
    <link href="styles/bootstrap.css" rel="stylesheet">
    <link href="styles/custom.css" rel="stylesheet">
    <link href="styles/box.css" rel="stylesheet">
    <link href="styles/smoothness/jquery-ui-1.8.18.custom.css" rel="stylesheet">

    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>

    <script src="scripts/jquery.js"></script>
  	<script src="scripts/bootstrap.js"></script>
    <script src="scripts/custom.js"></script>
	<script src="scripts/disqus.js"></script>
	<script src="scripts/jquery-ui-1.8.18.custom.min.js"></script>
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="index.php">GoedeDoelenPortal.nl</a>
          <div class="nav-collapse">
            <ul class="nav">
			<?php
				$menu = array(
					'home' => 'Home',
					'agendaoverzicht' => 'Agenda',
					'organisatieoverzicht' => 'Organisaties'
				);
				
				foreach ($menu as $url => $text) {
					$active = ($url == $page) ? 'class="active"' : '';
					echo '<li '.$active.'><a href="index.php?page='.$url.'">'.$text.'</a></li>';
				}
			?>
            </ul>
          <p class="navbar-text pull-right">
			<?php
				if ($user_id) {
					echo 'Welkom, <strong>'.$user['gebruiker']['form_voornaam'].' '.$user['gebruiker']['form_achternaam'].'</strong> &mdash; <a href="index.php?page=logout">Log uit</a>';
				}
			?>
		  </p>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    
    <div class="container-fluid">
      <div class="row-fluid">
        <!-- sidebar left -->
        <div class="span3">
          <div id="leftSidebar" class="well sidebar-nav">

            <div id="search-container">

			<form id="searchform" method="get" action="index.php">
              <div id="searchbox-container">
                  <input name="q" id="searchbox" type="text" placeholder="Zoekterm" class="input-medium search-query">
              </div>
			</form>
		<script type="text/javascript">
			$("#searchbox").autocomplete({
				<?php
					$acitems = array();
					$ac = $goededoelen->getGoedeDoelen();
					foreach ($ac['organisaties'] as $acitem) {
						$acitems[] = $acitem['naam'];
					}
					foreach ($ac['goededoelen'] as $acitem) {
						$acitems[] = $acitem['naam'];
					}
					
					echo 'source: [';
					foreach ($acitems as $item) {
						echo '"'.$item.'",';
					}
					echo ']';
				?>
			});
			$( "#searchbox" ).bind( "autocompleteselect", function(event, ui) {
				$(this).val(ui.item.label);
				$("#searchform").submit();
			});
		</script>
            </div>
			
			<?php
			if ($q) {
				?>
			<strong>Organisaties</strong>
            <ul id="search-results" class="nav nav-list">
				<?php
					if ($searchorgs) {
						foreach ($searchorgs as $organ) {
							echo '<li><a href="index.php?page=organisatie&id='.$organ['id'].'">'.$organ['naam'].'</a></li>';
						}
					} else {
						echo '<li><em>&mdash;</em></li>';
					}
				?>
            </ul>
			<hr size="3" style="background-color: #ddd;"/>
			<strong>Goede doelen</strong>
            <ul id="search-results" class="nav nav-list">
				<?php
					if ($searchdoelen) {
						foreach ($searchdoelen as $organ) {
							echo '<li><a href="index.php?page=goeddoel&id='.$organ['id'].'">'.$organ['naam'].'</a></li>';
						}
					} else {
						echo '<li><em>&mdash;</em></li>';
					}
				?>
            </ul>
				<?php
			} else {
				?>
			<strong>Organisaties</strong>
            <ul id="search-results" class="nav nav-list">
				<?php
					$organs = $organisaties->getAll();
					foreach ($organs as $organ) {
						echo '<li><a href="index.php?page=organisatie&id='.$organ['id'].'">'.$organ['naam'].'</a></li>';
					}
				?>
            </ul>
			<hr size="3" style="background-color: #ddd;"/>
			<div style="text-align: center;">
				<!--<em style="color: #aaa;">&laquo; Vorige | Pagina 1 van 1 | Volgende &raquo; </em>-->
				<strong style="color: #aaa;"><a href="#" onclick="javascript:alert('Deze functie wordt nog ontwikkeld'); return false;">Toon meer</a></strong>
			</div>
				<?php
			}
			
			?>
          </div>
        </div>

        <div id="mainContent" class="span6">
			<!-- Main content -->
			<?php
				include('pages/'.$page.'.php');
			?>
			<!-- End Main content -->
		    </div>

        <div class="span3">
            <div id="rightSidebar" class="well sidebar-nav">

              <div id="mijn-profiel" class="boxOne">
                <div class="header">
                  <span>Mijn profiel</span>
                </div>
                <div class="content">
					<?php
						if ($user_id && is_array($user)) {
							echo '
								<h3>'.$user['gebruiker']['form_voornaam'].' '.$user['gebruiker']['form_achternaam'].'</h3>
								<p><em>'.$user['gebruiker']['emailadres'].'</em></p>
								
								<ul>
									<li><a href="index.php?page=mijndonaties">Mijn donaties</a></li>
								</ul>
							';
						} else {
							echo '
								<form method="post" action="index.php?page=login">
									<div class="control-group">
										<label class="control-label" for="email">E-mail:</label>
										<div class="controls">
											<input type="text" class="input-large" name="email">
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="password">Wachtwoord:</label>
										<div class="controls">
											<input type="password" class="input-large" name="password">
										</div>
									</div>
									<div class="control-group">
										<div class="controls">
											<input type="submit" class="btn btn-primary" value="Log in" />
										</div>
									</div>
								</form>
								<p>Nog geen account? Maak er gratis eentje aan!</p>
								<a class="btn btn-success" href="index.php?page=registreren">Registreren</a>  
							';
						}
					?>
                </div>
              </div>
			  
		<?php
			if ($user_id && isset($user['organisatie'])) {
				echo '
				  <div id="mijn-organisatie" class="boxOne">
					<div class="header">
					  <span>Mijn organisatie</span>
					</div>
					<div class="content">
						<h3>'.$user['organisatie']['naam'].'</h3>
						<ul>
							<li><a href="index.php?page=goededoelen">Goede doelen beheren</a></li>
							<li><a href="index.php?page=agendabeheer">Agenda beheren</a></li>
							<li><a href="index.php?page=donatiesbekijken">Donaties bekijken</a></li>
						</ul>
					</div>
				  </div>
				';
			}
		?>
		
		<?php
			if ($user_id) {
				echo '
              <div id="agenda" class="boxOne">
                <div class="header">
                  <span>Agenda</span>
                </div>
                <div class="content">
                  <table id="userAgenda" class="table table-striped table-bordered table-condensed">
                    <thead>
                      <tr>
                        <th>Datum</th>
                        <th>Evenement</th>
                        <th>Organisator</th>
                      </tr>
                    </thead>
                    <tbody>
                ';
				$items = $agenda->getFull($user_id);
				if ($items) {
					foreach ($items as $item) {
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
							<tr>
								<td>'.$datum.'<br />'.$tijd.'</td>
								<td><a href="index.php?page=agenda&id='.$item['id'].'">'.$item['naam'].'</a></td>
								<td>'.$organiser.'</td>
							</tr>
						';
					}
				} else {
					echo '
						<tr>
							<td id="nog-geen-items" colspan="3">Je hebt nog geen agenda items!</td>
						</tr>
					';
				}
				echo '
                    </tbody>
                  </table>

                <!--<a href="#" class="btn btn-inverse btn-small">Beheren</a>-->
                </div>
              </div>
				';
			}
		?>

              <div id="social-media" class="boxOne">
                <div class="header">
                  <span>Social media</span>
                </div>
                <div class="content">
                  <div id="social-media" style="text-align: center;">
                    <a href="http://www.facebook.com/goededoelenportal">
                      <img src="img/socialmediabuttons/facebook-medium.png" alt="Facebook" title="Facebook" />
                    </a>
                    <a href="http://www.twitter.com/goededoelenportal">
                      <img src="img/socialmediabuttons/twitter-medium.png" alt="Twitter" title="Twitter" />
                    </a>
                    <a href="http://plus.google.com/goededoelenportal">
                      <img src="img/socialmediabuttons/google-medium.png" alt="Google Plus" title="Google Plus" />
                    </a>
                  </div>
                </div>
              </div>

            </div>
          </div>

        </div>
      </div>
    </div>

  </body>
</html>