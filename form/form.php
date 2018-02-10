<?php
if( !empty( $errors ) ) {

	foreach($errors as $key =>$value){ $errors[$key] = '<span class="icon">⚠️<span> '.$value; }
	
	echo arrayToList( $errors, 'error-list' );
}

//var_dump($_POST);

?>

<form method="POST" action="">

	<input type="hidden" name="cmd" value="processForm">

	<input type="text" name="first_name" placeholder="First Name">

	<input type="text" name="last_name" placeholder="Last Name">

	<input type="email" name="email" placeholder="E-mail Address">

	<input type="text" name="phone" placeholder="Phone (555-555-5555)">

	<input type="text" name="company" placeholder="Company">
	
	<?php
	$countries = [ 321=>'USA', 987=>'Canada'];
	echo selectBuilder( 'country', $countries, '', 'key', 'class="foobar"', "Choose a Country");
	?>

	<textarea name="message" placeholder="Your Message"></textarea>

	<div class="wrap-submit"><input type="submit" value="Send"></div>

</form>