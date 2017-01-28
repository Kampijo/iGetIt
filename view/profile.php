<?php
// So I don't have to deal with unset $_REQUEST['user'] when refilling the form
$_REQUEST['user']=!empty($_REQUEST['user']) ? $_REQUEST['user'] : '';
$_REQUEST['password']=!empty($_REQUEST['password']) ? $_REQUEST['password'] : '';
$_REQUEST['firstName']=!empty($_REQUEST['password']) ? $_REQUEST['firstName'] : '';
$_REQUEST['lastName']=!empty($_REQUEST['password']) ? $_REQUEST['lastName'] : '';
$_REQUEST['email']=!empty($_REQUEST['password']) ? $_REQUEST['email'] : '';
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>iGetIt</title>
	</head>
	<body>
		<header><h1>iGetIt</h1></header>
		<nav>
			<ul>
                        <li> <a href="">Class</a>
                        <li> <a href="">Profile</a>
                        <li> <a href="">Logout</a>
                        </ul>

		</nav>
		<main>
			<h1>Profile</h1>
			<form method=post>
				<fieldset>
					<legend>Edit Profile</legend>
					<p> <label for="user">User</label>    <input type="text" name="user" value="<?php echo($_REQUEST['user']); ?>"> </p>
					<p> <label for="password">Password</label><input type="password" name="password" value="<?php echo($_REQUEST['password']); ?>"> </p>
					<p> <label for="firstName">First Name</label><input type="text" name="firstName" value="<?php echo($_REQUEST['firstName']); ?>"> </p>
					<p> <label for="lastName">Last Name</label><input type="text" name="lastName" value="<?php echo($_REQUEST['lastName']); ?>"> </p>
					<p> <label for="email">email</label><input type="text" name="email" value="<?php echo($_REQUEST['email']); ?>"> </p>
					<p> <label for="type">type</label>
						<input type="radio" name="type" value="instructor" checked>instructor</input>
						<input type="radio" name="type" value="student">student</input>
					</p>
					<p> <input type="submit" name="submit" value="Submit" />
                        <?php echo(view_errors($errors)); ?>
				</fieldset>
			</form>
		</main>
		<footer>
		</footer>
	</body>
</html>

