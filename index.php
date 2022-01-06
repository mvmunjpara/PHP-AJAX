<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>AJAX INSERT</title>
	<style type="text/css">
		#header{
			background: orange;
		}
		#table-form{
			background: skyblue;
		}
		#table-data th{
			background: #74b9ff;
		}
		#table-data tr:nth-child(odd){
			background: #ecf0f1;
		}
		body{background: lightgray;}
		#success-message{
			background: #DEF1D8;
			color: green;
			padding: 10px;
			margin: 10px;
			display: none;
			position: absolute;
			right: 15px;
			top: 15px;
		}
		#error-message{
			background: #EDFCDD;
			color: red;
			padding: 10px;
			margin: 10px;
			display: none;
			position: absolute;
			right: 15px;
			top: 15px;

		}
		.delete-btn{
			background: red;
			color: white;
			border: 0;
			padding: 4px 10px;
			border-radius: 3px;
			cursor: pointer;
		}
		.edit-btn{
			background: green;
			color: white;
			border: 0;
			padding: 4px 10px;
			border-radius: 3px;
			cursor: pointer;
		}
		#modal{
			background: rgba(0,0,0,0.7);
			position: fixed;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			z-index: 100;
			display: none;
		}
		#modal-form{
			background: white;
			width: 40%;
			position: relative;
			top: 20%;
			left: calc(50% - 25%);
			padding: 15px;
			border-radius: 4px;
		}
		#modal-form h2{
			margin: 0 0 15px;
			padding-bottom: 10xp;
			border-bottom: 1px solid;
		}
		#close-btn{
			background: red;
			color: white;
			width: 30px;
			height: 30px;
			line-height: 30px;
			text-align: center;
			border-radius: 50%;
			position: absolute;
			top: -15px;
			right: -15px;
			cursor: pointer;
		}
	</style>
</head>
<body >
<table id="main" border="1" cellspacing="0" align="center" >
	<tr>
		<td id="header">
			<h1>Add Records With PHP & AJAX</h1>
			<div id="search-box">
			<label>Search:</label>
			<input type="text" id="search" autocomplete="off">
		</div>
		</td>
		
	</tr>
	<tr>
		<td id="table-form" >
			<form id="addForm">
			First Name:<input type="text" id="fname">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Last Name:<input type="text" id="lname">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" id="save-button" value="Save">
			</form>
		</td>
	</tr>
	<tr>
		<td id="table-data">
		</td>
	</tr>
</table>
	<div id="error-message"></div>
	<div id="success-message"></div>

	<!-- START MODAL -->
	<div id="modal">
		<div id="modal-form">
			<h2>Edit Form</h2>
			<table cellpadding="10px" width="100%">
				<tr>
					<td>First Name</td>
					<td><input type="text" id="edit-fname"></td>
				</tr>
				<tr>
					<td>Last Name</td>
					<td><input type="text" id="edit-lname"></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" id="edit-submit" value="Update"></td>
				</tr>
			</table>
			<div id="close-btn">X</div>
		</div>
	</div>

	<!--END MODAL  -->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		function loadTable(){
			$.ajax({
				url:"ajax-load.php",
				type:"POST",
				success:function(data){
					$("#table-data").html(data);
				}

			});
		}
		loadTable();

		//insert 
		$("#save-button").on("click",function(e){
			e.preventDefault();
			var fname = $("#fname").val();
			var lname = $("#lname").val();
			if(fname=="" ||lname==""){
				$("#error-message").html("All Field are required").slideDown();
				$("#success-message").slideUp();
			}else{
			$.ajax({
				url:"ajax-insert.php",
				type:"POST",
				data:{first_name:fname,last_name:lname},
				success:function(data){
					if(data==1){
						loadTable();
						$("#addForm").trigger("reset");
						$("#success-message").html("Data Inserted Successfully").slideDown();
						$("#error-message").slideUp();
					}else{
						$("#error-message").html("Can't save record").slideDown();
						$("#success-message").slideUp();
					}
				}

			});
			}

		});

		//Delete
		$(document).on("click",".delete-btn",function(){
			if(confirm("Do you really want to delete this record")){
			var studentId = $(this).data("id");
			var element = this;
				$.ajax({
					url:"ajax-delete.php",
					type:"POST",
					data:{ id:studentId },
					success:function(data){
						if(data==1){
							$(element).closest("tr").fadeOut();
							
						}else{
							$("#error-message").html("Can't delete record").slideDown();
							$("#success-message").slideUp();		
						}
					}
				});
			}
		});

		//Edit
		//Show Modal
		$(document).on("click",".edit-btn",function(){
			$("#modal").show();
			var studentId = $(this).data("eid");
			$.ajax({
				url:"load-update-form.php",
				type:"POST",
				data:{id:studentId},
				success:function(data){
					$("#modal-form table").html(data);

				}
			});
		});

		$("#close-btn").on("click",function(){
			$("#modal").hide();

		});
		//Save Modal Form
		$(document).on("click","#edit-submit",function(){
			var stuId = $('#edit-id').val();
			var fname = $('#edit-fname').val();
			var lname = $('#edit-lname').val();

			$.ajax({
				url:"ajax-update-form.php",
				type:"POST",
				data:{id:stuId,first_name:fname,last_name:lname},
				success:function(data){
					if(data==1){
						$("#modal").hide();
						loadTable();
						$("#success-message").html("Record Update Successfully").slideDown();
						$("#error-message").slideUp();
					}
				}
			});
		});

		//Live Search 
		$("#search").on("keyup",function(){
			var search_term = $(this).val();
			$.ajax({
				url:"ajax-live-search.php",
				type:"POST",
				data:{search:search_term},
				success:function(data){
					$("#table-data").html(data);
				}
			});
		});
	});
</script>
</body>
</html>