<?php
	session_start();

	// variable declaration
	$username = "";
	$email    = "";
	$errors = array();
	$_SESSION['success'] = "";

	// connect to database
	$db = mysqli_connect('localhost', 'root', '', 'registration');

	// REGISTER USER
	if (isset($_POST['reg_user'])) {
		// receive all input values from the form
		$username1= mysqli_real_escape_string($db, $_POST['username']);
		$query1 = "SELECT * FROM users WHERE username='$username1'";
		$result1= mysqli_query($db,$query1);
		if(mysqli_num_rows($result1)==1){
			array_push($errors, "Username is taken");
		}

		$email1= mysqli_real_escape_string($db, $_POST['email']);
		$query2 = "SELECT * FROM users WHERE email='$email1'";
		$result2= mysqli_query($db,$query2);
		if(mysqli_num_rows($result2)==1){
			array_push($errors, "Email is taken");
		}

		$username = mysqli_real_escape_string($db, $_POST['username']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
		$answer = mysqli_real_escape_string($db, $_POST['answer']);

		// form validation: ensure that the form is correctly filled
		if (empty($username)) { array_push($errors, "Username is required"); }
		if (empty($email)) { array_push($errors, "Email is required"); }
		if (empty($password_1)) { array_push($errors, "Password is required"); }
		if (empty($answer)) { array_push($errors, "Answer the question please"); }

		if ($password_1 != $password_2) {
			array_push($errors, "The two passwords do not match");
		}

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5($password_1);//encrypt the password before saving in the database
			$query = "INSERT INTO users (username, email, password, answer)
					  VALUES('$username', '$email', '$password','$answer')";
			mysqli_query($db, $query);

			$_SESSION['username'] = $username;
			$_SESSION['success'] = "";
			header('location: login.php');
		}

	}

	// LOGIN USER
	if (isset($_POST['login_user'])) {
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		if (count($errors) == 0) {
			$password = md5($password);
			$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1) {
				$_SESSION['username'] = $username;
				$_SESSION['success'] = "You are now logged in";
				header('location: index.php');
			}else {
				array_push($errors, "Wrong username/password combination");
			}
		}
	}

	// FORGOT Password
	if (isset($_POST['forgot_user'])) {
		$answer = mysqli_real_escape_string($db, $_POST['answer']);
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$newpassword = mysqli_real_escape_string($db, $_POST['newpassword']);
		$confirmnewpassword = mysqli_real_escape_string($db, $_POST['confirmnewpassword']);

		if (empty($answer)) {array_push($errors, "You need to answer security question");}
		if (empty($username)) {array_push($errors, "Invalid username");}
		if (empty($newpassword)) {array_push($errors, "Enter valid password");}

		if ($newpassword != $confirmnewpassword) {array_push($errors, "passwords do not match");}

		if (count($errors) == 0) {
			$query = "SELECT * FROM users WHERE answer='$answer' AND username='$username'";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1) {

				$newpassword = md5($newpassword);
				$sql = "UPDATE user_info SET password='$newpassword' where user_id='$username'";
				mysqli_query($db, $sql);

				$_SESSION['username'] = $username;
				$_SESSION['success'] = "You changed your password";
				header('location: forgotindex.php');
			}else {
				array_push($errors, "Wrong Username or enter a valid answer");
			}
		}
	}

?>