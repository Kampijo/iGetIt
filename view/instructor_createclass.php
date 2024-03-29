<?php
require_once __DIR__ . '/../dbconn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <title>iGetIt</title>
</head>
<body>
<header><h1>iGetIt (instructor)</h1></header>
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
    <h1>Class</h1>
    <form method="post">
        <fieldset>
            <legend>Create Class</legend>
            <p><label for="class">class</label><input type="text" name="class"></p>
            <p><label for="code">code</label><input type="text" name="code"></p>
            <p><input type="submit" name="submit" value="create"/>
        </fieldset>
    </form>
    <form method="post" id="courses">
        <fieldset>
            <legend>Current Classes</legend>
            <?php echo "<select name='courses' form='courses'>";
            $result = $_SESSION['iGetIt']->getAvailableClasses($dbconn);
            while ($row = pg_fetch_array($result)) {
                echo "<option value='" . $row['name'] . "'>"
                    . $row['name'] . " " . $row['instructor'] . "</option > ";
            }
            echo '</select>';
            ?>
            <p><label for="code">code</label><input type="text" name="code"></p>
            <p><input type="submit" name="submit" value="join"/>
                <?php echo(view_errors($errors)); ?>
        </fieldset>
    </form>

</main>
<footer>
</footer>
</body>
</html>

