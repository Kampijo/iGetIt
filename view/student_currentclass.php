<?php
$dbconn = pg_connect("host=mcsdb.utm.utoronto.ca dbname=lopeznyg_309 user=lopeznyg password=13779");
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<style>
			td a {
				background-color:green; 
				display:block; 
				width:200px; 
				text-decoration:none; 
				padding:20px; 
				color:white; 
				text-align:center;
			}
		</style>
		<title>iGetIt</title>
	</head>
	<body>
		<header><h1>iGetIt (student)</h1></header>
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
					<legend> <?php echo($_SESSION['courses']) ?> </legend>
					<table style="width:100%;">
						<tr>
							<td><a style="background-color:green;" href="<?php $_SESSION['iGetIt']->studentResponse($dbconn,$_SESSION['courses'],1)?>">i Get It</a></td>
							<td><a style="background-color:red;  " href="<?php $_SESSION['iGetIt']->studentResponse($dbconn,$_SESSION['courses'],0)?>">i Don't Get It</a></td>
						</tr>
					</table>
				</fieldset>
			</form>
		</main>
		<footer>
		</footer>
	</body>
</html>

