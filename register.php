<?php

	$page_title = 'Register';
	include('includes/header.html');

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$errors = array();

		if(empty($_POST['first_name'])){
			$errors[] = 'you forgot to enter your first name.';
		}else{
			$fn = trim($_POST['last_name']);
		}
		if(empty($_POST['email'])){
			$errors[] = 'you forgot to enter your email address.';
		}else{
			$e = trim($_POST['email']);
		}

  		if (!empty($_POST['pass1'])) {
			if ($_POST['pass1']  != $_POST['pass2']) {
				$errors[] = 'your password did not match the confirmed password.';
			}else{
				$p = trim($_POST['pass1']);
			}
			
		}else{
			$errors[] = 'You forgot to enter you password.';
		}

		if(empty($errors)){
			require('../mysqli_connect.php');

			$q = "INSERT INTO users(first_name, last_name, email, pass, registration_date) VALUES('$fn', '$ln', '$e', SHA1('$p'), NOW())";
			$r = @mysqli_query($dbc, $q);
			if($r){
				echo '<h1> Thank you! </h1>
				<p> you are now registered. In Chapter 12 you will actually be able to log in! </p><p></br></p>';

			}else{
				echo ¿'<h1>System Error</h1>
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
	}

?>

<h1>Register</h1>
<form action="register.php" method="post">
	<p> First Name: <input type="text" name="first_name" size="15" maxlength="20" value="<?php if(isset($_POST['first_name'])) echo $_POST['first_name']; ?>"/></p>
	<p> Last Name: <input type="text" name="last_name" size="15" maxlength="40" value="<?php if(isset($_POST['last_name'])) echo $_POST['last_name']; ?>" /></p>
	<p> Email Address: <input type="email" name="email" size="20" maxlength="60" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" /></p>
	<p> Password: <input type="password" name="pass1" size="15" maxlength="20" value="<?php if(isset($_POST['´pass1'])) echo $_POST['pass1']; ?>" /></p>
	<p> Confirm Password: <input type="password" name="pass2" size="15" maxlength="20" value="<?php if(isset($_POST['pass2'])) echo $_POST['pass2']; ?>" /></p>
	<p><input type="submit" name="submit" value="Register"></p>
</form>
<?php include('include/footer.html'); ?>