<!doctype html>

<html>
<head>
	<title>Feedback Form</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="styles.css">
	<style>
		fieldset, legend, label, select, input {
			margin-bottom: .5em;
		}

		fieldset {
			border: thin gold solid;
		}
		legend {
			font-weight:bold;
		}

		.results {
			border: medium gold solid;
			margin-top: 1em;
			padding: .5em;
			background-color: lightgray;
		}
		
		#everything {
		width: 800px;
			
		}

	

		.floatLeft {
			float: left;
		}


		label {
			display: inline-block;
			width:100px;
			margin-right:100px;
		}
		main {
			clear: both;
			font-family: Verdana, Geneva, sans-serif;
		}
		
		.capitalize:first-letter {
		  text-transform: capitalize;
		  font-family: times;
		  color: 	#6A5ACD;
		  font-size: 30px;
		  }
		

		
		ul {
			list-style-type: none;
		}

		li {
			float: left;
			padding: 0 2em;
		}

		li a {
			font-weight:bold;
			font-size: 1.5em;
		}

		#youarehere {
			text-decoration: none;
		}

		li:first-child {
			border-right: thick solid black;
		}

		article img {
			width: 300px;
			height: 200px;
		}

	</style>
	
</head>

<body>
	<div id="everything">
	<header>
		<div id="headertext" class="floatLeft">
			<h1>Feedback Form</h1>
			<nav>
				<ul>
					<li><a href="feedbackform.html">Form</a></li>
				</ul>
			</nav>
		</div>
	</header>
	<main>
		<article>
			<br>
			<h2>Thanks for submitting!</h2>
			<p class="capitalize">Please find the answers you submitted below, as well as the summary and average of all answers so far.</p>
			
			<?php

displayPostArray($_POST);

function displayPostArray ($postarray) {
	foreach ($postarray as $field => $score) {
		echo ("$field" . " = " . "$score<br>");
	}
}

function mysql_fix_string($string) {
	if (get_magic_quotes_gpc()) $string = stripslashes($string);
	return mysql_real_escape_string($string);
}

require_once 'login.php'; // this looks for a file
	$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
	mysql_select_db($db_database) or die("Unable to select database: " . mysql_error()); 

if (isset($_POST['Java']) && 
	isset($_POST['C']) && 
	isset($_POST['Python']) && 
	isset($_POST['R']) && 
	isset($_POST['HCJ']) && 
	isset($_POST['PHP'])
	) 
{
	$Java = mysql_fix_string($_POST['Java']);
	$C = mysql_fix_string($_POST['C']);
	$Python = mysql_fix_string($_POST['Python']);
	$R = mysql_fix_string($_POST['R']);
	$HCJ = mysql_fix_string($_POST['HCJ']);
	$PHP = mysql_fix_string($_POST['PHP']);
	$query = "INSERT INTO techskills (Java, C, Python, R, HCJ, PHP) VALUES" .
		"('$Java','$C', '$Python', '$R', '$HCJ', '$PHP')";
		if (!mysql_query($query, $db_server))
			echo "INSERT failed: $query<br>" . 
			mysql_error() . "<br><br>";
}

$query = "SELECT * FROM techskills";
$result = mysql_query($query, $db_server);
if (!$result) die("Database access failed: " . mysql_error());
$rows = mysql_num_rows($result);

echo ("<br>Display sum and average scores for table.");
$query = "SELECT SUM(Java), SUM(C), SUM(Python), SUM(R), SUM(HCJ), SUM(PHP) FROM techskills";
$result = mysql_query($query, $db_server);
if (!$result) die ("Database access failed: " . mysql_error());

$firstrow = mysql_fetch_row($result);
echo "<div class=\"results\">";
echo '<b>Java</b>: SUM = <b>' . $firstrow[0] . '</b> and AVE = <b>' . number_format($firstrow[0] / $rows, 2) . '</b><br>';
echo '<b>C</b>: SUM = <b>' . $firstrow[1] . '</b> and AVE = <b>' . number_format($firstrow[1] / $rows, 2) . '</b><br>';
echo '<b>Python</b>: SUM = <b>' . $firstrow[2] . '</b> and AVE = <b>' . number_format($firstrow[2] / $rows, 2) . '</b><br>';
echo '<b>R</b>: SUM = <b>' . $firstrow[3] . '</b> and AVE = <b>' . number_format($firstrow[3] / $rows, 2) . '</b><br>';
echo '<b>HCJ</b>: SUM = <b>' . $firstrow[4] . '</b> and AVE = <b>' . number_format($firstrow[4] / $rows, 2) . '</b><br>';
echo '<b>PHP</b>: SUM = <b>' . $firstrow[5] . '</b> and AVE = <b>' . number_format($firstrow[5] / $rows, 2) . '</b><br>';
echo "</div>";
?>

		</article>
	</main>
	<footer>
		<p>This site is (c) <script>new Date().getFullYear()>2010&&document.write(new Date().getFullYear());</script> Bhuwan Agarwal.</p>
	</footer>
	</div>
</body>
</html>