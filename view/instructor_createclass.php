<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css" />
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
			<form method="post">
				<fieldset>
					<legend>Create Class</legend>
   					<p> <label for="class">class</label><input type="text" name="class"></p>
   					<p> <label for="code">code</label><input type="text" name="code"></p>
                    <p> <input type="submit" name="submit" value="create" />
				</fieldset>
			</form>
 			<form method="post" id="courses">
                <fieldset>
                    <legend>Current Classes</legend>
                    <?php echo "<select name='courses' form='courses'>";
                        while($row=pg_fetch_array($_SESSION['iGetIt']->getAvailableClasses($_SESSION['dbconn'])))
                        {
                        echo '<option value="' . $row['name'] . '">'
                            . $row['name'] . " " . $row['instructor']
                            . '</option>';
                        }
                        echo '</select>';
                    ?>
                    <p> <label for="code">code</label><input type="text" name="code"> </p>
                    <p> <input type="submit" name="submit" value="join" />
                </fieldset>
            </form>

		</main>
		<footer>
		</footer>
	</body>
</html>

