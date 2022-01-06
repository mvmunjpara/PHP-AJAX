<?php
$search_value = $_POST["search"];

$conn = mysqli_connect("localhost","root","","test") or die("Connection Failed");


$sql = "SELECT * FROM students WHERE first_name LIKE '%{$search_value}%' OR last_name LIKE '%{$search_value}%'";

$result = mysqli_query($conn,$sql) or die("SQL Query Failed");
$output = "";
if(mysqli_num_rows($result)>0){
	$output = '<table border="1" width="100%" cellspacing="0" cellppading="10px">

		<tr>
			<td width="100px">ID</td>
			<td>NAME</td>
			<td>EDIT</td>
			<td width="100px">DELETE</td>
		</tr>';
		while($row=mysqli_fetch_assoc($result)){
			$output .="<tr>
			<td>{$row["id"]}</td>
			<td>{$row["first_name"]} {$row["last_name"]}</td>
			<td><button class='edit-btn' data-esid='{$row["id"]}'>EDIT</button></td>
			<td><button class='delete-btn' data-id='{$row["id"]}'>DELETE</button></td>
			</tr>";
		}
		$output .="</table>";
		mysqli_close($conn);
		echo $output;
}else{
	echo "<h2>Now Record Found</h2>";
}
?>