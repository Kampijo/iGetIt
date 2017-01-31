<?php
require_once __DIR__ . '/../dbconn.php';
$positive = $_SESSION['iGetIt']->getPositivePercent($dbconn) * 100;
$negative = $_SESSION['iGetIt']->getNegativePercent($dbconn) * 100;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <meta http-equiv="refresh" content="10">
    <style>
        span {
            background-color: green;
            display: block;
            text-decoration: none;
            padding: 20px;
            color: white;
            text-align: center;
        }
    </style>
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
    <h1>Class</h1>
        <fieldset>
            <legend> <?php echo($_SESSION['iGetIt']->current_course) ?></legend>
            I Get It (<?php echo(round($positive,1)) ?>%)<span style="background-color:green; width:<?php echo($positive) ?>%;"></span>
            I Don't Get It (<?php echo(round($negative,1)) ?>%)<span style="background-color:red;  width:<?php echo($negative) ?>%;"></span>
        </fieldset>
<form method="post">
    <input type="submit" name="submit" value="Reset"/>
</form>
<footer>
</footer>
</body>
</html>

