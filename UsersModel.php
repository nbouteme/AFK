<?php
	class UsersModel
	{
		public static function getPassword ($user)
		{
			$db=getPdo();
			$query = "SELECT password FROM USER WHERE userId = :userId  OR email = :email";
			try
			{
				$submit->execute(array(':userId' => $user->userId, ':email' => $user -> email));
				$result = $submit -> fetch();
				return $result["password"];
			}
			catch(PDOException $exception)
			{
				$exception.getMessage();
				die($exception);
			}
		}
		
		public static function userExist($user)
		{
			$db=getPdo();
			$query="SELECT * FROM USER WHERE userId = :userId  OR email = :email";
			try
			{
				$submit->execute(array(':userId' => $user->userId,'email' => $user->email));
				return $submit->rowCount();  
			}
			catch(PDOException $exception)
			{
				$exception.getMessage();
				die($exception);
			}
			
		}
		
		public static function addUserDataBase($user)
		{
			$db=getPdo();
			$registrationDate=date(d-m-y);
			$query="INSER INTO user(userId,sexe,firstName,lastName,email,registrationDate,password,birthday)
			VALUES('',:sexe,:firstName,:lastName,:email,:registrationDate,:password,:birthday)";
			try
			{
				$submit = $db->prepare($query);
				$submit->execute(array(':sexe' => $user->sexe,
				':firstName' => $user->firstName,
				':lastName' => $user->lastName,
				':email' => $user->email,
				':registrationDate' => $user->registrationDate,
				':password' => $user->password,
				':birthday' => $user->birthday ));
			}
			catch (PDOException $exception)
			{
				$exception->getMessage();
				die($exception);
			}
		}	
		
	}
?>	
				