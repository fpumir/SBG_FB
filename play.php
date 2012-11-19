<?php
header("Access-Control-Allow-Origin: *");

$fields = array(
	'civilite' => true,
	'nom' => true,
	'prenom' => true,
	'societe' => false,
	'fonction' => false,
	'adresse' => true,
	'cp' => true,
	'ville' => true,
	'email' => true,
	'tel' => true
);

foreach($fields as $key => $value){
	
	if($value){
		if(empty($_POST['user'][$key])){
			echo json_encode(array('success' => false, 'error' => 'fields missing'));
			die();
		}
	}

	$$key = addSlashes(strip_tags(utf8_decode($_POST['user'][$key])));
}

if(count($_POST['known']) < 1){ echo json_encode(array('success' => false, 'error' => 'fields missing')); die(); }
if(count($_POST['quizz']) != 3){ echo json_encode(array('success' => false, 'error' => 'quizz missing')); die(); }

$query = 'INSERT INTO players(civilite, name, firstname, company, fonction, adress, cp, ville, email, known, quizz, newsletter, date) VALUES(\''.$civilite.'\', \''.$nom.'\', \''.$prenom.'\', \''.$societe.'\', \''.$fonction.'\', \''.$adresse.'\', \''.$cp.'\', \''.$ville.'\', \''.$email.'\', \''.addslashes(serialize($_POST['known'])).'\', \''.addslashes(serialize($_POST['quizz'])).'\', \''.addslashes(strip_tags($_POST['user']['newsletter'])).'\', NOW())';

require_once('config.php');

if(mysql_connect($host, $user, $password) && mysql_select_db($db)){
	if(mysql_query($query)){
		echo json_encode(array('success' => true)); die();
	}else{
		$query_check_mail = mysql_query("SELECT id FROM players WHERE email = '".$email."' LIMIT 0,1");
		$check_mail = mysql_num_rows($query_check_mail);
		if($check_mail == 1){
			echo json_encode(array('success' => false, 'error' => 'already')); die();
		}else{
			echo json_encode(array('success' => false, 'error' => 'sql error')); die();
		}
	}
}
else
{
	echo json_encode(array('success' => false, 'error' => 'sql connection error')); die();
}

?>