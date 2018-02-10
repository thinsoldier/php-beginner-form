<?php

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

function validate()
{ 
	return ['an error message'];
	//return [];
}

function buildMailBodyTemplate(){  }

function sendMail()
{
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
		  $messages = ['There were no problems with your information but the message failed to send. Please try again in a few minutes or e-mail us directly at developer@example.com'];
		  showForm( $messages, $_POST );
		}
	}
}