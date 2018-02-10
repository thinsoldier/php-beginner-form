<?php 
include 'form/page-controller.php';
?><!doctype html>
<html>
<head>
<meta charset="UTF-8">
</head>
<body>
<header>
	<h1>Website header name and logo</h1>
	<ul>
		<li><a href="#">My</a></li>
		<li><a href="#">site </a></li>
		<li><a href="#">main</a></li>
		<li><a href="#">navigation</a></li>
		<li><a href="#">list</a></li>
	</ul>
</header>
<main>
	<h2>Contact Us</h2>
	<?=$form_content?>
</main>

<footer>
&copy; <?=date('Y')?>
</footer>
</body>
</html>
