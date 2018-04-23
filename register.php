<?php
	session_start();
	$_SESSION['message'] = '';
	$page_title = 'Register';
	include('includes/header.html');

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		require('../mysqli_connect.php');

		$errors = array();

		if(empty($_POST['first_name'])){
			$errors[] = 'you forgot to enter your first name.';
		}else{
			$fn = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
		}

		if(empty($_POST['last_name'])){
			$errors[] = 'you forgot to enter your first name.';
		}else{
			$ln = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
		}

		if(empty($_POST['email'])){
			$errors[] = 'you forgot to enter your email address.';
		}else{
			$e = mysqli_real_escape_string($dbc,trim($_POST['email']));
		}

  		if (!empty($_POST['pass1'])) {
			if ($_POST['pass1']  != $_POST['pass2']) {
				$errors[] = 'your password did not match the confirmed password.';
			}else{
				$p = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
			}
			
		}else{
			$errors[] = 'You forgot to enter you password.';
		}

		if(empty($errors)){

			$q = "INSERT INTO users(first_name, last_name, email, pass, registration_date) VALUES('$fn', '$ln', '$e', SHA1('$p'), NOW())";
			$r = @mysqli_query($dbc, $q);
			if($r){
				echo '<h1> Thank you! </h1>
				<p> you are now registered. In Chapter 12 you will actually be able to log in! </p><p></br></p>';

			}else{
				echo '<h1>System Error</h1>
				<p class="error"> You could not be registered due to a system error. We apolozige for any inconvenience.</p>';

				echo '<p>' . mysqli_error($dbc) . '<br /><br />Query : ' . $q . '</p>';
			}

			mysqli_close($dbc);
			include('includes/footer.html');
			exit();

		}else{

			echo '<h1>Error!</h1>
			<p class="error">The following error(s) occurred:<br />';
			foreach ($errors as $msg) {
				echo " - $msg<br />\n";
			}
			echo '</p><p>Please try again.</p><p><br /></p>';
		}
		mysqli_close($dbc);
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width-device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
		<title> Bootstrap and php</title>
</head>
<body>
	<div class="container">
		<h1>Register</h1>
		<form id="container" method="post" action="register.php" enctype="multipart/form-data" autocomplete="off">
			<div class="alert alert-error"> <?=  $_SESSION["message"] ?> </div>
			<div class="form-group col-md-6">
				<label for="InputName">First Name</label><br/>
				<input type="text" name="first_name" size="15" maxlength="20" value="<?php if(isset($_POST['first_name'])) echo $_POST['first_name']; ?>"/>
			</div>

			<div class="form-group col-md-6">
				<label for="InputLastName">Last Name</label><br/>
				<input type="text" name="last_name" size="15" maxlength="20" value="<?php if(isset($_POST['last_name'])) echo $_POST['last_name']; ?>"/>
			</div>

			<div class="form-group col-md-6">
				<label for="InputEmail">Email</label><br/>
				<input type="email" name="email" size="15" maxlength="20" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>"/>
			</div>

			<div class="form-group col-md-6">
				<label for="InputPassword">Password</label><br/>
				<input type="password" name="pass1" size="15" maxlength="20" value="<?php if(isset($_POST['pass1'])) echo $_POST['pass1']; ?>"/>
			</div>

			<div class="form-group col-md-6">
				<label for="InputConfirmPassword">Confirm Password</label><br/>
				<input type="password" name="pass2" size="15" maxlength="20" value="<?php if(isset($_POST['pass2'])) echo $_POST['pass2']; ?>"/>
			</div>
			<button type="submit" class="btn btn-primary col-md-6">Submit</button>

		</form>
		<?php include('includes/footer.html'); ?>
	</div>
</body>


