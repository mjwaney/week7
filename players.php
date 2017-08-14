<?php
	require_once('week7.php');

	$sql = "SELECT * FROM player ORDER BY firstname";
	$sqlQuery = new SQL;	
	$result = $sqlQuery->query($sql);

	if(isset($_POST['update']))
	{
		$id = $_POST['id'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];


		$sqlUpdate = "UPDATE player SET firstname='$firstname', lastname='$lastname', username='$email' WHERE id='$id'";
		
		$sqlQuery->query($sqlUpdate);
	}
					
	//Generate CRUD table
	if ($result->num_rows > 0) 
	{ 
		// output data of each row
		echo "<table border='1'><form action='players.php' method='POST'><tr>";
		$i = 0;

		while($row = $result->fetch_assoc())
		{
			//Show headings
			foreach($row as $key =>$r)
			{
				if($i == 0)
				{	
	 				echo "<td>" . $key . " </td>";
				}
			}
			$i = 9001;
			echo "</tr><tr>";
			// var_dump(count($row));
			//Print out all rows
			foreach($row as $key =>$r)
			{
				//edit row		
				if(isset($_POST['edit']))
				{
					$_SESSION['edit'] = $_POST['edit'];

					$edit = implode($_SESSION['edit']);	

					if($edit == $r)
					{
						echo "<tr><form action='' method='POST'>";
						foreach($row as $key =>$r)
						{
							echo "<td><input type='text' name='" . $key . "' placeholder='" . $r ."'></td>";
						}
						echo "<td><button type='submit' name='update'>Update</td>";
						echo "</form></tr>";
					}
				}
				echo "<td>" . $r . " </td>";
			}
		 	echo "<td><button type='submit' name='delete[]' value='" . $row['id'] . "'>Delete</td>";	
		 	echo "<td><button type='submit' name='edit[]' value='" . $row['id'] . "'>Edit</td></tr>";
		}//end while
		echo "</form></table>";	}
	else
	{
		echo "0 results";
	}	

	unset($_SESSION['edit']);	

?>
<br><br>
<form action="" method="POST">
	<table>
		<tr>
			<th>Add Player Record:<th>
		</tr>
		<tr>
			<td><label for="firstname">First Name:</label></td>
			<td><input type="text" name="firstname"></td>
		</tr>
		<tr>
			<td><label for="lastname">Last Name:</label></td>
			<td><input type="text" name="lastname"></td>
		</tr>
		<tr>
			<td><label for="email">Email: </label></td>
			<td><input type="text" name="email"></td>
		</tr>
		<tr>
			<td><label for="reg_date">Subscribed until: </label></td>
			<td><input type="date" name="reg_date" placeholder="dd-mm-yy"></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="addPlayer" value="Add Record"></td>
		</tr>
	</table>
</form>