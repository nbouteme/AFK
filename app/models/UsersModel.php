<?php

class Users
{
	public static function create($data)
	{
		extract($data);
		$query = Database::$PDO->prepare('INSERT INTO USERS (CIVILITE, EMAIL, NOM, PRENOM, PASSWORD, PSEUDO)
										  VALUES(?, ?, ?, ?, ?, ?)');
		$query->execute([
			$civilite,
			$email,
			$nom,
			$prenom,
			$password,
			$pseudo,]);
	}

    private static function getQueryAttribute($id, $attribute)
    {
        if(filter_var($id, FILTER_VALIDATE_EMAIL))
            return Database::$PDO->prepare("SELECT $attribute FROM USERS WHERE EMAIL = ?");
        else
            return Database::$PDO->prepare("SELECT $attribute FROM USERS WHERE PSEUDO = ?");
    }

    public static function getPassword($id)
    {
        $query = self::getQueryAttribute($id, 'PASSWORD');
		$query->execute([$id]);
        return $query->fetch()['PASSWORD'];
    }

    public static function getUserName($id)
    {
        $query = self::getQueryAttribute($id, 'PSEUDO');
		$query->execute([$id]);
        return $query->fetch()['PSEUDO'];
    }

	public static function exists($id)
	{
        $query = self::getQueryAttribute($id, 'COUNT(*)');
		$query->execute([$id]);
        return $query->columnCount() === 1;
	}

    public static function getDescription($id)
    {
        $query = self::getQueryAttribute($id, 'IDUSERDESC');
        $query->execute([$id]);
        if($query->columnCount() !== 1)
            die('Couldn\'t find description in database');
        $query2 =  Database::$PDO->prepare("SELECT $attribute FROM USERS WHERE PSEUDO = ?");
    }
    
}
