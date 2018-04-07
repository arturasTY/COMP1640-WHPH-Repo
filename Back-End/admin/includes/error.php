<?php include_once "includes/helpers.inc.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Error</title>
	<link rel="stylesheet" type="text/css" href="css/forms.css">
</head>
<body>
	<div id="id01" class="modal success" style="background: red;">
		<div class="modal-content">
			<div class="container">
				<h1 class="sc">Sorry</h1>
				<p class="scp"><?php html($error); ?></p>
				<p class="sc">Please Try again</p>
			</div>
		</div>
		
	</div>

	<script>
		setTimeout (function() {
       		window.location.href = "."; //redirect to home page after 3seconds
    	},  4000);
	</script>
</body>
</html>