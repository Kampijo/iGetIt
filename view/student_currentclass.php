<?php
    $dbconn = pg_connect("host=mcsdb.utm.utoronto.ca dbname=lopeznyg_309 user=lopeznyg password=13779");
    if(isset($_POST['response'])){
        $_SESSION['iGetIt']->studentResponse($dbconn,$_POST['response']);
    }
    if(isset($_GET['logout'])){
        session_destroy();
        header("Refresh:0");
    }
    if(isset($_GET['profile'])){
        $_SESSION['state'] = 'profile';
        $view = "profile.php";
        header("Refresh:0");
    }
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<style>
			td input {
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
                        <li> <a href="?profile">Profile</a>
                        <li> <a href="?logout">Logout</a>
                        </ul>
		</nav>
		<main>
			<h1>Class</h1>
			<form method="post" action="">
				<fieldset>
					<legend> <?php echo($_SESSION['iGetIt']->current_course) ?> </legend>
					<table style="width:100%;">
						<tr>
							<td><input type="submit" name="response" value="I Get It" style="background-color:green;"></td>
							<td><input type="submit" name="response" value="I Don't Get It" style="background-color:red;"></td>
						</tr>
					</table>
				</fieldset>
			</form>
		</main>
		<footer>
		</footer>
	</body>
</html>

