##Application is based on Apache, PHP and Sqlite.

##You need to install PHP's mcrypt,mbistring and sqlite library.
  	yum install php-mcrypt
	yum install php-mbstring
	yum install php-sqlite

##Apache user should should be owner of "php-aes" folder.

##The application uses AES-256 algorithm to encrypt/decrypt file. The PHP implementation
  of encryption/decryption has been downloaded from 
  
  https://www.aescrypt.com/
  https://github.com/philios33/PHP-AES-File-Encryption

##The application structure.
  index.php    => Entry point of application. It asks username.
  menu.php     => Shows option to upload,download the file.
  upload.php   => It asks to input user file and secret key. It will upload
                  the file at [Apache Document root]/php-aes/uploads/<username>.
                  The details will be stored in sqlite database. (Table : aes_detail)
  download.php => This file shows all the uploaded files of user who is logged in
                  from index.php. It has two options: (1) Download "Encrypted" file
                  and (2) "Decrypt" and download the file.
                  If you click on option (1) it will ask you to save the encrypted file 
                  in your PC.
                  If you click on option (2) It will ask you for the "secret key" of that
                  file (since the file is encrypted using this secret key). Once you
                  give secret key, you will be redirected to decrypt.php
  decrypt.php  => decrypt.php will have two inputs from download.php. 1) filename 
			      and (2) secretkey.
			      It will search in sqlite database for correctness of these details
			      and will decrypt the file based on secret key. If the decryption is
			      successful it will provide a link to download the decrypted file.
			     
##Features Required:
 - User Authintication module needs to be implemented.
 - The files decrypted by user remains on disk. This should be deleted after download.
 - Directory files listing appears if you access URL like
   http://servername/php-aes/uploads/<username>. This requires some apache setting.
   I am currently working on it.
 - sqlite database stores secret key as is. Some decoding to be done before saving the secret key.
 - Any other feature you feel to add.
 
                  

