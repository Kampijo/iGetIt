<?php
    if ($_SESSION['iGetIt']->newuser == true) {
        $user = '';
        $fName = '';
        $lName = '';
        $email = '';
    } else {
        $user = $_SESSION['iGetIt']->user;
        $fName = $_SESSION['iGetIt']->firstName;
        $lName = $_SESSION['iGetIt']->lastName;
        $email = $_SESSION['iGetIt']->email;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <title>iGetIt</title>
</head>
<body>
<header><h1>iGetIt</h1></header>
<nav>
    <form method="post">
        <ul>
            <li><input type="submit" name="submit" value="Class"/>
            <li><input type="submit" name="submit" value="Profile"/>
            <li><input type="submit" name="submit" value="Logout"/>
        </ul>
    </form>
</nav>
<main>
    <h1>Profile</h1>
    <form method=post>
        <fieldset>
            <legend>Edit Profile</legend>
            <p><label for="user">User</label> <input type="text" name="user" value="<?php echo($user); ?>"></p>
            <p><label for="password">Password</label><input type="password" name="password"></p>
            <p><label for="firstName">First Name</label><input type="text" name="firstName"
                                                               value="<?php echo($fName); ?>"></p>
            <p><label for="lastName">Last Name</label><input type="text" name="lastName" value="<?php echo($lName); ?>">
            </p>
            <p><label for="email">email</label><input type="text" name="email" value="<?php echo($email); ?>"></p>
            <p><label for="type">type</label>
                <input type="radio" name="type" value="instructor" checked>instructor</input>
                <input type="radio" name="type" value="student">student</input>
            </p>
            <p><input type="submit" name="submit" value="Submit"/>
                <?php echo(view_errors($errors)); ?>
        </fieldset>
    </form>
</main>
<footer>
</footer>
</body>
</html>

