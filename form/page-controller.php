<?php
include 'functions/arrayToList.php';
include 'functions/selectBuilder.php';

ob_start();
route_to_appropriate_function();
$form_content = ob_get_clean();

//-----------------------------

// figures out which function to run based on "cmd" in GET or POST
function route_to_appropriate_function()
{
	$cmd = null;
	if( isset(  $_GET['cmd']) ){ $cmd =  $_GET['cmd']; }
	if( isset( $_POST['cmd']) ){ $cmd = $_POST['cmd']; }
	
	if( !$cmd ){ $cmd = 'showForm'; }
	
	// What functions are allowed to be triggered by the "cmd" param:
	$allowed = ['showForm','processForm','showSuccess'];
	
	// Run the requested function:
	$allowed = array_combine($allowed , $allowed);
	if( isset($allowed[$cmd]) && function_exists($allowed[$cmd]) )
	{
		$cmd = $allowed[$cmd];
		// var_dump($cmd);
		$cmd();
	} else { exit('INVALID REQUEST'); }
}

function showForm( $errors=[], $values=[] ) { include 'form.php'; }

function showSuccess() { include 'success.php'; }

function redirectToSuccess() { header("Location: ?cmd=showSuccess"); exit; }

function validate( $input )
{ 
	$output = [];

	// No field may contain these strings:
	$bad = array("content-type","bcc:","to:","cc:","href");
	foreach( $input as $key => $value )
	{
		$haystack = $value;
		foreach( $bad as $needle )
		{
			$pos = strpos($haystack, $needle);
			if( $pos !== false ){ $output[] = "“ {$needle} ” is not allowed in any field!"; }
		}
	}

	// All of these fields must be present and not empty:
	$required = ['first_name','last_name','email','phone','company','country','message'];
	foreach($required as $field)
	{
		if ( ! isset( $input[$field]) || empty($input[$field] ) )
		{ 
			$nicename = str_replace('_',' ',$field);
			$nicename = ucwords($nicename);
			$output[] = "$nicename is required.";
		}
	}	
	
	// E-mail must be formatted correctly.
	if ( ! filter_var( $input['email'], FILTER_VALIDATE_EMAIL ) )
	{
		$output[] = "The e-mail address was not formatted correctly";
	}
	
	$message = $input[ 'message' ];
	
	// Message must be less than 1280 characters
	if( strlen($message) > 1280 ){ $output[] = 'Your message is too long.'; }
	
	// Message must be longer than one word and words should have spaces between them.
	if( strlen($message) < 5 ){ $output[] = 'Your message is too short.'; }
	
	// ... other validations ...
	
	return $output;
}

function buildMailBodyTemplate(){  }

function sendMail()
{
	include 'phpmailer-gmail.php';
	
	return false;
	//return true; 
}

function processForm()
{ 
	$errors = validate($_POST);

	if( !empty($errors) )
	{ showForm($errors,$_POST); return; }
	else 
	{
		$mailBody = buildMailBodyTemplate($_POST);
		$did_it_send = sendMail( $_POST, $mailBody );
		if( $did_it_send )
			{ redirectToSuccess(); return; }
		else {
			$messages = [
				'There were no problems with your information but the message failed to send.', 
				'Please try again in a few minutes or e-mail us directly at developer@example.com'];
			showForm( $messages, $_POST );
		}
	}
}