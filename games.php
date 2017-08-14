<?php
	require_once('week7.php');

	$sql = "SELECT * FROM game";
	$sqlQuery = new SQL;	

		//execute query
		$result = $sqlQuery->query($sql);

		//Generate CRUD table
		if ($result->num_rows > 0) 
		{ 
			// output data of each row
			echo "<table border='1'><form action='games.php' method='POST'><tr>";
			$i = 0;
			while($row = $result->fetch_assoc())
			{
				echo "<br>";

				//Show headings
				foreach($row as $key =>$r)
				{
					if($i == 0)
					{	
		 				echo "<td>" . $key . " </td>";
					}
				}
				$i = 9001;
				// echo "</tr><tr>";
				echo "</tr><tr>";

				foreach($row as $key =>$r)
				{
					if(isset($_SESSION['edit']))
					{
						$edit = implode($_SESSION['edit']);	

						if($edit == $r)
						{
							foreach($row as $key =>$r)
							{
								echo "<td><input type='text' name='" . $key . "' placeholder='" . $r ."'></td>";
							}
						}
						// $sqlEdit = "UPDATE player SET id='$delete'";
						// mysqli_query($dbc, $sqlDelete) or die("<br><br>Error querying the database");

					}
					else
					{
						echo "<td>" . $r . " </td>";
					}

				}//end foreach
				unset($_SESSION['edit']);	

				// var_dump($edit);

			 	echo "<td><button type='submit' name='delete[]' value='" . $row['id'] . "'>Delete</td>";	
			 	echo "<td><button type='submit' name='edit[]' value='" . $row['id'] . "'>Edit</td>";	
	 			echo "</tr>";
	 			// var_dump($row['id']);
			}//end while
			echo "</form></table>";	}
		else
		{
			echo "0 results";
		}	

?>
<br><br>
<form action="" method="POST">
	<table>
		<tr>
			<th>Add Game:<th>
		</tr>
		<tr>
			<td><label for="title">Title:</label></td>
			<td><input type="text" name="title"></td>
		</tr>
		<tr>
			<td><label for="genre">Genre: </label></td>
			<td><input type="text" name="genre"></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="addGame" value="Add Game"></td>
		</tr>
	</table>
</form>