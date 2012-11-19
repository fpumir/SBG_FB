<?php
	function parse_signed_request($signed_request) {
	  list($encoded_sig, $payload) = explode('.', $signed_request, 2); 
	
	  // decode the data
	  $sig = base64_url_decode($encoded_sig);
	  $data = json_decode(base64_url_decode($payload), true);
	
	  return $data;
	}
	
	function base64_url_decode($input) {
	  return base64_decode(strtr($input, '-_', '+/'));
	}
	
	if ($_REQUEST) {
	  $signed_request = $_REQUEST['signed_request'];
		$json = parse_signed_request($signed_request);
		
		$liked = $json['page']['liked'];		
	}
	
?>

<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="css/normalize.min.css">
        <link rel="stylesheet" href="css/main.css">
				
				<!--[if IE 8]>
				    <style type="text/css">
				    	div.field_container_for_ie{
				    		margin: 0 0 5px 0 !important;
				    	}
				    </style>
				<![endif]-->
				
        <script src="js/vendor/modernizr-2.6.1.min.js"></script>
                    
    </head>
    <body>
    
			<div id="main" <?php if($liked == 1){ ?>class="quizz"<?php } ?>>
				
				<h1>Showa Best glove</h1>
				
				<?php
					if($liked != 1){
				?>
				<!-- Step 1 -->
				<p id="like">Cliquez sur j'aime pour participer</p>
				
				<div id="description">
					<img src="img/univers.png" alt="Découvrez l'univers de Showa Best Glove" />
					<h2>et tentez de gagner un <strong>week-end "Chateaux et demeures de charme"</strong> par semaine</h2>
					<h3>Du 15 novembre au 17 décembre</h3>
				</div>
				<!--// Step 1 -->
				<?php }else{ ?>
				
				<!-- Step 2 -->
				<div id="quizz">
					<p class="consigne">Répondez à 3 questions pour participer au tirage au sort.</p>
					<p class="consigne">Un doute sur la réponse ? <strong>Cliquer sur l'indice !</strong></p>
					
					<div class="question first">
						
						<strong>Q1 : Combien y a t-il de gants anti coupures de niveau EN5 sur le site de Showa Best ?</strong>
					
						<a href="http://www.showa-europe.com/fr/gants/anti-coupures?field_cut_level_value=en_cut_5&field_liner_tid=All" class="indice" target="_blank">Indice</a>
					
						<ul class="answers">
							<li>0 gants</li>
							<li>8 gants</li>
							<li>5 gants</li>
						</ul>
					
					</div>
					
					<div class="question">
						
						<strong>Q2 : En plus de sa gamme de produit, <br />le site de Showa Best dispose ?</strong>
					
						<a href="http://www.showa-europe.com/fr/protection-des-mains" class="indice" target="_blank">Indice</a>
					
						<ul class="answers">
							<li>d'un espace scientifique</li>
							<li>d'un coin des experts</li>
							<li>d'une page sur le japon</li>
						</ul>
					
					</div>
					
					<div class="question">
						
						<strong>Q3 : L'usine type représentée dans <br />"Le groupe Showa Best" dispose ?</strong>
					
						<a href="http://www.showa-europe.com/fr/le-groupe-showa-best" class="indice" target="_blank">Indice</a>
					
						<ul class="answers">
							<li>d'une salle de musée</li>
							<li>d'une piscine</li>
							<li>d'un jardin japonais</li>
						</ul>
					
					</div>
					
					<a href="#" id="validate">Valider mes réponses</a>
					
				</div>
				<!--// Step 2 -->
				
				<?php } ?>
				
				<!-- Step 3 -->
				<div id="formulaire" style="display: none;">
					
					<p class="consigne"><strong>Remplissez le formulaire</strong> pour participer au tirage au sort et tenter de gagner un week-end " Chateaux et demeures de charme "</p>
					
					<div id="form_content">
						
						<div class="field_container_for_ie">
							<select name="civilite">
								<option value="Civilité">Civilité</option>
								<option value="M">M.</option>
								<option value="Mme">Mme.</option>
							</select>
						</div>
						
						<div class="field_container_for_ie">
							<input type="text" name="nom" value="Nom*" />
							<input type="text" name="prenom" value="Prénom*" />
						</div>
						
						<div class="field_container_for_ie">
							<input type="text" name="societe" value="Société" />
							<input type="text" name="fonction" value="Fonction" />
						</div>
						
						<div class="field_container_for_ie" id="textarea_for_adress">					
							<textarea name="adresse">Adresse*</textarea>
						</div>
						
						<div class="field_container_for_ie">
							<input type="text" name="cp" value="Code Postal*" />
							<input type="text" name="ville" value="Ville*" />
						</div>
						
						<div class="field_container_for_ie">
							<input type="text" name="email" value="Email*" />
							<input type="text" name="tel" value="Téléphone* (fixe ou mobile)" />
						</div>
						
						<p class="known_txt"><strong>Comment avez-vous connu Showa Best ? *</strong></p>
						
						<ul class="known">
							<li>Visite site internet</li>
							<li>Visite d'un commercial</li>
							<li>Emailing</li>
							<li>Magazine</li>
							<li>Salon</li>
							<li>Utilisateur de gant Showa Best</li>
						</ul>
						
						<p class="allow_newsletter"><span>Oui, j'accepte de recevoir des informations de la part de Showa Best</span></p>
						
						<span class="obligatoires">* champs obligatoires</span>
						
						<a href="#" id="next_step">Suite</a>
						
						<p class="loi">Conformément à la loi informatique et libertés en date du 6 Janvier 1978, vous disposez par ailleurs d'un droit d'accès, de rectification, de modification et de suppression concernant les données qui vous concernent.</p>
						
					</div>
				</div>
				<!--// Step 3 -->
				
				<!-- Step 4 -->
				<div id="participation_ok" style="display: none;">
				
					<p>
						<strong>Votre participation <br />a bien été prise en compte</strong>
						<strong class="good_luck">Bonne chance !</strong>
					</p>
					
				</div>
				<!--// Step 4 -->
				
				<!-- Mentions -->
				<div id="mentions">
					<p>Ce jeu concours n’est pas géré, administré ou parrainé par Facebook.</p>
					<p>Les informations que vous communiquez sont fournies à Showa Best Gloves et non à Facebook.</p>
					<a href="#" target="_blank" id="reglement">Règlement du jeu</a>
					<a href="http://www.showabestglove.eu" target="_blank" id="site">www.showabestglove.eu</a>
				</div>
				<!--// Mentions -->
				
			</div>
			
			<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
			<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.2.min.js"><\/script>')</script>
							
			<script src="js/main.js"></script>
			      
      <script>
          var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
          (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
          g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
          s.parentNode.insertBefore(g,s)}(document,'script'));
      </script>
    </body>
</html>
