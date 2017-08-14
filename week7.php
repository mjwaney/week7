<?php

require_once("../week8/SQL.php");
// · Ontwikkel een applicatie waarmee je records van een relationele database kan bekijken, toevoegen, bewerken, verwijderen. Gebruik hiervoor PDO of de MySQLi functies. De relationele database bevat minimaal 4 tabellen en pas alle soorten relaties toe: one-to-one, one-to-many, en many-to-many.

// · Pas in je database tabellen zowel numerieke als string data types toe.

// · Pas ook verschillende datum/tijden toe in je tabellen; deze worden volgende week weer gebruik. Denk bijv aan een geboortedatum, ‘registered date’ en een ‘last login date’.

// · Zorg er voor dat je ook prepared statements toe past.

// · Pas bij de SELECT queries ook ORDER BY, en GROUP BY toe

// · Pas PRIMARY KEY & FOREIGN KEY toe in de tabellen van je relationele database

	/*	1-1 A player uses one controller, a controller belongs to one player
		1-* A player has zero to many savegames, a savegame belongs to one player
		*-* A player has played zero to many games, games are being played by zero to many players 	*/
	//Forms
	?>
	<form action="" method="post">
		<input type="submit" name="submit" value="Index">
		<input type="submit" name="submit" value="Show Players">
		<input type="submit" name="submit" value="Show Games">
	</form>
	<?php
	if(!isset($_SESSION)) {
	     session_start();
	}

	if(isset($_POST['submit']))
	{
		switch($_POST['submit'])
		{	
			case "Index":
				header('week7.php');
				break;
			case "Show Players":
				include_once 'players.php';
				break;
			case "Show Games":
				include_once 'games.php';
				break;
			default:
				$sql = "SELECT *";
		}
	}

	/**
	 * Get sql query as input and return the executed query
	 * @param String
	 * @return $result
	 */
	// class SQL
	// {
	// 	function query(String $sql)
	// 	{
	// 		//1. Connect with mysqli_connect
	// 		$dbc = mysqli_connect("localhost", "root", "", "week7") or die("Error connecting to MYSQL server");
			
	// 		//3. Execute the Queries
	// 		$result = mysqli_query($dbc, $sql) or die("<br><br>Error querying the database");

	// 		return $result;

	// 		// 4. Close the connection
	// 		mysqli_close($dbc);	
	// 	}
	// }

	$sqlQuery = new SQL;
	$edit = null;

	if(isset($_POST['addPlayer']))
	{
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];
		$reg_date = $_POST['reg_date'];

		$sqlAdd = "INSERT INTO player (firstname, lastname, email, reg_date) VALUES ('$firstname', '$lastname', '$email', '$reg_date')";

		$sqlQuery->query($sqlAdd);
	}

	if(isset($_POST['addGame']))
	{
		$title = $_POST['title'];
		$genre = $_POST['genre'];

		$sqlAddGame = "INSERT INTO game (title, genre) VALUES ('$title', '$genre')";

		$sqlQuery->query($sqlAddGame);
	}

	//Prepared statement
	$dbc = mysqli_connect("localhost", "root", "", "week7") or die("Error connecting to MYSQL server");

	$sqlPrep = $dbc->prepare("INSERT INTO player (firstname, lastname, email, reg_date) VALUES (?, ?, ?, ?)");

	$sqlPrep->bind_param("ssss", $nam, $lnam, $exp);

	$nam = 'fhw';
	$lnam = 'adw';
	$mail = 'wfdw@fe.com';
	$exp = '2022-11-01';
	$sqlPrep->execute();

	$nam = 'fhadwww';
	$lnam = 'aadwddw';
	$mail = 'wfwddw@fe.com';
	$exp = '2112-11-01';
	$sqlPrep->execute();

	$sqlPrep->close();
	$dbc->close();

	if(isset($_POST['delete']))
	{
		$delete = implode($_POST['delete']);
		var_dump($delete);
		$sqlDelete = "DELETE FROM player WHERE id='$delete'";
		$sqlQuery->query($sqlDelete);
	}
		
// · Experimenteer met SELECT, INSERT, UPDATE, DELETE SQL queries met de andere techniek dan je hierboven hebt gekozen (dus PDO of de MySQLi functies).
	$host = 'localhost';
	$db = 'week7';
	$user = 'root';
	$pass = '';
	$charset = 'utf8';

	$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
	$opt = [
		PDO::ATTR_ERRMODE			=> PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE	=> PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES	=> false,
	];
	$pdo = new PDO($dsn, $user, $pass, $opt);

	//SELECT
	$stmt = $pdo->query('SELECT * FROM player');
	
	//INSERT
	$stmt2 = $pdo->query('INSERT INTO player (firstname, lastname, email, reg_date) VALUES ("blah", "blahblah", "wdhiwdh@dfw.com", "2015-07-21")');

	//UPDATE
	$stmt3 = $pdo->query('UPDATE player SET firstname = "Justine" WHERE firstname = "Justin"');
	
	//DELETE
	$stmt4 = $pdo->query('DELETE FROM player WHERE firstname = "blah"');
	
	//execute
	while($row = $stmt4->fetch())
	{
		echo $row['name'] . "\n";
	}

