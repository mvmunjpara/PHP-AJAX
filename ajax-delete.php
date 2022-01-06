<?php 
//delete
$student_id = $_POST["id"];
$conn = mysqli_connect("localhost","root","","test") or die("Connection Failed!");
$sql = "DELETE FROM students WHERE id={$student_id}";

$result = mysqli_query($conn,$sql) or die("SQL Query Failed");

if($result){
	echo 1;
}else{
	echo 0;
}

?>