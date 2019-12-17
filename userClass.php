<?php
class userClass
{
/* User Login */
public function userLogin($usernameEmail,$password)
{
try{
/*	
$db = getDB();
$hash_password= hash('sha256', $password); //Password encryption 
$stmt = $db->prepare("SELECT uid FROM users WHERE (username=:usernameEmail or email=:usernameEmail) AND password=:hash_password"); 
$stmt->bindParam("usernameEmail", $usernameEmail,PDO::PARAM_STR) ;
$stmt->bindParam("hash_password", $hash_password,PDO::PARAM_STR) ;
$stmt->execute();
$count=$stmt->rowCount();
$data=$stmt->fetch(PDO::FETCH_OBJ);
$db = null;
if($count)
{
$_SESSION['uid']=$data->uid; // Storing user session value
$_SESSION['google_auth_code']=$google_auth_code; //Stroing Google authentication code
return true;
}
else
{
return false;
} 
*/
$link=new mysqli("localhost","root","","authentication");
$res=$link->query("SELECT uid FROM users WHERE (username='$usernameEmail' or email='$usernameEmail') AND password='$password'");
if ($res->num_rows>0)
{
	$_SESSION['uid']=$data->uid; // Storing user session value
	$_SESSION['google_auth_code']=$google_auth_code; //Stroing Google authentication code
	return true;
}

else
{
	return false;
}



}
catch(PDOException $e) {
echo '{"error":{"text":'. $e->getMessage() .'}}';
}

}

/* User Registration */
public function userRegistration($username,$password,$email,$name,$secret)
{
try{

/*	
 global $db;
 $db=getDB();
$st = $db->prepare("SELECT uid FROM users WHERE username=:username OR email=:email"); 
$st->bindParam("username", $username,PDO::PARAM_STR);
$st->bindParam("email", $email,PDO::PARAM_STR);
$st->execute();
$count=$st->rowCount();
if($count<1)
{
$stmt = $db->prepare("INSERT INTO users(username,password,email,name,google_auth_code) VALUES (:username,:hash_password,:email,:name,:google_auth_code)");
$stmt->bindParam("username", $username,PDO::PARAM_STR) ;
$hash_password= hash('sha256', $password); //Password encryption
$stmt->bindParam("hash_password", $hash_password,PDO::PARAM_STR) ;
$stmt->bindParam("email", $email,PDO::PARAM_STR) ;
$stmt->bindParam("name", $name,PDO::PARAM_STR) ;
$stmt->bindParam("google_auth_code", $secret,PDO::PARAM_STR) ;
$stmt->execute();
$uid=$db->lastInsertId(); // Last inserted row id
$db = null;
*/

$link=new mysqli("localhost","root","","authentication");
$res=$link->query("SELECT uid from users where username='$username' or email='$email'");

if ($res->num_rows>0)
{
	return false;
}

else
{

	$link->query("INSERT INTO users(username,password,email,name,google_auth_code) VALUES ('$username','$password','$email','$name','$secret')");

	$row=$res->fetch_assoc();  //fetched value from res of UID  

	$uid=$row['uid']; 
	$_SESSION['uid']=$uid;
	return true;
}

/*else
{
$db = null;
return false;
}
*/
} 

catch(PDOException $e) 
{
	echo '{"error":{"text":'. $e->getMessage() .'}}'; 
}
}

/* User Details */
public function userDetails($uid)
{
		try{
				/*
				$db = getDB();
				$stmt = $db->prepare("SELECT email,username,name,google_auth_code FROM users WHERE uid=:uid");
				$stmt->bindParam("uid", $uid,PDO::PARAM_INT);
				$stmt->execute();
				$data = $stmt->fetch(PDO::FETCH_OBJ); //User data
				*/
				$link=new mysqli("localhost","root","","authentication");
				$res=$link->query("SELECT * from users where uid='$uid'");
				$row=$res->fetch_assoc();  //fetched value from res of UID  

				$a=$row['google_auth_code'];
				$b=$row['name'];
				$c=$row['email'];
				$data=array($a,$b,$c); 
				
				return $data;
			}
		catch(PDOException $e) 
			{
				echo '{"error":{"text":'. $e->getMessage() .'}}';
			}
}

public function userName($uid)
{
	$link=new mysqli("localhost","root","","authentication");
	$res=$link->query("SELECT * from users where uid='$uid'");
	$row=$res->fetch_assoc();  //fetched value from res of UID  

	$temp=$row['name'];

	return $temp;
}

public function usercode($uid)
{
	$link=new mysqli("localhost","root","","authentication");
	$res=$link->query("SELECT * from users where uid='$uid'");
	$row=$res->fetch_assoc();  //fetched value from res of UID  

	$temp=$row['google_auth_code'];

	return $temp;
}

public function useremail($uid)
{
	$link=new mysqli("localhost","root","","authentication");
	$res=$link->query("SELECT * from users where uid='$uid'");
	$row=$res->fetch_assoc();  //fetched value from res of UID  

	$temp=$row['email'];

	return $temp;
}


}
?>