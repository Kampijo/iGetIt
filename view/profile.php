<?php
    if(isset($_GET['logout'])){
        unset($_SESSION);
    } else {
        if ($_SESSION['iGetIt']->newuser == true) {
            $user = '';
            $fName = '';
            $lName = '';
            $email = '';
        } else {
            $user = $_SESSION['iGetIt']->user;
            $fName = $_SESSION['iGetIt']->fName;
            $lName = $_SESSION['iGetIt']->lName;
            $email = $_SESSION['iGetIt']->email;
        }
    }

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
                        <li> <a href="?logout">Logout</a>
                        </ul>

		</nav>
		<main>
			<h1>Profile</h1>
			<form method=post novalidate>
				<fieldset>
					<legend>Edit Profile</legend>
					<p> <label for="user">User</label>    <input type="text" name="user" value="<?php echo($user); ?>"> </p>
					<p> <label for="password">Password</label><input type="password" name="password"> </p>
					<p> <label for="firstName">First Name</label><input type="text" name="firstName" value="<?php echo($fName); ?>"> </p>
					<p> <label for="lastName">Last Name</label><input type="text" name="lastName" value="<?php echo($lName); ?>"> </p>
					<p> <label for="email">email</label><input type="text" name="email" value="<?php echo($email); ?>"> </p>
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

