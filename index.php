<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Welcome to PHP-AES</title>
<style rel="stylesheet" style='text/css'>
	body {
    color: #555;
    font: 10pt Arial,Helvetica,Verdana,"DejaVu Sans","Bitstream Vera Sans",Geneva,sans-serif;
}
#centered{
	border: 1px solid #C9E0ED;
	width:200px;
	height:100px;
	margin: 50px auto;
    padding: 20px 10px 10px;	
	position:absolute;
    text-align: center;	
	top:25%;
	left:45%;       
}

</style>
</head>
<body>
	<?php
		session_start();
		$_SESSION['sid'] = SID;
	?>
	<div id="centered">
		<form id="username" action="menu.php" method="post">	
			<p>Please enter your username</p>
			<input name="username" id="username" type="password" />	
			<input type="submit" name="Enter" value="Enter" />
		</form>
	</div>
</body>
</html>
