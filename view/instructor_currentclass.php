<?php
    $dbconn = pg_connect("host=mcsdb.utm.utoronto.ca dbname=lopeznyg_309 user=lopeznyg password=13779");
    $positive=$_SESSION['iGetIt']->getPositivePercent($dbconn)*100;
    $negative=100-$positive;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<style>
			span {
				background-color:green; 
				display:block; 
				text-decoration:none; 
				padding:20px; 
				color:white; 
				text-align:center;
			}
		</style>
		<title>iGetIt</title>
	</head>
	<body>
		<header><h1>iGetIt (instructor)</h1></header>
		<nav>
  			<ul>
                        <li> <a href="">Class</a>
                        <li> <a href="">Profile</a>
                        <li> <a href="">Logout</a>
                        </ul>
		</nav>
		<main>
			<h1>Class</h1>
			<form>
				<fieldset>
					<legend> <?php echo($_SESSION['iGetIt']->current_course) ?></legend>
					<span style="background-color:green; width:<?php echo($positive) ?>%;">i Get It</span>
					<span style="background-color:red;  width:<?php echo($negative) ?>%;">i Don't Get It</span>
				</fieldset>
			</form>
		</main>
		<footer>
		</footer>
	</body>
</html>

