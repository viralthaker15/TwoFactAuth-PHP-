<!DOCTYPE html>
<html>
<head>
	<title>INDEX</title>
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
	/* Login Form code */
	if ($sub=="login") 
	{
		$usernameEmail=$_REQUEST['t1'];
		$password=$_REQUEST['pwd'];

		$link=new mysqli("localhost","root","","authentication");
		$res=$link->query("SELECT * FROM users WHERE (username='$usernameEmail' or email='$usernameEmail') AND password='$password'");
		if ($res->num_rows>0)
		{
			$row=$res->fetch_assoc();
			$_SESSION['uid']=$row['uid']; // Storing user session value
			$_SESSION['google_auth_code']=$row['google_auth_code']; //Stroing Google authentication code
				$url='home.php';
				header("Location: $url"); // Page redirecting to home.php 
		}	

		else
		{
				$errorMsgLogin="Please check login details.";
				echo $errorMsgLogin;
		}
			/*$uid=$userClass->userLogin($usernameEmail,$password); //authenticates using userclass method 
			
			if($uid)
			{
				echo "hello";
				$url='home.php';
				header("Location: $url"); // Page redirecting to home.php 
			}
			else
			{	
				$errorMsgLogin="Please check login details.";
				echo $errorMsgLogin;
			}*/
		
	}	
}

else
{

?>


	<form action="<?php $_SERVER['PHP_SELF']; ?> ">
			<br><br><br><br><br>
			<br><br><br><br><br>
			<table align="center" border="5" style="background: black;" cellspacing="5" cellpadding="10">
			<tr style="color: white" align="center"><td colspan="3"><font size="15" color="lime">LOGIN</font></td></tr>		
			<tr align="center" style="color:white"><td colspan="3">USERNAME : <input type="text" name="t1"></td></tr>
			<tr align="center" style="color:white"><td colspan="3">PASSWORD : <input type="password" name="pwd"><br><br></td></tr>
			<tr align="center" style="color:white"><td colspan="3"><input type="checkbox" name="keep" value="keep me"> KEEP ME LOGGED IN...........</td></tr>
			<tr align="center"></tr>
			<td><input type="submit" class="button" name="sub" value="login"></td>
			<td><input type="reset" class="button" name="res" value="CANCEL"></td>	
		<br><br>


	</form>

	<a href="signup.php">SIGNUP</a>
<?php

}

?>

</body>
</html>