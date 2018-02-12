<?php
// $errors and $values are set by the showForm function that includes this file.
// $values is an object that can be invoked like a function.
// $values will echo the value of requested key from $_POST if it exists.
// This is useful when displaying the form after it 
// has been submitted and there as a validation error.

if( !empty( $errors ) ) {

	foreach($errors as $key =>$value){ $errors[$key] = '<span class="icon">⚠️<span> '.$value; }
	
	echo arrayToList( $errors, 'error-list' );
}

//var_dump($_POST);

?>

<form method="POST" action="">

	<input type="hidden" name="cmd" value="processForm">

	<input type="text" name="first_name" placeholder="First Name" value="<?=$values('first_name')?>">

	<input type="text" name="last_name" placeholder="Last Name" value="<?=$values('last_name')?>">

	<input type="email" name="email" placeholder="E-mail Address" value="<?=$values('email')?>">

	<input type="text" name="phone" placeholder="Phone (555-555-5555)" value="<?=$values('phone')?>">

	<input type="text" name="company" placeholder="Company" value="<?=$values('company')?>">
	
	<?php
	$countries = [ 321=>'USA', 987=>'Canada'];
	echo selectBuilder( 'country', $countries, $values('country'), 'key', 'class="foobar"', "Choose a Country");
	?>

	<textarea name="message" placeholder="Your Message"><?=$values('message')?></textarea>

	<div class="wrap-submit"><input type="submit" value="Send"></div>

</form>