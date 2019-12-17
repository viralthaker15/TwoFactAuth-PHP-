<!DOCTYPE html>
<html>
<head>
	<title>SIGNUP</title>
</head>
<body>


<?php

include("config.php");
	if(!empty($_SESSION['uid']))
	{
		header("Location: device_confirmations.php");
	}
include('userClass.php');
$userClass = new userClass();

require_once 'GoogleAuthenticator.php';
$ga = new GoogleAuthenticator();    // initiliaze the authenticator class
$secret = $ga->createSecret();      //This function will create unique 16 digit secret key

$errorMsgReg=''; //error msg for reg
$errorMsgLogin=''; //error msg for login

if (isset($_REQUEST['sub'])) //checks if user has clicked submit button(login or signup)
{
	$sub=$_REQUEST['sub'];
	/* Signup Form */
	if ($sub=="signup") 
	{
		$username=$_REQUEST['t1'];
		$email=$_REQUEST['em'];
		$password=$_REQUEST['pwd'];
		$name=$_REQUEST['na'];

		/* Regular expression check */
		$username_check = preg_match('~^[A-Za-z0-9_]{3,20}$~i', $username);
		$email_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $email);
		$password_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $password);


		
		$uid=$userClass->userRegistration($username,$password,$email,$name,$secret); //calling userclass method
			if($uid) //if uid returns true
			{
				echo "SIGNUP SUCCESSFULL !!!";
				$url='home.php';
				header("Location: $url"); // Page redirecting to home.php 
			}
			else
			{
				$errorMsgReg="Username or Email already exists.";
				echo $errorMsgReg;
			}
		


	}

}

else
{

?>



				<form action="<?php $_SERVER['PHP_SELF']; ?>">
			<br><br><br><br><br>
			<br><br><br><br><br>
			<table align="center" border="5" style="background: black;" cellspacing="5" cellpadding="10">
			<tr style="color: white" align="center"><td colspan="3"><font size="15" color="lime">SIGNUP</font></td></tr>		
			<tr align="center" style="color:white"><td colspan="3">USERNAME : <input type="text" name="t1"></td></tr>
			<tr align="center" style="color:white"><td colspan="3">PASSWORD : <input type="password" name="pwd"><br><br></td></tr>
			<tr align="center" style="color:white"><td colspan="3">EMAIL : <input type="text" name="em"><br><br></td></tr>
			<tr align="center" style="color:white"><td colspan="3">NAME : <input type="text" name="na"><br><br></td></tr>
			<tr align="center"></tr>
			<td><input type="submit" class="button" name="sub" value="signup"></td>
			<td><input type="reset" class="button" name="res" value="CANCEL"></td>	
	</form>


<?php

}

?>

</body>
</html>