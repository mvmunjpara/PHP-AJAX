<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>PHP AJAX</title>
</head>
<body>
<table id="main" border="0" cellspacing="0">
	<tr id="header">
		<h1>PHP With AJAX</h1>
	</tr>
	<tr>
		<td id="table-load">
			<input type="button" id="load-button" value="Load Data">
		</td>
	</tr>
	<tr>
		<td id="table-data">
			<table border="0" width="100%" cellspacing="0" cellpadding="10px">
				<tr>
					<th>Id</th>
					<th>Name</th>
				</tr>
			</table>
		</td>
	</tr>
</table>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#load-button").on("click",function(e){
			e.preventDefault();
			$.ajax({
				url:"ajax-load.php",
				type:"POST", 
				success:function(data){
					$("#table-data").html(data);
				}
			});
		});
	});
</script>
</body>
</html>
