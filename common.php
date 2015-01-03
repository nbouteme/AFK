<?php 
//Connection
define("LOGIN", "monlogin");
define("PASSWORD", "mypassword");
define("ADRESS","mysql:host=localhost;dbname=transactions");
//Encryption
define("salt1","udsuyds");
define("salt2","ubvnvc");
//MailChecking
define("syntaxMail","#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#");
//Function used to connect to the database
function getPdo()
{
	$db = null;
	try
	{
		$db = new PDO(ADRESS, LOGIN, PASSWORD);
	}
	catch(PDOException $e)
	{
		die($e->getMessage());
	}
	return $db;
		
}
//function used to encrypt passwords
encrypt($password)
{
	return sha1(salt1.$password.salt2);
}	
//This function is used to check email syntax
function checkMail($email)
{
	return	preg_match(syntaxMail,$email);
}


?>