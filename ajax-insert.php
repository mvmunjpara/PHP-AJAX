<?php 
$conn = mysqli_connect("localhost","root","","test") or die("Connection Failed!");

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];

$sql = "INSERT INTO students (first_name,last_name) VALUES('{$first_name}','{$last_name}')";

$result = mysqli_query($conn,$sql) or die("SQL Query Failed");

if($result){
	echo 1;
}else{
	echo 0;
}
?>