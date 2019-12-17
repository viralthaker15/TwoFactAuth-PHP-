<?php
include('config.php');
include('userClass.php');
$userClass = new userClass();
$userDetails=$userClass->userDetails($_SESSION['uid']);

if($_POST['code'])
{
$code=$_POST['code'];
//$secret=$userDetails->google_auth_code;
$secret=$userDetails[0];
require_once 'GoogleAuthenticator.php';
$ga = new GoogleAuthenticator();
$checkResult = $ga->verifyCode($secret, $code, 2);    // 2 = 2*30sec clock tolerance

if ($checkResult)
{
$_SESSION['googleCode']=$code;
}
else
{
echo 'FAILED';
}
}

include('session.php');
$userDetails=$userClass->userDetails($session_uid);
?>

<h1>Welcome <?php echo $userDetails[1]; ?></h1>
<h2> Email <?php echo $userDetails[2]; ?></h2>
<a href="<?php echo BASE_URL; ?>logout.php">Logout</a>
