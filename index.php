<?php 

require_once 'vendor/autoload.php';
require_once 'config.php';


function envoiMail($objet, $mailto, $msg, $cci = true)//:string
{
	require 'config.php';
	if(!is_array($mailto)){
		$mailto = [ $mailto ];
	}


	// Create the Transport
	$transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
	->setUsername($defaultmail)
	->setPassword($setPassword);

	// Create the Mailer using your created Transport
	$mailer = new Swift_Mailer($transport);

	// Create a message
	$message = (new Swift_Message($objet))
		->setFrom([$defaultmail]);
	if ($cci){
		$message->setBcc($mailto);
	}else{
		$message->setto($mailto);
	}

	if(is_array($msg) && array_key_exists("html", $msg) && array_key_exists("text", $msg))
	{

		$message->setBody($msg["html"], 'text/html');
		// Add alternative parts with addPart()
		$message->addPart($msg["text"], 'text/plain');

	}else if(is_array($msg) && array_key_exists("html", $msg) ){

		$message->setBody($msg["html"], 'text/html');
		$message->addPart($msg["html"], 'text/plain');

	}else if(is_array($msg) && array_key_exists("text", $msg)){

		$message->setBody($msg["text"], 'text/plain');

	}else if(is_array($msg)){

		die('erreur une clé n\'est pas bonne'); 

	}else{
		$message->setBody($msg, 'text/plain');
	}
	
	// Send the message
	return $mailer->send($message);
}
		session_start();




		if(isset($_SESSION["mail"])){
		envoiMail('Test', 'contact@apprendre.co', 'Richard is a loser');
		unset($_SESSION['mail']);

	}else{
		$_SESSION['mail'] = 'faischier';
		echo "rafrechir la page";
	}	