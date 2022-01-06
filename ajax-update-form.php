<?php 
//ajax-update-form.php
	$student_id = $_POST['id'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	
	$conn = mysqli_connect("localhost","root","","test") or die("Connection Faild");

	$sql = "UPDATE students SET first_name='$first_name', last_name='{$last_name}' WHERE id=$student_id";

	$result = mysqli_query($conn,$sql) or die("SQL Query Failed");

	if($result){
		echo 1;
	}else{
		echo 0;
	}
?>