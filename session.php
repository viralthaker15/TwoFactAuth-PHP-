<?php
if(!empty($_SESSION['uid']) && !empty($_SESSION['googleCode']))
{
$session_uid=$_SESSION['uid'];
$session_googleCode=$_SESSION['googleCode'];
}
if(empty($session_uid) && empty($session_googleCode))
{
$url='index.php';
header("Location: $url");
}
?>