// · Experimenteer bij SELECT queries ook met AVG, COUNT, DISTINCT COUNT, MIN, MAX en SUM. Mag in SQL-file gezet worden, maar ook via een PHP-script.
	?><form action="" method="post">
		<input type="radio" name="calc" value="avg">Average
		<input type="radio" name="calc" value="count">Count
		<input type="radio" name="calc" value="distinct">Distinct Count
		<input type="radio" name="calc" value="min">Min
		<input type="radio" name="calc" value="max">Max
		<input type="radio" name="calc" value="sum">Sum
		<input type="submit" name="calculate" value="Calculate">
	</form><?php

	if(isset($_POST['calculate']))
	{
		switch($_POST['calc'])
		{
			case "avg":
				$sqlCalc = "SELECT AVG(id) FROM player";
				break;
			case "count":
				$sqlCalc = "SELECT COUNT(id) FROM player";
				break;
			case "distinct":
				$sqlCalc = "SELECT COUNT(DISTINCT(id)) FROM player";
				break;
			case "min":
				$sqlCalc = "SELECT MIN(id) FROM player";
				break;
			case "max":
				$sqlCalc = "SELECT MAX(id) FROM player";
				break;
			case "sum":
				$sqlCalc = "SELECT SUM(id) FROM player";
				break;
			default:
				$sqlCalc = "SELECT *";
				break;
		}
		$result = $sqlQuery->query($sqlCalc);

		print_r($result->fetch_assoc());
	}
// · Schrijf een CREATE DATABASE & CREATE TABLE SQL querie voor de database van je applicatie. Mag in SQL-file gezet worden, maar ook via een PHP-script.

	// Create database
	$sqlCreateDB = "CREATE DATABASE new";
	//$sqlQuery->query($sqlCreateDB);

	// Create table
	$sqlCreateTable = "CREATE TABLE person (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, firstname VARCHAR(30) NOT NULL, lastname VARCHAR(30) NOT NULL, email VARCHAR(50), reg_date TIMESTAMP)";
	//$sqlQuery->query($sqlCreateTable);

// · Schrijf een SQL DROP query voor zowel table als schema.
	$sqlDropTable = "DROP TABLE person";
	$sqlDropSchema = "DROP DATABASE new";

// · Experimenteer met een SQL INNER JOIN , LEFT JOIN en RIGHT JOIN

	$joinQuery = "SELECT player.firstname, controller.color FROM player INNER JOIN controller ON player.id = controller.player_id";	
	$sqlJoin = new SQL;
	$joinResult = $sqlJoin->query($joinQuery);
	foreach($joinResult as $j)
	{
		echo "Join: $j <br>";
	}

	$leftJoinQuery = "SELECT player.firstname, controller.color FROM player LEFT JOIN controller ON player.id = controller.player_id ORDER BY player.firstname";
	
	$leftJoinResult = $sqlJoin->query($leftJoinQuery);

	foreach($leftJoinResult as $j)
	{
		echo "Left Join: $j <br>";
	}

	$rightJoinQuery = "SELECT player.firstname, controller.color FROM player RIGHT JOIN controller ON player.id = controller.player_id ORDER BY player.firstname";
	
	$rightJoinResult = $sqlJoin->query($rightJoinQuery);

	foreach($rightJoinResult as $j)
	{
		echo "Right Join: $j <br>";
	}
// · Experimenteer met SQL TRANSACTIONS 

	$dbc = mysqli_connect("localhost", "root", "", "week7");

	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}

	mysqli_begin_transaction($dbc, MYSQLI_TRANS_START_READ_ONLY);

	$names = mysqli_query($dbc, "SELECT firstname, lastname FROM player");
	$dates = mysqli_query($dbc, "SELECT reg_date FROM player");
	$titles =mysqli_query($dbc, "SELECT title FROM game");
	
	if ($names and $dates and $titles) 
	{	
		var_dump("YAY");
		mysqli_commit($dbc);
	} 
	else 
	{        
		var_dump("NAY");
		mysqli_rollback($dbc);
	}

	mysqli_close($dbc);

?>