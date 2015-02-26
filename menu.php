<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Welcome to PHP-AES</title>
<style rel="stylesheet" style='text/css'>
	body {
    color: #555;
    font: 10pt Arial,Helvetica,Verdana,"DejaVu Sans","Bitstream Vera Sans",Geneva,sans-serif;
}
</style>
</head>
<body>
<?php
	session_start();
	if(!isset($_SESSION['sid']) || $_SESSION['sid'] != SID)
	{
		echo "Please enter your username first.";
		exit;
	}
	
	if(isset($_POST['Enter']))
	{
		$_SESSION['username'] = $_POST['username'];
	}
//	$username = $_SESSION['username'];
?>
<p>
	<a href='upload.php'>Upload and Encrypt the file.</a><br />
	<a href='download.php'>Download and Decrypt the file.</a>
</p>
