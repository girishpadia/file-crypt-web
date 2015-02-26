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
<script language='javascript'>
function decrypt(filename)
{
	alert(filename);
	var secretkey = prompt("Please give secretkey for file "+filename);
	alert(secretkey);
	
	
	var form = document.createElement("form");
	var element1 = document.createElement("input");
	var element2 = document.createElement("input");
	
	form.method = "POST";
	form.action = "decrypt.php"
	
	element1.name='filename';
	element1.value = filename;
	form.appendChild(element1);
	
	element2.name='secretkey';
	element2.value = secretkey;
	form.appendChild(element2);
	
	
	document.body.appendChild(form);
	
	form.submit();
	
	//window.location.href = "decrypt.php?file="+filename+"&secretkey="+secretkey;
}
</script>
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

	$db = new SQLite3('aes.sqlite') or die ("Unable to open database");
	$result = $db->query("select * from aes_detail where username = '$username'") or die ("query failed");
	?>
	<table width=90% align="center" border="1px">
		<thead>
			<th>File Name</th>
			<th>Download encrypted file</th>
			<th>Decrypt and Download file</th>
		</thead>
		<tbody>
		<?php
		while ($row = $result->fetchArray()) 
		{
			//echo basename(dirname($_SERVER['PHP_SELF']));
			?>
			<tr>
				<td align='center'><?php echo basename($row['filepath']); ?></td>
				<td align='center'><a href='<?php echo $row['filepath']; ?>' download>Download Encrypted file</a></td>
				<td align='center'><a href='javascript:decrypt("<?php echo $row['filepath']; ?>");'>Decrypt and Download file</td>
			</tr>
			<?php
		}
?>		
		</tbody>
	</table>
	
<?php	

	if(isset($_POST['submit']))
	{
		$secretkey = $_POST['secretkey'];

		if (!file_exists("/var/www/php-aes/uploads/$username")) 
		{
			mkdir("/var/www/php-aes/uploads/$username", 0777, true);
		}
		
		$uploaddir = "/var/www/php-aes/uploads/$username/";
		$uploadfile = $uploaddir . basename($_FILES['upfile']['name']);
//		echo $_FILES['upfile']['tmp_name'];
		if (move_uploaded_file($_FILES['upfile']['tmp_name'], $uploadfile)) 
		{
			echo "File is valid, and was successfully uploaded.\n";
		} 
		else 
		{
			echo "Possible file upload attack!\n";
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

		//This example encrypts and decrypts the README.md file
		$file_to_encrypt = $uploadfile ;
		$encrypted_file = $uploadfile .".aes";
//		$decrypted_file = "README.decrypted.txt";

		//Ensure target file does not exist
		@unlink($encrypted_file);
		//Encrypt a file
		$lib->encryptFile($file_to_encrypt, $secretkey, $encrypted_file);

        $db = new SQLite3('aes.sqlite') or die ("Unable to open database");
        $result = $db->query("insert into aes_detail values ('$uploadfile','$secretkey',datetime('now'),'$username')") or die ("query failed");
   
		//Ensure file does not exist
//		@unlink($decrypted_file);
		//Decrypt using same password
//		$lib->decryptFile($encrypted_file, "1234", $decrypted_file);

		echo "File is encrypted.";
	}
	
	?>


<a href='menu.php'>Go back</a>
</body>
</html>
