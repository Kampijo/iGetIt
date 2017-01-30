<?php
require_once __DIR__ . '/../dbconn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <style>
        td input {
            background-color: green;
            display: block;
            width: 200px;
            text-decoration: none;
            padding: 20px;
            color: white;
            text-align: center;
        }
    </style>
    <title>iGetIt</title>
</head>
<body>
<header><h1>iGetIt (student)</h1></header>
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
            <legend> <?php echo($_SESSION['iGetIt']->current_course) ?> </legend>
            <table style="width:100%;">
                <tr>
                    <td><input type="submit" name="submit" value="I Get It" style="background-color:green;"></td>
                    <td><input type="submit" name="submit" value="I Don't Get It" style="background-color:red;"></td>
                </tr>
            </table>
        </fieldset>
    </form>
</main>
<footer>
</footer>
</body>
</html>

