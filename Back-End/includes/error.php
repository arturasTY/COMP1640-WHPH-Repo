<?php include_once "helpers.inc.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">
<link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<title>Error</title>
<style>
    body {
        font-family: 'Roboto', sans-serif;
    }
    #id01 {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: #2C363F;
}

.contain {
    width: 500px;
    padding-top: 2em;
    margin: auto;
    display: flex;
    background: #dc3545;
    flex-direction: column;
    justify-content: center;
    color: white;
    align-items: center;
    box-shadow: 0px 10px 20px 0px rgba(0,0,0,0.2);
}

.bl {
    background: white;
    width: 100%;
    text-align: center;
    margin-top: 1em;
}

.bl > p {
    margin: 0;
    color: #dc3545;
    padding: 1em 0;
    font-weight: 700;
}

.contain h1 {
    text-transform: uppercase;
}

.contain .error {
  
}

.error-icon i {
    color: white;
    font-size: 2.75em;
}

</style>
</head>
<body style="margin: 0;">
	<div id="id01" class="modal success">
		<div class="modal-content">
			<div class="contain">
                <span class="error-icon"><i class="ion-android-warning"></i></span>
				<h1 class="sc">Log In Failed</h1>
				<p class="error"><?php html($error); ?></p>
                <div class="bl">
                    <p class="sc">Please Try again</p>
                </div>
			</div>
		</div>
		
	</div>

	<script>
        
		setTimeout (function() {
       		window.location.href = "."; //redirect to home page after 3seconds
    	},  2500);
	</script>
</body>
</html>
