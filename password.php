<?php
    $page_title = 'Change Your Password';
    include('includes/header.html');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
   	 require('../mysqli_connect.php');
   	 $errors = array();

   	 if(empty($_POST['email'])){
   		 $errors[] = 'You forgot to enter your email address';
   	 }else{
   		 $e = mysqli_real_escape_string($dbc, trim($_POST['email']));
   	 }

   	 if(empty($_POST['pass'])){
   		 $errors[] = 'you forgot to enter your password';
   	 }else{
   		 $p = mysqli_real_escape_string($dbc, trim($_POST['pass']));
   	 }

   	 if(!empty($_POST['pass1'])){
   		 if($_POST['pass1'] != $_POST['pass2']){
   			 $errors[] = 'your new password did not match the confirmed password';
   		 }else{
   			 $np = mysqli_real_escape_string($dbc, $_POST['pass1']);
   		 }
   	 }else{
   		 $errors[] = 'you forgot to enter your new passwords';
   	 }

   	 if(empty($errors)){
   		 $q = "SELECT user_id FROM users WHERE (email='$e' AND pass=SHA1('$p'))";
   		 $r = @mysqli_query($dbc, $q);
   		 $num = @mysqli_num_rows($r);

   		 if($num == 1){
   			 $row = mysqli_fetch_array($r, MYSQLI_NUM);
   			 $q = "UPDATE users SET pass=SHA1('$np') WHERE user_id = $row[0]";
   			 $r = @mysqli_query($dbc, $q);

   			 if(mysqli_affected_rows($dbc) == 1){
   				 echo '<h1> Thank you! </h1>
   				 <p> your password has been updated, In chapter 12 you will be able to log in!</p><p><br /></p>';
   			 }else{
   				 echo '<h1>System Error </h1>
   				 <p class="error">Your password could not be changed due to a system error. we apologize for any incovenience.</p>';
   				 echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
   			 }

   			 mysqli_close($dbc);
   			 include('includes/footer.html');
   			 exit();
   		 }else{
   			 echo  '<h1> Error!</h1>
   			 <p class="error"> The email address and password do not  match those on file.</p>';
   		 }
   	 }else{
   		 echo '<h1>Error!</h1>
   		 <p class="error"> The following error(s) occurred :<br />';
   		 foreach ($errors as $msg) {
   		      echo  " - $msg<br />\n";
   		 }
   		 echo "</p><p> Please try again.</p><p><br /></p>";
   	 }

   	 mysqli_close($dbc);
    }
?>

<h1>Change your password</h1>
<form action="password.php" method="post">
    <p>Email Address : <input type="text" name="email" size="20" maxlength="60" value="<?php if(isset($_POST['email'])) echo $_POST['email'] ;?>" /></p>

    <p>Current Password : <input type="password" name="pass" size="20" maxlength="60" value="<?php if(isset($_POST['pass'])) echo $_POST['pass'] ;?>" /></p>

    <p>New Password : <input type="password" name="pass1" size="20" maxlength="60" value="<?php if(isset($_POST['pass1'])) echo $_POST['pass1'] ;?>" /></p>

    <p>Confirm new password : <input type="password" name="pass2" size="20" maxlength="60" value="<?php if(isset($_POST['pass2'])) echo $_POST['pass2'] ;?>" /></p>
    
    <p><input type="submit" name="submit" value="Change Password" /></p>   	 
</form>
<?php include('includes/footer.html'); ?>
















