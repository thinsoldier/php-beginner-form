<?php
if( !empty( $errors ) ) {
	echo arrayToList( $errors, 'error-list' );
}

?>

<form method="POST" action="">

	<input type="hidden" name="cmd" value="processForm">

	<input type="text" name="first_name" placeholder="First Name">

	<input type="text" name="last_name" placeholder="Last Name">

	<input type="email" name="email" placeholder="E-mail Address">

	<input type="email" name="phone" placeholder="Phone (555-555-5555)">

	<input type="text" name="company" placeholder="Company">

	<textarea name="message" placeholder="Your Message"></textarea>

	<input type="submit" value="Send">

</form>