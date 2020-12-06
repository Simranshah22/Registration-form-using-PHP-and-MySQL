<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Forgot password form</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="header">
		<h2>Forgot password</h2>
	</div>

	<form method="post" action="forgot.php">

		<?php include('errors.php'); ?>

	<div class="input-group">
		<label>Username:</label>
		<input type="text" name="username" >
	</div>

	<div class="input-group">
		<label>What is your school name?</label>
		<input type='text' name='answer'>
	</div>

	<div class="input-group">
		<label>Your new password:</label>
		<input type='password' name='newpassword'>
	</div>

	<div class="input-group">
		<label>Re-enter your new password:</label>
		<input type='password' name='confirmnewpassword'>
	</div>

	<div class="input-group">
		<button type="submit" class="btn" name="forgot_user">Forgot password</button>
	</div>

</body>