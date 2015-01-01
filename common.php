<?php 

	#Constant
		#Connection
			define("login", "monlogin");
			define("password", "mypassword");
			define("adress","mysql:host=localhost;dbname=transactions");
		#Encryption
			define("salt1","udsuyds");
			define("salt2","ubvnvc");
		#MailChecking
			define("syntaxMail","#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#");
		
	#Function used to connect to the database
	function getPdo()
	{
		$db=null;
		try
		{
			$db = new PDO(adress, login, password);
		}
		catch(PDOException $e)
		{
			die($e->getMessage());
		}
		return $db;
		
	}
	
	#function used to encrypt passwords
	string encrypt($password)
	{
		return sha1(salt1.$password.salt2);
	}
	
	
	#Function used to get a user
	function getUser($id_user)
	{
		$db = get_pdo(); #We connect to the database
		$selected_user = $db->prepare
		("SELECT username
		  FROM user
		  WHERE id_user = :id_user");
		$selected_user->bindValue(':id_user',$id_user,PDO::PARAM_INT);
		$selected_user->execute();
		$user=$selected_user->fetch(PDO::FETCH_OBJ);#Ici on récupére un objet user
		return $user
	}
	
	#This function is used to check email syntax
	function checkMail($email)
	{
		return	preg_match(syntaxMail,$email)
	}


?>