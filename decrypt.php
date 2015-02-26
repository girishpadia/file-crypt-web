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
	<h1 align='center'>Welcome to PHP-AES </h1>
	<?php
	//yum install php-mcrypt
	//yum install php-mbstring
	session_start();
	if(!isset($_SESSION['sid']) || $_SESSION['sid'] != SID)
	{
		echo "Please enter your username first.";
		exit;
	}
	$username = $_SESSION['username'];

	$file = filter_input(INPUT_POST,'filename');
	$secretkey = filter_input(INPUT_POST,'secretkey');
	
	//echo $file;
	
	$db = new SQLite3('aes.sqlite') or die ("Unable to open database");
	$result = $db->query("select count(*) as total  from aes_detail where username = '$username' and filepath='$file' and secretkey='$secretkey'")->fetchArray() or die ("query failed");
	if($result['total'] == 1)
	{
			if (!file_exists($file)) 
			{
				echo "Something wrong with the file";
				exit;
			}

		//Include the library
		require_once 'AESCryptFileLib.php';

		//Include an AES256 Implementation
		require_once 'aes256/MCryptAES256Implementation.php';

		//Construct the implementation
		$mcrypt = new MCryptAES256Implementation();

		//Use this to instantiate the encryption library class
		$lib = new AESCryptFileLib($mcrypt);

		//Ensure file does not exist
//		@unlink($decrypted_file);
		//Decrypt using same password
		$decrypted_file = rtrim($file,".aes");
		$lib->decryptFile($file, $secretkey, $decrypted_file);
		?>
		<a href='<?php echo $decrypted_file; ?>' download>Click here to download Decrypted file</a></br>
		<?php
	}
	?>

<a href='menu.php'>Go back</a>
</body>
</html>
